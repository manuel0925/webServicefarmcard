<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * -32700 ---> parse error. not well formed
  -32701 ---> parse error. unsupported encoding
  -32702 ---> parse error. invalid character for encoding
  -32600 ---> server error. invalid xml-rpc. not conforming to spec.
  -32601 ---> server error. requested method not found
  -32602 ---> server error. invalid method parameters
  -32603 ---> server error. internal xml-rpc error
  -32500 ---> application error
  -32400 ---> system error
  -32300 ---> transport error
  In addition, the range -32099 .. -32000, inclusive is reserved for implementation defined server errors. Server errors which do not cleanly map to a specific error defined by this spec should be assigned to a number in this range. This leaves the remainder of the space available for application defined errors.
 * 
 * 
 */
require_once 'model/webServiceFarmaCardModel.php';
require_once 'libreria/Validacion.php';
require_once 'libreria/CodigoErrores.php';
//require_once 'libreria/GenerarCodigo.php';
//require_once 'libreria/Web_service.php';
//require_once 'libreria/HelperFunciones.php';

/**
 * Description of Medico
 *
 * @author jesus
 */
class webServiceFarmaCardToBillFish
{

    /**
     *
     * 
     * 
     */
    private $_objConsulta;
    private $_request;
    private $ip_permitidas = array("172.16.2.3", "170.123.123.100", "170.123.123.4");

    const AMBIENTE = 'Pruebas';
    const SISTEMA = 'webServiceFarmaCardToBillFish';
    const VERSION = '1.0';

    public function __construct()
    {
        $this->_request = new Zend_Controller_Request_Http();


        try {

            $this->_objConsulta = new webServiceFarmaCardModel($this->_request->getClientIp());
        } catch (Exception $e) {

            throw new Exception($e->errorMessage(), CodigoErrores::$ERROR_INVALID_PARAMS);
            //            echo $e->errorMessage();
            //            return ['status' => ["codRespuesta" => CodigoErrores::$ERROR_DB, "desRespuesta" => CodigoErrores::$DESC_ERROR]];
        }
    }

    /**
     * método inicial el cual deberá de autenticar al cliente para delimitar la red de clientes, la red de
     * sucursales y/o sucursal. El mismo trae como resultado un llave (token) la cual será mandatoria en los demás
     * métodos del servicio.
     * La llave debe de tener una vigencia de 20 minutos antes de invalidarse.
      La llave debe de invalidarse luego de ejecutar una actividad del tipo autorización y/o reversión.
     * @return array
     * @throws Exception
     */
    /*     * Consultar de reclamos
     * 
     * Tipo de receta (tipoReceta) 
     * @return type array
     * @throws Exception
     */

    public function listaMedicamentos()
    {

        $response = array();

        $response = array();
        $resultado = array();
        $metodo = 'listaClinicas';

        $objRequest = json_decode($this->_request->getRawBody());
        $parametros = $objRequest->params;

        $objValidacion = new Validacion($this->_objConsulta);



        if (!isset($objRequest->id)) {
            throw new Exception(CodigoErrores::$DESC_ERROR_ID, CodigoErrores::$ERROR_INVALID_PARAMS);
        }


        $objValidacion->reglas($parametros->cedula, 'cedula', 'requerido');
        if (!$objValidacion->validar()) {
            throw new Exception($objValidacion->getMensajesError(), CodigoErrores::$ERROR_INVALID_PARAMS);
        }

       
       

        $resultado = $this->_objConsulta->getMedicamentos($parametros);

        //        



        if (empty($resultado)) {

            $response = ['status' => ["codRespuesta" => CodigoErrores::$ERROR_DB, "desRespuesta" => CodigoErrores::$DESC_ERROR]];
        } else {

            $response = $resultado[0];
        }




        //        LogMedinetRest::log("retorno sesion:<pre>" . print_r($response, TRUE) . "</pre>");
        //        $this->_objConsulta->logWs($objRequest, $metodo, $response);


        return $response;
    }

    public function stautusCovi()
    {

        $response = array();

        $response = array();
        $resultado = array();
        $metodo = 'listaClinicas';

        $objRequest = json_decode($this->_request->getRawBody());
        $parametros = $objRequest->params;

        $objValidacion = new Validacion($this->_objConsulta);



        if (!isset($objRequest->id)) {
            throw new Exception(CodigoErrores::$DESC_ERROR_ID, CodigoErrores::$ERROR_INVALID_PARAMS);
        }


        $objValidacion->reglas($parametros->cedula, 'cedula', 'requerido');
        if (!$objValidacion->validar()) {
            throw new Exception($objValidacion->getMensajesError(), CodigoErrores::$ERROR_INVALID_PARAMS);
        }

       
       

        $resultado = $this->_objConsulta->getMedicamentos($parametros);

        //        



        if (empty($resultado)) {

            $response = ['status' => ["codRespuesta" => CodigoErrores::$ERROR_DB, "desRespuesta" => CodigoErrores::$DESC_ERROR]];
        } else {

            $response = $resultado[0];
        }




        //        LogMedinetRest::log("retorno sesion:<pre>" . print_r($response, TRUE) . "</pre>");
        //        $this->_objConsulta->logWs($objRequest, $metodo, $response);


        return $response;
    }

    


    //        LogMedinetRest::log("retorno sesion:<pre>" . print_r($response, TRUE) . "</pre>");


    public function version()
    {

        return array(
            'Ambiente' => self::AMBIENTE,
            'Sistema' => self::SISTEMA,
            'version' => self::VERSION
        );
    }
}
