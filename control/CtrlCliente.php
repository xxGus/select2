<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 14/09/2017
 * Time: 09:58
 */

namespace control;


require_once "DAO\DAOCliente.php";
require_once __DIR__."/../model/Cliente.php";
require_once __DIR__."/../model/Usuario.php";

use model\Cliente;
use model\Usuario;
use control\DAO\DAOCliente;
use Exception;

class CtrlCliente
{
    public function cadastrar($nome, $url, $id_view)
    {
        try{
            $objClienteDAO = new DAOCliente();
            $cliente = new Cliente();

            $cliente->setNome($nome);
            $cliente->setEndereco($url);
            $cliente->setTelefone($id_view);

            $id_cliente = $objClienteDAO->cadastrar($cliente);

            if ($id_cliente != false){
                $_SESSION['id_cliente'] = $id_cliente;
                $_SESSION['new-cli'] =  "<p class='alert-success' style='text-align: center'>Cliente cadastrado com sucesso, cadastre um novo usuario.</p>";
                header("Location: ViewUsuario.php");
            }

            return "<p class='alert-danger' style='text-align: center'>Cliente já existe, informe um novo cliente.</p>";

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function buscar($id)
    {
        try{
            $objClienteDAO = new DAOCliente();
            $cliente = new Cliente();
            $cliente->setId($id);
            return $objClienteDAO->buscar($cliente);
        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function alterar($id, $nome, $url, $id_view)
    {
        try{
            $objClienteDAO = new DAOCliente();
            $cliente = new Cliente();

            $cliente->setId($id);
            $cliente->setNome($nome);
            $cliente->setEndereco($url);
            $cliente->setTelefone($id_view);

            return $objClienteDAO->alterar($cliente);

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function remover($id)
    {
        try{
            $objClienteDAO = new DAOCliente();
            $cliente = new Cliente();
            $cliente->setId($id);

            return $objClienteDAO->remover($cliente);

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function listar()
    {
        try{
            $objClienteDAO = new DAOCliente();

            return $objClienteDAO->listar();

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }
}