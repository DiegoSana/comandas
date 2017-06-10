<?php

class WSMTXCA {

  const CUIT            = "23328482479"; # CUIT del emisor de las facturas
  const TA              = "xmlgenerados/TA.xml"; # Archivo con el Token y Sign
  const WSDL            = "wsdl/wsmtxca.wsdl"; # The WSDL corresponding to WSFE
  const PROXY_ENABLE    = false;
  const LOG_XMLS        = false; # For debugging purposes
  const WSFEURL         = "https://fwshomo.afip.gov.ar/wsmtxca/services/MTXCAService"; // testing
  //const WSFEURL = "?????????????????"; // produccion  

  
  private $path = './';
  public $error = '';
  private $client;
  private $TA;
  private $tipo_cbte = '1';
  private $cert;
  private $key;
  private $passphrase;


  /*
   * Constructor
   */
  public function __construct(WSAA $wsaa) 
  {
      
    $this->path = $wsaa->path;
    $this->client = $wsaa->client;
    $this->cert = $wsaa->cert;
    $this->key = $wsaa->key;
    $this->passphrase = $wsaa->passphrase;
    
    // validar archivos necesarios
    if (!file_exists($this->path.self::WSDL)) $this->error[] = " Failed to open ".self::WSDL;
    
    if(!empty($this->error)) {
      throw new Exception('WSFE class. Faltan archivos necesarios para el funcionamiento');
    }        
    
    $this->client = new SoapClient($this->path.self::WSDL, array( 
              'soap_version' => SOAP_1_2,
              'location'     => self::WSFEURL,
              'exceptions'   => 0,
              'trace'        => 1)
    ); 
  }
  
  /**
   * Chequea los errores en la operacion, si encuentra algun error falta lanza una exepcion
   * si encuentra un error no fatal, loguea lo que paso en $this->error
   */
  private function _checkErrors($results, $method)
  {
    if (self::LOG_XMLS) {
      file_put_contents("xmlgenerados/request-".$method.".xml",$this->client->__getLastRequest());
      file_put_contents("xmlgenerados/response-".$method.".xml",$this->client->__getLastResponse());
    }
    
    if (is_soap_fault($results)) {
      throw new Exception('WSFE class. FaultString: ' . $results->faultcode.' '.$results->faultstring);
    }
    
    if ($method == 'FEDummy') {return;}
    
    $XXX=$method.'Result';
    if ($results->$XXX->RError->percode != 0) {
        $this->error[] = "Method=$method errcode=".$results->$XXX->RError->percode." errmsg=".$results->$XXX->RError->perrmsg;
    }
    
    return $results->$XXX->RError->percode != 0 ? true : false;
  }

  /**
   * Abre el archivo de TA xml,
   * si hay algun problema devuelve false
   */
  public function openTA()
  {
    $this->TA = simplexml_load_file($this->path.self::TA);
    
    return $this->TA == false ? false : true;
  }
  
  public function sol() {
      
      $results = $this->client->consultarCAEAEntreFechas(
        array('authRequest'=>array('token' => $this->TA->credentials->token,
                                'sign' => $this->TA->credentials->sign,
                                'cuitRepresentada' => self::CUIT,
                                ),
              'fechaDesde'=>'20161201',
              'fechaHasta'=>date('Ymd')));
      var_dump('<pre>',$results);die;
  }

  public function consultarCAEA($caea) {
      
      if($caea) {
        $results = $this->client->consultarCAEA(
            array('authRequest'=>array(
                'token' => $this->TA->credentials->token,
                'sign' => $this->TA->credentials->sign,
                'cuitRepresentada' => self::CUIT,
            ),
            'CAEA'=>$caea));
        var_dump('<pre>',$results);die;
      }
  }  
  
    public function solicitarCAEA() {
      
        $results = $this->client->solicitarCAEA(
            array('authRequest'=>array(
                'token' => $this->TA->credentials->token,
                'sign' => $this->TA->credentials->sign,
                'cuitRepresentada' => self::CUIT,
            ),
            'solicitudCAEA'=>array(
                'periodo'=>201612,
                'orden'=>2
            )));
        var_dump('<pre>',$results);die;
    }  


  // Dado un lote de comprobantes retorna el mismo autorizado con el CAE otorgado.
  public function aut($ID, $cbte, $ptovta, $regfac)
  {
    $results = $this->client->FEAutRequest(
      array('argAuth' => array(
               'Token' => $this->TA->credentials->token,
               'Sign'  => $this->TA->credentials->sign,
               'cuit'  => self::CUIT),
            'Fer' => array(
               'Fecr' => array(
                  'id' => $ID, 
                  'cantidadreg' => 1, 
                  'presta_serv' => 0
                ),
               'Fedr' => array(
                  'FEDetalleRequest' => array(
                     'tipo_doc' => $regfac['tipo_doc'],
                     'nro_doc' => $regfac['nro_doc'],
                     'tipo_cbte' => $this->tipo_cbte,
                     'punto_vta' => $ptovta,
                     'cbt_desde' => $cbte,
                     'cbt_hasta' => $cbte,
                     'imp_total' => $regfac['imp_total'],
                     'imp_tot_conc' => $regfac['imp_tot_conc'],
                     'imp_neto' => $regfac['imp_neto'],
                     'impto_liq' => $regfac['impto_liq'],
                     'impto_liq_rni' => $regfac['impto_liq_rni'],
                     'imp_op_ex' => $regfac['imp_op_ex'],
                     'fecha_cbte' => date('Ymd'),
                     'fecha_venc_pago' => $regfac['fecha_venc_pago']
                   )
                )
              )
       )
     );
    
    $e = $this->_checkErrors($results, 'FEAutRequest');
        
    return $e == false ? Array( 'cae' => $results->FEAutRequestResult->FedResp->FEDetalleResponse->cae, 'fecha_vencimiento' => $results->FEAutRequestResult->FedResp->FEDetalleResponse->fecha_vto ): false;
  }

} // class

?>
