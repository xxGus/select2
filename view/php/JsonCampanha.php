<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 06/10/2017
 * Time: 13:48
 */

session_start();

require_once __DIR__ . "/../../control/CtrlProduto.php";
require_once __DIR__ . "/../../control/Seguranca.php";

use control\CtrlProduto;
use control\Seguranca;

Seguranca::chkCliente();

$ctrlCamapanha = new CtrlProduto();

$campanhas = $ctrlCamapanha->listaJSON();

echo $campanhas;