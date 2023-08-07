<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('Zend/Loader/Autoloader.php');
require_once('libreria/LogMedinetRest.php');
require_once('webServiceFarmaCardToBillFish.php');


$loader = Zend_Loader_Autoloader::getInstance();

$server = new Zend_Json_Server();

$server->setClass('webServiceFarmaCardToBillFish');

if ('GET' == $_SERVER['REQUEST_METHOD']) {
    header("Location: wsDentalPro/index.php");
}

$server->handle();


