<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'libreria/MultiConsulta.php';

class webServiceFarmaCardModel extends MultiConsulta
{

        private $ip = '';

        public function __construct($ip)
        {

                parent::__construct();

                $this->ip = $ip;
        }

        public function realScapeStringParametrosBaseDeDatos($obj)
        {

                foreach ($obj as $key => $value) {
                        if (!is_array($value)) {
                                $obj->$key = $this->realScapeString($value);
                        }
                };


                return $obj;
        }

        public function ip()
        {
                $ip = $this->ip;

                return $ip;
        }

        /**
         * Inicia sesion el usuario retorna la llave de accesso
         * @param stdClass $obj
         * @return array
         */
        public function getMedicamentos($obj)
        {
                $obj = $this->realScapeStringParametrosBaseDeDatos($obj); //Limpiando parametros
                
                $query = "CALL MEDICAMENTO.BILL_FISH('M','','calonzo','$obj->cedula');";
                
                $resultado = $this->consultaMultipleResultado($query);
                
                LogMedinetRest::log("query getClinicas:<pre> $query" . print_r($resultado, TRUE) . "</pre>");
                
                return $resultado;
        }

       

}
