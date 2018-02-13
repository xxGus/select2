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

$pagina = new Template("../html/base.html");
$pagina->addFile("LISTA", "../html/GerenciarPedido/Cliente/ListarCliente.html");

Seguranca::chkLogin()
    ? Config::configUsuario($_SESSION['id'], $pagina)
    : header("Location: ../../index.php");

Seguranca::chkCliente();

$id_cliente_sistema = $_SESSION['id_cliente_sistema'];

$ctrlPagina = new CtrlPagina(
    $pagina, $id_cliente_sistema,
    "../html/GerenciarPedido/Cliente/CadastrarCliente.html",
    "../html/GerenciarPedido/Cliente/AlterarCliente.html"
);

$ctrlCliente = new CtrlCliente();

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];

    $pagina->MENSAGEM = $ctrlCliente->cadastrar($nome, $endereco, $telefone, $celular, $id_cliente_sistema);
}

if (isset($_GET['id'])) {
    $cliente = $ctrlCliente->buscar($_GET['id']);
    $pagina->ID = $cliente->getId();
    $pagina->CLI_NOME = $cliente->getNome();
    $pagina->CLI_END = $cliente->getEndereco();
    $pagina->CLI_TEL = $cliente->getTelefone();
    $pagina->CLI_CEL = $cliente->getCelular();
}

if (isset($_POST['alterar'])) {

    $id = $_POST['id-cliente'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];

    $pagina->MENSAGEM = $ctrlCliente->alterar($id, $nome, $endereco, $telefone, $celular);
}

if(isset($_POST['id-remove']))
    $ctrlCliente->remover($_POST['id-remove']);

$clientes = $ctrlCliente->listar();

foreach ($clientes as $cliente) {
    $pagina->ID = $cliente->getId();
    $pagina->CLIENTE = $cliente->getNome();
    $pagina->END = $cliente->getEndereco();
    $pagina->TEL = $cliente->getTelefone();
    $pagina->CEL = $cliente->getCelular();
    $pagina->block("BLOCK_DADOS");
}

$pagina->show();