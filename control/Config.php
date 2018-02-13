<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 04/10/2017
 * Time: 11:32
 */

namespace control;

require_once 'CtrlUsuario.php';
require_once 'CtrlClienteSistema.php';
require_once __DIR__ . '/../model/Menu.php';

use model\Menu;

class Config
{
    public static function configUsuario($id, $pagina)
    {

        $ctrlUsuario = new CtrlUsuario();
        $ctrlCliente = new CtrlClienteSistema();

        $usuario = $ctrlUsuario->buscar($id);

        $cliente = $ctrlCliente->buscar($usuario->getIdClienteSistema());

        if(!isset($_SESSION['id_cliente_sistema']))
            $_SESSION['id_cliente_sistema'] = $cliente->getId();

        if ($cliente->getId() == 1) {

            $clientes = $ctrlCliente->listar();

//            foreach ($clientes as $cli) {
//                $pagina->ID_CLIENTE = $cli->getId();
//                $pagina->NOME_CLIENTE = $cli->getNome();
//                $pagina->block("BLOCK_CLIENTES");
//            }
//
//            $pagina->block("BLOCK_BTN_CLI");

            if (isset($_POST['id-cli'])) {
                $_SESSION['id_cliente_sistema'] = $_POST['id-cli'];
            }

            $_SESSION['master'] = $cliente->getId();

            $menu = new Menu($pagina, $_SESSION['master']);

        } else{
            $menu = new Menu($pagina, $_SESSION['id_cliente_sistema']);
        }

        $pagina->EMPRESA = "<b>" . strtoupper($cliente->getNome()) . "</b>";
        $pagina->FOTO = "../../view/fotos-usuarios/" . $usuario->getFoto();
        $pagina->NOME_PAG = $usuario->getNome();

    }
}