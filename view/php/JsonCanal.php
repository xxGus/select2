<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 06/10/2017
 * Time: 11:20
 */

session_start();

require_once __DIR__ . "/../../control/CtrlPizza.php";
require_once __DIR__ . "/../../control/Seguranca.php";

use control\CtrlPizza;
use control\Seguranca;

Seguranca::chkCliente();

$ctrlCanal = new CtrlPizza();

$canais = $ctrlCanal->listaJson();


echo $canais;
