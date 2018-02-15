<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 14/02/2018
 * Time: 22:42
 */

namespace view;

session_start();

require_once __DIR__ . "/../../control/CtrlCliente.php";
require_once __DIR__ . "/../../control/Seguranca.php";

use control\CtrlCliente;
use control\Seguranca;

Seguranca::chkCliente();

$id_cliente_sistema = $_SESSION['id_cliente_sistema'];
$ctrlCliente = new CtrlCliente();

if(isset($_POST['telefone'])){

    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];

    echo $ctrlCliente->cadastrar($nome, $endereco, $telefone, $celular, $id_cliente_sistema);
}