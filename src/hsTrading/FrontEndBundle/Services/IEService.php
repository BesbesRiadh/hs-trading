<?php

namespace hsTrading\FrontEndBundle\Services;

use Symfony\Component\DependencyInjection\Container;

/**
 * Service pour import / export vers CSV
 *
 * @author Walid Saadaoui
 */
class IEService {

    private $oContainer;

    public function __construct(Container $oContainer) {
        $this->oContainer = $oContainer;
        $this->oDataService = $this->oContainer->get('dataService');
    }

    public function getExtention($poFile) {
        $sExtension = $poFile->guessClientExtension();
        if (!$sExtension) {
            list($sFileName, $sExtension) = explode('.', $poFile->getClientOriginalName());
        }
        return $sExtension;
    }

    public function importImg($poFile) {

        $sFileName = $poFile->getClientOriginalName() . '_' . date('YmdHis');
        $sFinalDir = $this->getDir('file.upload_base_dir');

        if (!is_dir($sFinalDir)) {
            mkdir($sFinalDir);
        }
        $sPath = $sFinalDir . DIRECTORY_SEPARATOR . $sFileName;

        $poFile->move($sFinalDir, $sFileName);

        $base64 = 'data:image/' . $this->getExtention($poFile) . ';base64,' . base64_encode(file_get_contents($sPath));
        
        if (is_file($sPath)) {
            @unlink($sPath);
        }
        return (string) $base64;
    }

    private function getDir($psParam) {
        $sFinalDir = $this->oContainer->getParameter($psParam);

        if (!is_dir($sFinalDir)) {
            mkdir($sFinalDir);
        }
        return $sFinalDir;
    }

}
