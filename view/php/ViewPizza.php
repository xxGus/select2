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
require_once __DIR__ . "/../../control/CtrlPizza.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPagina.php";

use control\Config;
use raelgc\view\Template;
use control\CtrlPizza;
use control\Seguranca;
use control\CtrlPagina;

$id_usuario = $_SESSION['id'];
$id_cliente = $_SESSION['id_cliente'];

$pagina = new Template("../html/base.html");
$pagina->addFile("LISTA", "../html/GerenciarVenda/Pizza/ListarPizza.html");

Seguranca::chkLogin()
    ? Config::configUsuario($id_usuario, $pagina)
    : header("Location: ../../index.php");

$ctrlPizza = new CtrlPizza();

$ctrlPagina = new CtrlPagina(
    $pagina, $id_usuario,
    "../html/GerenciarVenda/Pizza/CadastrarPizza.html",
    "../html/GerenciarVenda/Pizza/AlterarPizza.html");


if (isset($_POST['inserir'])) {
    $nome = $_POST['pi-nome'];//$_POST['canal']
    $ingrediente = $_POST['pi-ingrediente'];//$_POST['source']
    $valor = $_POST['pi-valor'];//$_POST['medium']

    $pagina->MENSAGEM = $ctrlPizza->cadastrar($nome, $ingrediente, $valor, $id_cliente);
}

if (isset($_GET['id'])) {
    $pizza = $ctrlPizza->buscar($_GET['id']);
    $pagina->ID = $pizza->getId();
    $pagina->PI_NOME = $pizza->getNome();//VALOR_CANAL
    $pagina->PI_INGRE = $pizza->getIngrediente();//VALOR_SOURCE
    $pagina->PI_VALOR = $pizza->getValor();//VALOR_MEDIUM
}

if (isset($_POST['atualiza'])) {

    $id = $_POST['pi-id'];
    $pizza = $_POST['pi-pizza'];
    $ingrediente = $_POST['pi-ingrediente'];
    $valor = $_POST['pi-valor'];

    $pagina->MENSAGEM = $ctrlPizza->alterar($id, $pizza, $ingrediente, $valor);
}

if (isset($_POST['id-remove'])) $ctrlPizza->remover($_POST['id-remove']);

$pizzas = $ctrlPizza->listar();

foreach ($pizzas as $pizza) {
    $pagina->ID = $pizza->getId();
    $pagina->NOME = $pizza->getNome();//CANAL
    $pagina->INGRE = $pizza->getIngrediente();//SOURCE
    $pagina->VALOR = $pizza->getValor();//MEDIUM
    $pagina->block("BLOCK_DADOS");
}

$pagina->show();