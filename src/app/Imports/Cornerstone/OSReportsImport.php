<?php

namespace RLI\Booking\Imports\Cornerstone;

use RLI\Booking\Actions\{GenerateVoucherAction, PersistContactAction, UpdateOrderAction};
use Maatwebsite\Excel\Concerns\{ToModel, WithGroupedHeadingRow, WithHeadingRow};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use RLI\Booking\Classes\{SKU, UnitType};
use Illuminate\Support\{Carbon, Str};
use RLI\Booking\Models\Voucher;
use RLI\Booking\Models\{Order, SellerCommission};

HeadingRowFormatter::default('cornerstone-os-report-1');

class OSReportsImport implements ToModel, WithHeadingRow, WithGroupedHeadingRow
{
    public function model(array $row): ?Voucher
    {
        if (!isset($row['project_code'])) {
            return null;
        }

        $attribs  = [
            'first_name' => Str::title($row['buyer_first_name']),
            'middle_name' => Str::title($row['buyer_middle_name']) ?: 'Missing',
            'last_name' => Str::title($row['buyer_last_name']),
            'civil_status' => Str::title($row['buyer_civil_status']),
            'sex' => Str::title($row['buyer_gender']),
            'nationality' => Str::title($row['buyer_nationality']),
            'date_of_birth' => Carbon::createFromDate(Date::excelToDateTimeObject($row['buyer_birthday'])), //TODO: update this
            'email' => strtolower($row['buyer_principal_email']),
            'mobile' => (string) $row['buyer_primary_contact_number'], //TODO: update this
            'addresses' => [
                [
                    'type' => 'primary',
                    'ownership' => Str::title($row['buyer_ownership_type']),
                    'full_address' => null,
                    'address1' => Str::title($row['buyer_street']),
                    'address2' => null,
                    'sublocality' => Str::title($row['buyer_barangay']),
                    'locality' => Str::title($row['buyer_city']),
                    'administrative_area' => Str::title($row['buyer_province']),
                    'postal_code' => null,
                    'sorting_code' => null,
                    'country' => 'PH',
                ],
            ],
            'employment' => [
                'employment_status' => Str::title($row['buyer_employer_status']),
                'monthly_gross_income' => (string) $row['buyer_salary_gross_income'],
                'current_position' => Str::title($row['buyer_position']),
                'employment_type' => Str::title($row['buyer_employer_type']),
                'employer' => [
                    'name' => Str::title($row['buyer_employer_name']),
                    'industry' => Str::title($row['industry']),
                    'nationality' => 'PH',
                    'contact_no' => (string) $row['buyer_employer_contact_number'],
                    'address' => [
                        'type' => 'work',
                        'ownership' => 'N/A',
                        'full_address' => Str::title($row['buyer_employer_address']),
                        'address1' => Str::title($row['buyer_street']),
                        'address2' => null,
                        'sublocality' => null,
                        'locality' => Str::title($row['buyer_employer_city']),
                        'administrative_area' => Str::title($row['buyer_employer_province']),
                        'postal_code' => '1111', //TODO: update this
                        'sorting_code' => null,
                        'country' => 'PH',
                    ],
                ],
                'id' => [
                    'tin' => (string) $row['buyer_tax_identification_number'],
                    'sss' => (string) $row['buyer_sss_gsis_number'], //TODO: process sss or gsis
                    'pagibig' => (string) $row['buyer_pag_ibig_number'],
                ],
            ],

        ];
        $contact = app(PersistContactAction::class)->run($attribs);

        $project_code = $row['project_code'];
        $unit_type = str_replace('W/', 'w/', Str::title($row['unit_type']));
        $lot_area = $row['lot_area'];
        $floor_area = $row['floor_area'];
        $total_contract_price = $row['total_contract_price'];

        $sku = (new SKU([
            'project_code' => $project_code,
            'total_contract_price' => $total_contract_price,
            'lot_area' => $lot_area,
            'floor_area' => $floor_area,
            'unit_type' => (new UnitType($unit_type))->toModel()
        ]))->toCode();

        $voucher = GenerateVoucherAction::run([
            'sku' => $sku,
            'contact_uid' => (string) $contact->uid,
        ]);

        $property_code = $row['property_code'];
        $dp_percent = 0;
        $dp_months = 0;
        UpdateOrderAction::run($voucher, [
            'property_code' => $property_code,
            'dp_percent' => $dp_percent,
            'dp_months' => $dp_months,
        ]);
        $voucher->refresh();
        $order = $voucher->getOrder();
        $seller_commission = app(SellerCommission::class)->firstOrNew([
            'code' => $row['seller_id'],
            'project_code' => $project_code
        ]);
        $seller_commission->seller()->associate($order->seller);
        $seller_commission->meta->set([
            'legacy' => [
                'selling_unit' => $row['selling_unit'],
                'seller_name' => $row['seller_name'],
                'seller_superior' => $row['seller_superior'],
                'sales_team_head' => $row['sales_team_head'],
                'cso_dcso' => $row['cso_dcso'],
                'seller_type' => $row['seller_type']
            ]
        ]);
        $seller_commission->save();
        $order->sellerCommission()->associate($seller_commission);
        $order->save();

        return $voucher;
    }

    public function headingRow(): int
    {
        return 6;
    }
}
