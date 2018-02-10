<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 01/12/2017
 * Time: 14:19
 */

namespace control;


class CtrlPagina
{
    function __construct($pg, $id, $linkCadastrar, $linkAlterar)
    {
        $urlAtual = explode('/', $_SERVER['PHP_SELF']);

        $ctrlUsuario = new CtrlUsuario();
        $usuario = $ctrlUsuario->buscar($id);

        $pg->CONTEUDO = "";
        $pg->REMOVER = "";
        $pg->ALTERAR = "";

        if ($usuario->getNivel() < '2') {

            $pg->ALTERAR = "<a href='?id={ID}'><i id='alterar' class='edit'></i></a>";

            $pg->REMOVER = "<form action='' method='post'>
                                <input type='hidden' value='{ID}' name='id-remove'>
                                <button name='remover' class='rmv'><i id='remover' class='remove'></i></button>
                            </form>";

            !isset($_GET['id'])
                ? $pg->addFile("CONTEUDO", $linkCadastrar)
                : $pg->addFile("CONTEUDO", $linkAlterar);


        }

        if (in_array("ViewProduto.php", $urlAtual)) {
            $this->montarPagCampanha($pg, $linkCadastrar, $linkAlterar);
        }

    }

    private function montarPagCampanha($pg, $linkCadastrar, $linkAlterar)
    {
        $pg->ALTERAR = "<a href='?id={ID}'><i id='alterar' class='edit'></i></a>";

        $pg->REMOVER = "<form action='' method='post'>
                            <input type='hidden' value='{ID}' name='id-remove'>
                            <button name='remover' class='rmv'><i id='remover' class='remove'></i></button>
                        </form>";

        !isset($_GET['id'])
            ? $pg->addFile("CONTEUDO", $linkCadastrar)
            : $pg->addFile("CONTEUDO", $linkAlterar);
    }

}