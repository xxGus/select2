<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 06/10/2017
 * Time: 11:20
 */

session_start();

require_once __DIR__ . "/../../control/CtrlCliente.php";
require_once __DIR__ . "/../../control/Seguranca.php";

use control\CtrlCliente;
use control\Seguranca;

Seguranca::chkCliente();

$ctrlCliente = new CtrlCliente();

$clientes = $ctrlCliente->listaJson();


echo $clientes;
