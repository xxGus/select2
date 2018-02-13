<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:19
 */

namespace control;

require_once "DAO/DAOProduto.php";
require_once __DIR__ . "/../model/Produto.php";

use control\DAO\DAOProduto;
use Exception;
use model\Produto;

class CtrlProduto
{
    public function cadastrar($nome, $valor, $id_cliente)
    {
        try {
            $DAOProduto = new DAOProduto();
            $produto = new Produto();

            $produto->setNome($nome);
            $produto->setValor($valor);
            $produto->setIdClienteSistema($id_cliente);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Produto já cadastrado, tente novamente.</p>";


            if ($DAOProduto->cadastrar($produto)) {
                $mensagem = "<p class='alert-success' style='text-align: center'>Produto cadastrado com sucesso!</p>";
            }


            return $mensagem;
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function buscar($id)
    {
        try {
            $DAOProduto = new DAOProduto();
            $produto = new Produto();
            $produto->setId($id);

            return $DAOProduto->buscar($produto);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function alterar($id, $nome, $valor)
    {
        try {
            $DAOProduto = new DAOProduto();
            $produto = new Produto();
            $produto->setId($id);
            $produto->setValor($valor);
            $produto->setNome($nome);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Produto já cadastrado, tente novamente.</p>";

                if ($DAOProduto->alterar($produto))
                $mensagem = "<p class='alert-success' style='text-align: center'>Produto alterado com sucesso!</p>";

            return $mensagem;
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function remover($id)
    {
        try {
            $DAOProduto = new DAOProduto();
            $produto = new Produto();
            $produto->setId($id);
            $DAOProduto->remover($produto);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }


//verificar se a classe listar está atendendo o paradigma de O.O.
    public function listar()
    {
        try {
            $DAOProduto = new DAOProduto();
            return $DAOProduto->listar($_SESSION['id_cliente_sistema']);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }

    public function listaJSON()
    {
        try {
            $DAOProduto = new DAOProduto();
            return $DAOProduto->listaJSON($_SESSION['id_cliente']);
        } catch (Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
    }
}