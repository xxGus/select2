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
require_once __DIR__ . "/../../control/CtrlProduto.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPagina.php";

use control\Config;
use control\CtrlProduto;
use raelgc\view\Template;
use control\Seguranca;
use control\CtrlPagina;

$id_usuario = $_SESSION['id'];
$id_cliente = $_SESSION['id_cliente'];

$pagina = new Template("../html/base.html");
$pagina->addFile("LISTA", "../html/GerenciarVenda/Produto/ListarProduto.html");

Seguranca::chkLogin()
    ? Config::configUsuario($id_usuario, $pagina)
    : header("Location: ../../index.php");

$ctrlProduto = new CtrlProduto();

$ctrlPagina = new CtrlPagina(
    $pagina, $id_usuario,
    "../html/GerenciarVenda/Produto/CadastrarProduto.html",
    "../html/GerenciarVenda/Produto/AlterarProduto.html");

if (isset($_POST['inserir'])) {
    $nome = $_POST['pro-nome'];//$_POST['pag-campanha']
    $valor = $_POST['pro-valor'];//new field

    $pagina->MENSAGEM = $ctrlProduto->cadastrar($nome, $valor, $id_cliente);
}

if (isset($_GET['id'])) {
    $produto = $ctrlProduto->buscar($_GET['id']);
    $pagina->ID = $produto->getId();
    $pagina->PROD_NOME = $produto->getNome();//VALOR_CAMP
    $pagina->PROD_VALOR = $produto->getValor(); //new field
}

if (isset($_POST['atualiza'])) {

    $id = $_POST['pro-id'];//$_POST['id-campanha']
    $produto = $_POST['pro-nome'];//$_POST['pag-campanha']
    $valor = $_POST['pro-valor'];//new field

    $ctrlProduto->alterar($id, $produto, $valor);

    $pagina->MENSAGEM = $ctrlProduto->alterar($id, $nome, $valor);
}

if (isset($_POST['id-remove'])) $ctrlProduto->remover($_POST['id-remove']);

$produtos = $ctrlProduto->listar();

foreach ($produtos as $produto) {

    $pagina->ID = $produto->getId();
    $pagina->PROD = $produto->getNome();
    $pagina->PROD_VAL = $produto->getValor();
    $pagina->block("BLOCK_DADOS");

}

$pagina->show();