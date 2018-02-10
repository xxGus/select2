<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 26/09/2017
 * Time: 14:53
 */

namespace control;

require_once __DIR__."/../model/Login.php";
require_once __DIR__."/../model/Usuario.php";
require_once "DAO/DAOLogin.php";

use control\DAO\DAOLogin;
use model\Login;
use model\Usuario;

session_start();

class CtrlLogin
{
    public function buscarUsuario($email, $senha){

        $objLogin = new Login();
        $objLoginDAO = new DAOLogin();
//        seta as iformações vindas da view no objeto da classe modelo de Login
        $objLogin->setEmail($email);
        $objLogin->setSenha($senha);
//        busca um usuario no banco de acordo com o email informado e senha, e atribui esse valor a um objeto
        $obj = $objLoginDAO->buscarUsuario($objLogin);

        $obj != false
            ? $_SESSION['id'] = $obj->getId()
            : $_SESSION['e'] = "<p class='alert-danger' style='text-align: center'>Usuario e/ou senha incorreto(s), tente novamente.</p>";
    }
}