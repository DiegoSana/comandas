<?php

require_once 'wsaa.class.php';
require_once 'wsmtxca.class.php';

class WsAfipFactory {
    
    /*
    $config = array(
        'service'=>'',
        'cert'=>'',
        'key'=>''
    );
    */
    
    public static function getService($config) {
        if($config) {
            $wsaa = new WSAA($config);
            if($wsaa->get_expiration() < date("c")) {
                if (!$wsaa->generar_TA()) {
                    return false;
                }
            }
            
            switch ($config['service']) {
                case 'wsfev1':
                    break;
                case 'wsmtxca':
                    $wsmtxca = new WSMTXCA($wsaa);
                    $wsmtxca->openTA();
                    return $wsmtxca;
                    break;
            }
        }
    }
}

