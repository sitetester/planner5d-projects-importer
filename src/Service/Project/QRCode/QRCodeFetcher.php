<?php

declare(strict_types=1);

namespace App\Service\Project\QRCode;

// https://developers.google.com/chart/infographics/docs/qr_codes?csw=1
// https://stackoverflow.com/questions/5943368/dynamically-generating-a-qr-code-with-php
class QRCodeFetcher
{
    private const GOOGLE_CHART_API = 'https://chart.googleapis.com/chart';

    /**
     * Image size
     * <width>x<height>
     */
    private string $chs = '300x300';

    /**
     * Working HTTP example: https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=lorem+ipsum
     *
     * chl=<data>
     * The data to encode. Data can be digits (0-9), alphanumeric characters, binary bytes of data, or Kanji.
     * You cannot mix data types within a QR code. The data must be UTF-8 URL-encoded.
     * Note that URLs have a 2K maximum length, so if you want to encode more than 2K bytes
     * (minus the other URL characters), you will have to send your data using POST
     *
     * @param string $contents
     * @return string
     */
    public function fetchCode(string $contents): string
    {
        $url = self::GOOGLE_CHART_API . '?chs=' . $this->chs . '&cht=qr&chl=' . urlencode($contents);

        return file_get_contents($url);
    }
}
