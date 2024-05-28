<?php

namespace RLI\Booking\Http\Controllers;

use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\ImageRenderer;
use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Encoder\Encoder;
use RLI\Booking\Models\Voucher;
use BaconQrCode\Writer;
use Inertia\Inertia;

class VoucherController extends Controller
{
    /**
     * @param Voucher $voucher
     * @return \Inertia\Response
     */
    public function show(Voucher $voucher): \Inertia\Response
    {
        $order = $voucher->getOrder();
        $url = $this->getUrl($voucher->code);
        $qrCode = $this->getQrCodeSvg($url);

        return Inertia::render('Voucher/Show', [
            'booking' => $voucher->toData(),
            'voucherCode' => $voucher->code,
            'qrCode' => $qrCode,
            'seller' => $order->seller,
            'product' => $order->product,
            'buyer' => $order->buyer,
            'url' => $url
        ]);
    }

    /**
     * @param $code
     * @return string
     */
    protected function getUrl($code): string
    {
        $query = http_build_query(compact('code'));
        $campaign_url = config('booking.defaults.url.campaign');

        return $campaign_url . '?' . $query;
    }

    /**
     * @param $url
     * @return string
     */
    protected function getQrCodeSvg($url): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(192, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd
            )
        ))->writeString($url);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }
}
