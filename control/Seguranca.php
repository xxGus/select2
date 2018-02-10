<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 30/11/2017
 * Time: 11:33
 */

namespace control;

class Seguranca
{
    public static function chkLogin()
    {
        $logado = false;

        if (isset($_SESSION['id'])) $logado = true;

        return $logado;
    }

    public static function chkCliente(){
        if(!isset($_SESSION['master'])){
            echo "Você não tem permissão para acessar esta página!";
            die();
        }
    }

    public static function logOut()
    {
        session_destroy();
    }
}