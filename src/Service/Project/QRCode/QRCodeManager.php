<?php

declare(strict_types=1);

namespace App\Service\Project\QRCode;

use App\Entity\Project;

class QRCodeManager
{
    private string $qrCodesPath;
    private QRCodeFetcher $codeFetcher;

    public function __construct(string $qrCodesPath, QRCodeFetcher $codeFetcher)
    {
        $this->qrCodesPath = $qrCodesPath;
        $this->codeFetcher = $codeFetcher;
    }

    public function generateCode(Project $project): void
    {
        $path = $this->qrCodesPath . $project->getHash() . '.png';
        if (file_exists($path)) {
            return;
        }

        $qrCode = $this->codeFetcher->fetchCode($this->buildProjectContents($project));
        file_put_contents($path, $qrCode);
    }

    /**
     * https://developers.google.com/chart/infographics/docs/qr_codes?csw=1
     * Check `chl=<data>` parameter
     *
     * Considering that each project has a unique hash/key, only `hash` field should be sufficient to use
     * @param Project $project
     * @return string
     */
    private function buildProjectContents(Project $project): string
    {
        return $project->getHash();
    }
}
