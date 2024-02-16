<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class UploadProductsAction
{
    use AsAction;

    public string $commandSignature = 'upload:products {path}';
    public string $commandDescription = 'Import Product SKUs from an Excel file';
    public string $commandHelp = 'This command will upsert the records in the products table';
    public function handle(string $path): void
    {
        Excel::import(new ProductsImport, $path);
    }

    public function asCommand(Command $command): void
    {
        $path = $command->argument('path');
        $this->handle($path);

        $command->info('Done!');
    }
}
