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
require_once __DIR__ . "/../../control/CtrlClienteSistema.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPagina.php";

use control\Config;
use control\Seguranca;
use raelgc\view\Template;
use control\CtrlClienteSistema;
use control\CtrlPagina;

$id_cliente_sistema = $_SESSION['id_cliente_sistema'];

$pagina = new Template("../html/base.html");
$pagina->addFile("LISTA", "../html/GerenciarClientesSistema/ListarClientesSistema.html");

Seguranca::chkLogin()
    ? Config::configUsuario($_SESSION['id'], $pagina)
    : header("Location: ../../index.php");

Seguranca::chkCliente();

$ctrlPagina = new CtrlPagina(
    $pagina, $id_cliente_sistema,
    "../html/GerenciarClientesSistema/CadastrarClientesSistema.html",
    "../html/GerenciarClientesSistema/AlterarClientesSistema.html"
);

$ctrlClienteSistema = new CtrlClienteSistema();

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $bloqueado = 0;
    if($_POST['bloqueado'] == 'on')
        $bloqueado = 1;

    $mensagem = $ctrlClienteSistema->cadastrar($nome, $bloqueado);

    !is_null($mensagem)
        ? $pagina->MENSAGEM =  $mensagem
        : $pagina->MENSAGEM = "Falha ao salvar dados, tente novamente.";
}

if (isset($_GET['id'])) {
    $cliente = $ctrlClienteSistema->buscar($_GET['id']);
    $pagina->ID = $cliente->getId();
    $pagina->VALOR_NOME = $cliente->getNome();
    $pagina->VALOR_BLOQ = "";
    if ($cliente->getBloqueado() == 1)
        $pagina->VALOR_BLOQ = "checked";

}

if (isset($_POST['alterar'])) {

    $id = $_POST['id-cliente-sistema'];
    $nome = $_POST['nome'];
    $bloqueado = 0;

    if (isset($_POST['bloqueado']))
        $bloqueado = 1;

    $ctrlClienteSistema->alterar($id, $nome, $bloqueado);
}

if(isset($_POST['id-remove']))
    $ctrlClienteSistema->remover($_POST['id-remove']);

$clientes = $ctrlClienteSistema->listar();

foreach ($clientes as $cliente) {
    $pagina->ID = $cliente->getId();
    $pagina->CLIENTE = $cliente->getNome();

    $pagina->BLOQ = "Desbloqueado";
    if ($cliente->getBloqueado() == 1)
        $pagina->BLOQ = "Bloqueado";

    $pagina->block("BLOCK_DADOS");
}

$pagina->show();