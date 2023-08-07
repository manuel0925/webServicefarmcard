<?php
error_reporting(E_ALL); //E_ALL); //(
set_error_handler("error_handler");

function error_handler($errlevel, $errstr, $errfile = '', $errline = '') {
    //echo('PHP ERROR: ' . $errstr . ' (linea ' . $errline . ', archivo ' . $errfile);
    LogMedinetRest::log("PHP $errlevel: " . $errstr . ' (linea ' . $errline . ', archivo ' . $errfile . "<br>");
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author jesus
 */
class LogMedinetRest {
    /**
     *Nombre del archivo del log
     * @var type string
     */
    private static $archivo = 'webServiceFarmaCardToBillFish';
    /**
     * Establecer el archivo donde se escribe el log
     * @param type $file
     */  
    static function setArchivo( $file ){
       self::$archivo = $file; 
    }
    /**
     * Mensaje a registrar en el log
     * @param type $mensaje
     */
    static function log($mensaje) {
        //$logFile = (defined('LOG_FILE')) ? LOG_FILE : '/var/www/medinet/tema/configuraciones/includes/log.txt';
        //$logFile = ($_SESSION['codCliente'] == '0011') ? '/var/log/ws_r.log' : '/var/log/ws_r.log';
        $logFile = '/var/log/webservices_log/' . self::$archivo.'_'.date('Y-m-d').'.log';
        file_put_contents($logFile, date("y/m/d H:i:s ") . $mensaje . "\r\n", FILE_APPEND | LOCK_EX);
        //echo(date("y/m/d H:i:s ") . $mensaje . "\n");
    }
    
    /**
     * Mensaje con var_export
     * @param type $mensaje
     * @param type $var
     */
    static function debug($mensaje, $var) {
        LogMedinetRest::log($mensaje . ":\n" . var_export($var, true));
    }

}

?>