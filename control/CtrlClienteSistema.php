<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 14/09/2017
 * Time: 09:58
 */

namespace control;


require_once "DAO\DAOClienteSistema.php";
require_once __DIR__ . "/../model/ClienteSistema.php";
require_once __DIR__."/../model/Usuario.php";

use model\ClienteSistema;
use control\DAO\DAOClienteSistema;
use Exception;

class CtrlClienteSistema
{
    public function cadastrar($nome, $bloqueado)
    {
        try{
            $DAOClienteSistema = new DAOClienteSistema();
            $clienteSistema = new ClienteSistema();

            $clienteSistema->setNome($nome);
            $clienteSistema->setBloqueado($bloqueado);

            $id_clienteSistema = $DAOClienteSistema->cadastrar($clienteSistema);

            if ($id_clienteSistema != false){
                $_SESSION['id_cliente_sistema'] = $id_clienteSistema;
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
            $DAOClienteSistema = new DAOClienteSistema();
            $cliente = new ClienteSistema();
            $cliente->setId($id);
            return $DAOClienteSistema->buscar($cliente);
        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function alterar($id, $nome, $bloqueado)
    {
        try{
            $DAOClienteSistema = new DAOClienteSistema();
            $cliente = new ClienteSistema();

            $cliente->setId($id);
            $cliente->setNome($nome);
            $cliente->setBloqueado($bloqueado);

            return $DAOClienteSistema->alterar($cliente);

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function remover($id)
    {
        try{
            $DAOClienteSistema = new DAOClienteSistema();
            $cliente = new ClienteSistema();
            $cliente->setId($id);

            return $DAOClienteSistema->remover($cliente);

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }

    public function listar()
    {
        try{
            $DAOClienteSistema = new DAOClienteSistema();

            return $DAOClienteSistema->listar();

        } catch (Exception $exception){
            echo 'Erro: ' . $exception->getMessage();
        }
    }
}