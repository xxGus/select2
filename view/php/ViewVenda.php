<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:17
 */

namespace view;

session_start();

require_once __DIR__ . "/../../lib/raelgc/view/Template.php";
require_once __DIR__ . "/../../control/Config.php";
require_once __DIR__ . "/../../control/Seguranca.php";

use control\Config;
use raelgc\view\Template;
use control\Seguranca;

$pagina = new Template("../html/base.html");

Seguranca::chkLogin()
    ? Config::configUsuario($_SESSION['id'], $pagina)
    : header("Location: ../../index.php");

$pagina->addFile("CONTEUDO", "../html/GerenciarVenda/Venda.html");

$pagina->show();