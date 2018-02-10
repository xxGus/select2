<?php
/**
 * Created by PhpStorm.
 * User: Gustavo Baptista
 * Date: 15/09/2017
 * Time: 10:35
 */

namespace view;

session_start();

require_once "../../lib/raelgc/view/Template.php";
require_once __DIR__ . "/../../control/CtrlUsuario.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/CtrlPagina.php";

use control\Config;
use control\CtrlUsuario;
use control\Seguranca;
use raelgc\view\Template;
use control\CtrlPagina;

$id_usuario = $_SESSION['id'];

$pagina = new Template('../html/base.html');
$pagina->addFile("LISTA", "../html/GerenciarUsuarios/ListarUsuario.html");

Seguranca::chkLogin()
    ? Config::configUsuario($id_usuario, $pagina)
    : header("Location: ../../index.php");

$id_cliente = $_SESSION['id_cliente'];

$ctrlPagina = new CtrlPagina(
    $pagina, $id_usuario,
    "../html/GerenciarUsuarios/CadastrarUsuario.html",
    "../html/GerenciarUsuarios/AlterarUsuario.html");

$ctrlUsuario = new CtrlUsuario();

/*** Quando cadastrar, verificar à qual cliente o usuario pertence ***/

if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    //Tratar a imagem
    $foto = $_FILES['foto'];

    // Pega extensão da imagem
    $ext = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $ext = strtolower($ext);
    // Gera um nome único para a imagem
    $nome_imagem = md5(uniqid((time()))) . "." . $ext;

    // Caminho de onde ficará a imagem
    $caminho_imagem = "../../view/fotos-usuarios/" . $nome_imagem;

    //Faz o upload da imagem para seu respectivo caminho
    move_uploaded_file($foto["tmp_name"], $caminho_imagem);

    $nivel = $_POST['nivel'];


    $pagina->MENSAGEM = "<p class='alert-danger' style='text-align: center'>E-mail já cadastrado. tente novamente.</p>";

    if($ctrlUsuario->cadastrar($nome, $email, $senha, $nome_imagem, $nivel)){
        $pagina->MENSAGEM = "<p class='alert-success' style='text-align: center'>Usuario cadastrado com sucesso!</p>";
    }
}

if(isset($_SESSION['new-cli'])){
    $pagina->MENSAGEM = $_SESSION['new-cli'];
    unset($_SESSION['new-cli']);
}

//Preenche os campos para serem alterados
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $usuario = $ctrlUsuario->buscar($id);

    $pagina->VALOR_NOME = $usuario->getNome();
    $pagina->VALOR_EMAIL = $usuario->getEmail();
    $pagina->FOTO_ALTERAR = '../fotos-usuarios/' . $usuario->getFoto();
    $pagina->ID = $id;

    switch ($usuario->getNivel()) {
        case 0:
            {
                $pagina->NIVEL0 = "selected";
                break;
            }
        case 1:
            {
                $pagina->NIVEL1 = "selected";
                break;
            }
        case 2:
            {
                $pagina->NIVEL2 = "selected";
                break;
            }
    }
}

if (isset($_POST['alterar'])) {

    $id = $_POST['id-user'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $oldSenha = md5($_POST['old-senha']);
    $newSenha = md5($_POST['new-senha']);
    $senhaAlterada = false;
    $nome_imagem = "";

    if (isset($_POST['chk-alt-senha']))
        $senhaAlterada = true;

    if ($_FILES['foto-alterar']['name'] != "") {
        //Tratar a imagem
        $foto = $_FILES['foto-alterar'];

        // Pega extensão da imagem
        $ext = pathinfo($foto["name"], PATHINFO_EXTENSION);
        $ext = strtolower($ext);

        // Gera um nome único para a imagem
        $nome_imagem = md5(uniqid((time()))) . "." . $ext;

        // Caminho de onde ficará a imagem
        $caminho_imagem = "../../view/fotos-usuarios/" . $nome_imagem;

        //Faz o upload da imagem para seu respectivo caminho
        move_uploaded_file($foto["tmp_name"], $caminho_imagem);
    }

    $nivel = $_POST['nivel'];

    $pagina->MENSAGEM = $ctrlUsuario->alterar($id, $nome, $email, $nome_imagem, $id_cliente, $nivel, $oldSenha, $newSenha, $senhaAlterada);
}

if (isset($_POST['id-remove'])) {
    if ($_SESSION['id'] != $_POST['id-remove']) {
        $ctrlUsuario->remover($_POST['id-remove']);
    }
}

/*** Listar somente os usuarios de um cliente ***/

//Lista todos os usuários cadastrados

$usuarios = $ctrlUsuario->listar();

foreach ($usuarios as $u) {

    if ($u->nome != "") {
        $pagina->ID = $u->id;
        $pagina->NOME = $u->nome;
        $pagina->EMAIL = $u->email;

        switch ($u->nivel) {
            case 0:
                $pagina->NIVEL = "Administrador";
                break;
            case 1:
                $pagina->NIVEL = "Gerente";
                break;
            case 2:
                $pagina->NIVEL = "Funcionário";
                break;
        }

        $pagina->CLIENTE = $u->nome_cliente;
        $pagina->block("BLOCK_DADOS");
    }
}

$pagina->show();