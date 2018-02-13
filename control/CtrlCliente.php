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
use control\DAO\DAOCliente;
use Exception;

class CtrlCliente
{
    public function cadastrar($nome, $endereco, $telefone, $celular, $id_cliente_sistema)
    {
        try{
            $DAOCliente = new DAOCliente();
            $cliente = new Cliente();

            $cliente->setNome($nome);
            $cliente->setEndereco($endereco);
            $cliente->setTelefone($telefone);
            $cliente->setCelular($celular);
            $cliente->setIdClienteSistema($id_cliente_sistema);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Cliente já cadastrado, tente novamente.</p>";

            if ($DAOCliente->cadastrar($cliente))
                $mensagem = "<p class='alert-success' style='text-align: center'>Cliente cadastrado com sucesso!</p>";


            return $mensagem;

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function buscar($id)
    {
        try{
            $DAOCliente = new DAOCliente();
            $cliente = new Cliente();
            $cliente->setId($id);
            return $DAOCliente->buscar($cliente);
        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function alterar($id, $nome, $endereco, $telefone, $celular)
    {
        try{
            $DAOCliente = new DAOCliente();
            $cliente = new Cliente();

            $cliente->setId($id);
            $cliente->setNome($nome);
            $cliente->setEndereco($endereco);
            $cliente->setTelefone($telefone);
            $cliente->setCelular($celular);

            $mensagem = "<p class='alert-danger' style='text-align: center'>Cliente já cadastrado, tente novamente.</p>";

            if ($DAOCliente->alterar($cliente))
                $mensagem = "<p class='alert-success' style='text-align: center'>Cliente alterado com sucesso!</p>";

            return $mensagem;
        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function remover($id)
    {
        try{
            $DAOCliente = new DAOCliente();
            $cliente = new Cliente();
            $cliente->setId($id);

            return $DAOCliente->remover($cliente);

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function listar()
    {
        try{
            $DAOCliente = new DAOCliente();
            return $DAOCliente->listar($_SESSION['id_cliente_sistema']);
        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function listaJson()
    {
        try{
        $DAOCliente = new DAOCliente();
        return $DAOCliente->listaJson($_SESSION['id_cliente_sistema']);
        } catch (Exception $e){
            echo "Erro: " . $e->getMessage();
        }
    }

}