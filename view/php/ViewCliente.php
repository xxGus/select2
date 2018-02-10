<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 27/11/2017
 * Time: 16:15
 */

namespace view;

session_start();

require_once __DIR__ . "/../../lib/raelgc/view/Template.php";
require_once __DIR__ . "/../../control/CtrlCliente.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPagina.php";

use control\Config;
use control\Seguranca;
use raelgc\view\Template;
use control\CtrlCliente;
use control\CtrlPagina;

$id_cliente = $_SESSION['id_cliente'];

$pagina = new Template("../html/base.html");
$pagina->addFile("LISTA", "../html/GerenciarClientes/ListarClientes.html");

Seguranca::chkLogin()
    ? Config::configUsuario($_SESSION['id'], $pagina)
    : header("Location: ../../index.php");

Seguranca::chkCliente();

$ctrlPagina = new CtrlPagina(
    $pagina, $id_cliente,
    "../html/GerenciarClientes/CadastrarClientes.html",
    "../html/GerenciarClientes/AlterarClientes.html"
);

$objCtrlCliente = new CtrlCliente();

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $url = $_POST['url'];
    $id_view = $_POST['id-view'];

    $mensagem = $objCtrlCliente->cadastrar($nome, $url, $id_view);

    !is_null($mensagem)
        ? $pagina->MENSAGEM =  $mensagem
        : $pagina->MENSAGEM = "Falha ao salvar dados, tente novamente.";
}

if (isset($_GET['id'])) {
    $cliente = $objCtrlCliente->buscar($_GET['id']);
    $pagina->ID = $cliente->getId();
    $pagina->VALUE_NOME = $cliente->getNome();
    $pagina->VALUE_URL = $cliente->getEndereco();
    $pagina->VALUE_IDVIEW = $cliente->getTelefone();
}

if (isset($_POST['alterar'])) {

    $id = $_POST['id-cliente'];
    $nome = $_POST['nome'];
    $url = $_POST['url'];
    $id_view = $_POST['id-view'];

    $objCtrlCliente->alterar($id, $nome, $url, $id_view);
}

if(isset($_POST['id-remove']))
    $objCtrlCliente->remover($_POST['id-remove']);

$clientes = $objCtrlCliente->listar();

foreach ($clientes as $cliente) {
    $pagina->ID = $cliente->getId();
    $pagina->CLIENTE = $cliente->getNomeEmpresa();
    $pagina->URL = $cliente->getUrl();
    $pagina->IDVIEW = $cliente->getIdView();
    $pagina->block("BLOCK_DADOS");
}

$pagina->show();