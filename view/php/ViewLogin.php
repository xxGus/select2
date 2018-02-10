<?php
/**
 * Created by PhpStorm.
 * User: Gustavo Baptista
 * Date: 26/09/2017
 * Time: 13:50
 */

namespace view;

require_once "../../lib/raelgc/view/Template.php";
require_once "../../control/CtrlLogin.php";

use control\CtrlLogin;
use raelgc\view\Template;

$pagLogin = new Template('../html/login.html');
$objLoginCtrl = new CtrlLogin();

if (isset($_POST['entrar'])) {

    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    unset($_SESSION['id']);
    $objLoginCtrl->buscarUsuario($email, $senha);

    $pagLogin->MENSAGEM = $_SESSION['e'];

    if (isset($_SESSION['id'])){
        unset($_SESSION['e']);
        header("Location: ../../index.php");
        die();
    }
}

$pagLogin->show();