<?php
/**
 * Created by PhpStorm.
 * User: Gustavo Baptista
 * Date: 28/11/2017
 * Time: 13:48
 */

namespace model;

class Menu
{
    function __construct($pagina, $id)
    {
        $menu = [

            [
                "URL_MENU" => "ViewCliente.php",
                "CLASS_ICON" => "fa fa-edit",
                "NOME_OPC" => "<span>Gerenciar Clientes</span>",
                "SUBMENU" => false
            ],

            [
                "URL_MENU" => "ViewUsuario.php",
                "CLASS_ICON" => "fa fa-edit",
                "NOME_OPC" => "<span>Gerenciar Usuários</span>",
                "SUBMENU" => false
            ],

            [
                "URL_MENU" => "#",
                "CLASS_ICON" => "fa fa-link",
                "NOME_OPC" => "<span>Gerenciar Urls</span><i class='fa fa-angle-left pull-right'></i>",
                "SUBMENU" => [
                    [
                        "URL_SUB" => "ViewVenda.php",
                        "NOME_OPCSUB" => "URL"
                    ],
                    [
                        "URL_SUB" => "ViewPizza.php",
                        "NOME_OPCSUB" => "Pizza"
                    ],
                    [
                        "URL_SUB" => "ViewProduto.php",
                        "NOME_OPCSUB" => "Produto"
                    ]
                ]
            ]
        ];

        $urlAtual = explode('/', $_SERVER['PHP_SELF']);

        foreach ($menu as $m_item) {

            $pagina->URL_MENU = $m_item['URL_MENU'];
            $pagina->NOME_OPC = $m_item['NOME_OPC'];
            $pagina->CLASS_ICON = $m_item['CLASS_ICON'];
            $classLi = "link-menu";

            if ($id != 1 && $m_item['NOME_OPC'] == "<span>Gerenciar Clientes</span>") {
                $classLi = ' disable';
            }

            if (in_array($m_item['URL_MENU'], $urlAtual)) {
                $classLi .= " active";
            }

            if ($m_item['URL_MENU'] == "#") {
                $classLi .= " treeview";
            }

            if ($m_item['SUBMENU']) {
                foreach ($m_item['SUBMENU'] as $item) {
                    $pagina->URL_SUB = $item['URL_SUB'];
                    $pagina->NOME_OPCSUB = $item['NOME_OPCSUB'];

                    if (in_array($item['URL_SUB'], $urlAtual)) {
                        $classLi .= " active";
                    }

                    $pagina->block("BLOCK_ITEMSUB");
                }
                $pagina->block("BLOCK_SUBMENU");

            } else {
                $pagina->block("BLOCK_VAZIO");
            }

            $pagina->CLASS_LI = $classLi;
            $pagina->block("BLOCK_MENU");
        }
    }
}