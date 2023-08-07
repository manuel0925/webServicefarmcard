<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validacion
 *
 * @author jesus
 */
class Validacion {

    private $claseRelacionada;
    private $variante;
    private $esUnaFuncion;

    /**
     *
     * @var type array
     */
    private $errorText = array(
        'requerido' => "{0}: Este campo es requerido.",
        'email' => "{0}: Por favor, introduce una dirección de correo electrónico válida.",
        'url' => "{0}: Por favor introduzca un URL válido.",
        'date_' => "{0}: Por favor introduzca una fecha valida.",
        'numeric' => "{0}: Por favor ingrese un número valido.",
        'igualQue' => "{0}: Por favor, introduzca el mismo valor de {1}.",
        'max_length' => "{0}: Por favor, introduzca no más de {1} caracteres.",
        'min_length' => "{0}: Por favor, introduzca al menos {1} caracteres.",
        'max' => "{0}: Por favor, introduzca un valor inferior o igual a {1}.",
        'min' => "{0}: Por favor, introduzca un valor mayor o igual a {1}.",
        'es_md5' => "{0}: Por favor, enviar la clave en md5.",
        'telefono' => "{0}: Por favor, especifique un número de teléfono válido.",
        'validarCedulas' => "{0}: Cedula invalida."
    );
    private $_errors = array();

    public function __construct($obj = NULL, $variante = 10) {
        $this->claseRelacionada = $obj;
        $this->esUnaFuncion = FALSE;
        $this->setVariante($variante);
    }

    public function setMensajeFuncion($funcion, $mensaje) {
        $this->errorText[$funcion] = $mensaje;
    }

    function getVariante() {
        return $this->variante;
    }

    function setVariante($variante) {
        $this->variante = $variante;
    }

    /**
     * Aplica la reglas al valor dado
     * @param type $value
     * @param type $name
     * @param type $inputRules
     * @throws Exception
     */
    public function reglas($value, $name, $inputRules) {
        $value = trim($value);
        $obj = $this;
        $inputRules = explode('|', $inputRules);
        foreach ($inputRules as $inputRule) {

            if (!strlen($value) && $inputRule != 'requerido') {
                break;
            }

            if (strpos($inputRule, "callback") !== false) { //verifica si es una funcion
                
                $funct = explode('_', $inputRule);
                
                $rule = $funct[1];
                
                $obj = $this->claseRelacionada;
                
                if (!method_exists($obj, $rule)) {
                    throw new Exception("Metodo {$rule} no existe");
                    exit;
                }
               
                $call = array($value, $this); //parametros
                $this->esUnaFuncion = TRUE;

                
            } elseif (preg_match('/\[(.*?)\]/', $inputRule, $match)) {

                $rule = explode('[', $inputRule);
                $rule = $rule[0];
                $param = $match[1];
                if (!method_exists($this, $rule)) {
                    throw new Exception("Metodo {$rule} no existe");
                    exit;
                }

                $call = array($value, $param);
            } else {
                if (!method_exists($this, $inputRule)) {
                    throw new Exception("Metodo {$rule} no existe");
                    exit;
                }
                $rule = $inputRule;
                $call = array($value);
            }

            $response = call_user_func_array(array($obj, $rule), $call);

            if (!$response) {

                if (!$this->esUnaFuncion) {

                    $error = $this->errorText[$rule];

                    if (isset($param)) {
                        $error = str_replace('{1}', $param, $error);
                    }

                    $error = str_replace('{0}', $name, $error);

                    $this->_errors[] = $error;
                } else {
                    $this->_errors[] = str_replace('{0}',$name,$this->errorText[$rule]);
                }
            }
        }
    }

    public function validar() {
        return (empty($this->_errors)) ? TRUE : FALSE;
    }

    public function getMensajesError() {
        return current($this->_errors);
    }

    public function min_length($value, $param) {
        return !(strlen($value) < $param);
    }

    public function max_length($value, $param) {
        return !(strlen($value) > $param);
    }

    public function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function requerido($value) {
        return (strlen($value) !== 0);
    }

    public function ip($value) {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    public function igualQue($value, $param) {
        return ($value == $param);
    }

    public function exactamenteigualQue($value, $param) {
        return ($value === $param);
    }

    public function match($value, $param) {
        return ($value != $param);
    }

    public function match_exact($value, $param) {
        return ($value !== $param);
    }

    public function match_password($value, $param) {
        return ($value !== $param);
    }

    public function alphanum($value) {
        return ctype_alnum($value);
    }

    public function url($value) {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    public function numeric($value) {
        return (is_numeric($value));
    }

    public function min($value, $param) {
        return !($value < $param);
    }

    public function max($value, $param) {
        return !($value > $param);
    }

    public function es_md5($value) {
        return preg_match('/^[a-f0-9]{32}$/', $value);
    }

    public function telefono($value) {
        if (!(strlen($value) == 10)) {
            return FALSE;
        }

        return preg_match('/(^[8][024][9][0-9]{7}$)/', $value);
    }

    public function validarCedulas($cedulaDigitada) {

        $cedulaDigitada = str_replace("-", "", $cedulaDigitada);


        if ((int) $cedulaDigitada == 0) return false;
        if (strlen($cedulaDigitada) != 11) return false;

        $total = 0;
        $separar = 1;
        $arrayMultiPlicacion = array(1, 2, 1, 2, 1, 2, 1, 2, 1, 2);
        $arrayCedula = $this->desglosar($cedulaDigitada, $separar);

        for ($i = 9; $i >= 0; $i--) {

            $multiPlica = $arrayMultiPlicacion[$i] * $arrayCedula[$i];

            if (strlen($multiPlica) > 1) {
                $total += array_sum($this->desglosar($multiPlica, $separar));
            } else {
                $total += $multiPlica;
            }
        }

        $decena = $total;
        $ultimoDigitoResultado = (((floor($decena / 10) + 1) * 10) - $total);
        $ultimoDigito = $this->desglosar($ultimoDigitoResultado, 1);
        if ($arrayCedula[10] == $ultimoDigito[(count($ultimoDigito) - 1)]) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * funcion para desglosar cadena caracteres
     * @param string $cadena
     * @param int $cantidadDigito
     * @return array
     */
    private function desglosar($cadena, $cantidadDigito) {
        $arrayTemp = array();
        $long = strlen($cadena);
        for ($i = 0; $i < $long; $i += $cantidadDigito) {
            $sub = substr($cadena, $i, $cantidadDigito);

            $arrayTemp[] = $sub;
        }

        return $arrayTemp;
    }

    public function validar_precio_tolerancia($txtCosto, $cantidad, $precioAjustado) {
        $variante = $this->getVariante();
        $retorno = TRUE;

        $cantidad = (float) $cantidad;
        $txtCosto = (float) $txtCosto;
        $precioAjustado = (float) $precioAjustado;
        $variante = (int) $variante;

        $txtPrecio = $txtCosto * $cantidad;

        if ($precioAjustado > (($variante / 100) + 1) * $txtPrecio) {
            $retorno = FALSE;
        }

        if ($txtCosto <= 0) {
            $retorno = FALSE;
        }


        return $retorno;
    }

}
