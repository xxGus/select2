<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 14/09/2017
 * Time: 10:00
 */

namespace control;

require_once "DAO/DAOUsuario.php";
require_once __DIR__."/../model/Usuario.php";

use control\DAO\DAOUsuario;
use model\Usuario;
use Exception;

class CtrlUsuario
{
    public function cadastrar($nome, $email, $senha, $foto, $nivel)
    {
        try{
            $objUsuarioDAO = new DAOUsuario();
            $usuario = new Usuario();
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setSenha($senha);
            $usuario->setFoto($foto);
            $usuario->setNivel($nivel);

            $usuario->setIdCliente($_SESSION['id_cliente']);

            if($objUsuarioDAO->cadastrar($usuario) != false){
                return true;
            }
            return false;
        }catch (Exception $e){
            echo "Erro: ". $e->getMessage();
        }
    }

    public function buscar($id)
    {
        $objDAOUsuario = new DAOUsuario();
        $usuario = new Usuario();
        $usuario->setId($id);
        return $objDAOUsuario->buscar($usuario);
    }

    public function alterar($id, $nome, $email, $foto, $id_cliente, $nivel, $oldSenha, $newSenha, $senhaAlterada)
    {
        try{

            $objUsuarioDAO = new DAOUsuario();
            $usuario = new Usuario();

            $usuario->setSenha("");

            if ($senhaAlterada){
                if ($objUsuarioDAO->senhaCorreta($id, $oldSenha)){
                    $usuario->setSenha($newSenha);
                } else {
                    return "<p class='alert-danger' style='text-align: center'>Senha incorreta, tente novamente.</p>";
                }
            }

            $usuario->setId($id);
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setIdCliente($id_cliente);
            $usuario->setNivel($nivel);

            $usuario->setFoto($foto);


            $objUsuarioDAO->alterar($usuario);
            return "<p class='alert-success' style='text-align: center'>Usuario alterado com sucesso.</p>";

        }catch (Exception $e){
            echo "Erro: ". $e->getMessage();
        }
    }

    public function remover($id)
    {
        $objUsuarioDAO = new DAOUsuario();
        $usuario = new Usuario();
        $usuario->setId($id);
        $objUsuarioDAO->remover($usuario);
    }

    public function listar()
    {
        $objUsuario = new DAOUsuario();
        return $objUsuario->listar($_SESSION['id_cliente']);
    }
}