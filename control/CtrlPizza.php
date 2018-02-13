<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:19
 */

namespace control;

require_once "DAO/DAOPizza.php";
require_once __DIR__ . "/../model/Pizza.php";

use control\DAO\DAOPizza;
use model\Pizza;
use Exception;

class CtrlPizza
{
    public function cadastrar($nome, $ingrediente, $valor, $id_cliente_sistema)
    {
        try {
            $DAOPizza = new DAOPizza();
            $pizza = new Pizza();

            $pizza->setNome($nome);
            $pizza->setIngrediente($ingrediente);
            $pizza->setValor($valor);
            $pizza->setIdClienteSistema($id_cliente_sistema);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Pizza já cadastrada, tente novamente.</p>";

            if ($DAOPizza->cadastrar($pizza))
                $mensagem = "<p class='alert-success' style='text-align: center'>Pizza cadastrada com sucesso!</p>";

            return $mensagem;

        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function buscar($id)
    {
        try {
            $DAOPizza = new DAOPizza();
            $pizza = new Pizza();
            $pizza->setId($id);

            return $DAOPizza->buscar($pizza);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function alterar($id, $nome, $ingrediente, $valor)
    {
        try {
            $DAOPizza = new DAOPizza();
            $pizza = new Pizza();
            $pizza->setId($id);
            $pizza->setNome($nome);
            $pizza->setIngrediente($ingrediente);
            $pizza->setValor($valor);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Pizza já cadastrada, tente novamente.</p>";

            if ($DAOPizza->alterar($pizza))
                $mensagem = "<p class='alert-success' style='text-align: center'>Pizza alterada com sucesso!</p>";

            return $mensagem;

        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function remover($id)
    {
        try {
            $DAOPizza = new DAOPizza();
            $pizza = new Pizza();
            $pizza->setId($id);
            $DAOPizza->remover($pizza);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    // Reutilizar o mesmo método para retornar um objeto ou um JSON
    // Passar um parâmetro para a função listar, desse método para fazer as comparações

    public function listar()
    {
        try {
            $DAOPizza = new DAOPizza();
            return $DAOPizza->listar($_SESSION['id_cliente_sistema']);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }
}