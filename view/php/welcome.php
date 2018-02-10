<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 04/12/2017
 * Time: 13:58
 */

namespace view;

session_start();

require_once "../../lib/raelgc/view/Template.php";
require_once __DIR__ . "/../../model/Menu.php";
require_once __DIR__ . "/../../control/Seguranca.php";
require_once __DIR__ . "/../../control/Config.php";

use raelgc\view\Template;
use control\Seguranca;
use control\Config;

$id_usuario = $_SESSION['id'];

$pagina = new Template("../html/base.html");

Seguranca::chkLogin()
    ? Config::configUsuario($id_usuario, $pagina)
    : header("Location: ../../index.php");

$pagina->addFile('CONTEUDO', "../html/welcome.html");

$pagina->show();