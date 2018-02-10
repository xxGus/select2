<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 26/09/2017
 * Time: 14:53
 */

namespace control\DAO;

require_once "ConnectionFactory.php";
require_once '../../model/Login.php';
require_once '../../model/Usuario.php';

use model\Login;
use model\Usuario;
use PDO;

class DAOLogin
{
    function buscarUsuario(Login $objLogin)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select * from usuario where email = ? and senha = ?";

        $resultado = $pdo->prepare($query);

        $resultado->execute(array(
            $objLogin->getEmail(),
            $objLogin->getSenha()
        ));

        $usuario = $resultado->fetch(PDO::FETCH_OBJ);

        if ($usuario != false) {
            $objUsuario = new Usuario();
            $objUsuario->setId($usuario->id);
            return $objUsuario;
        }
        return false;
    }
}