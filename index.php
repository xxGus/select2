<?php
/**
 * Created by PhpStorm.
 * User: Gustavo Baptista
 * Date: 15/09/2017
 * Time: 10:35
 */

namespace view;

use control\Seguranca;

require_once "control/Seguranca.php";

session_start();

if($_POST['out'] == 1) Seguranca::logOut();

Seguranca::chkLogin()
    ? header("Location: view/php/welcome.php")
    : header("Location: view/php/ViewLogin.php");