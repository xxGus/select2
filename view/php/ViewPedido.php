<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:17
 */

namespace view;

session_start();

require_once __DIR__ . "/../../lib/raelgc/view/Template.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPizza.php";
require_once __DIR__ . "/../../control/CtrlProduto.php";

use control\Config;
use control\CtrlPizza;
use control\CtrlProduto;
use raelgc\view\Template;
use control\Seguranca;

$pagina = new Template("../html/base.html");

$pagina->addFile("CONTEUDO", "../html/GerenciarPedido/Pedido.html");

Seguranca::chkLogin()
    ? Config::configUsuario($_SESSION['id'], $pagina)
    : header("Location: ../../index.php");

$pizza = new CtrlPizza();
$produto = new CtrlProduto();

$pizzas = $pizza->listar();

foreach ($pizzas as $pz){
    $pagina->VALOR_PIZZA = $pz->getValor();
    $pagina->PIZZA = $pz->getNome();
    $pagina->block("BLOCK_PIZZA");
}

$produtos = $produto->listar();

foreach ($produtos as $pt){
    $pagina->VALOR_PRODUTO = $pt->getValor();
    $pagina->PRODUTO = $pt->getNome();
    $pagina->block("BLOCK_PRODUTO");
}

$pagina->show();