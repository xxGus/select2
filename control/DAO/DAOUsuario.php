<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 14/09/2017
 * Time: 10:00
 */

namespace control\dao;

require_once "ConnectionFactory.php";
require_once __DIR__ . "/../../model/Usuario.php";
require_once __DIR__ . "/../../model/Cliente.php";

use model\ClienteSistema;
use model\Usuario;
use PDO;
use PDOException;
use Exception;

class DAOUsuario
{
    public function cadastrar(Usuario $usuario)
    {
        try{
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();
            $query = "select * from usuario where email = ?";
            $resultado = $pdo->prepare($query);

            $resultado->execute(array(
                $usuario->getEmail()
            ));

            if ($resultado->rowCount() == 0){
                $query = "insert into usuario(nome, email, senha, foto, id_cliente_sistema, nivel) values (?,?,?,?,?,?)";
                $resultado = $pdo->prepare($query);

                return
                    $resultado->execute(array($usuario->getNome(),
                        $usuario->getEmail(),
                        $usuario->getSenha(),
                        $usuario->getFoto(),
                        $usuario->getIdClienteSistema(),
                        $usuario->getNivel()));
            }
            return false;
        }catch (PDOException $e){
            echo "Erro: " . $e->getMessage();
        }

    }

    public function buscar(Usuario $usuario)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select u.nome, u.email, u.nivel, u.foto, u.id_cliente_sistema from usuario as u INNER JOIN cliente_sistema as c on u.id_cliente_sistema = c.id where u.id = ?";

        $resultado = $pdo->prepare($query);
        $resultado->execute(array($usuario->getId()));

        while ($userBD = $resultado->fetch(PDO::FETCH_OBJ)) {
            if (!is_null($userBD)) {
                $usuario->setNome($userBD->nome);
                $usuario->setEmail($userBD->email);
                $usuario->setNivel($userBD->nivel);
                $usuario->setFoto($userBD->foto);
                $usuario->setIdClienteSistema($userBD->id_cliente_sistema);
            }
        }

        return $usuario;
    }

    public function alterar(Usuario $usuario)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $campos = [
            $usuario->getNome(),
            $usuario->getEmail(),
            $usuario->getIdClienteSistema(),
            $usuario->getNivel()
        ];

        $query = "update usuario set nome = ?, email = ?, id_cliente_sistema = ?, nivel = ?";
//        $query = "update usuario set nome = ?, email = ?, foto = ?, id_cliente = ?, nivel = ? where id = ?";


        if ($usuario->getFoto() != "") {
            $query .= ", foto = ?";
            array_push($campos, $usuario->getFoto());
        }

        if ($usuario->getSenha() != "") {
            $query .= ", senha = ?";
            array_push($campos, $usuario->getSenha());
        }

        $resultado = $pdo->prepare($query . "where id = ?");
        array_push($campos, $usuario->getId());

        return $resultado->execute($campos);

    }

    public function remover(Usuario $usuario)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "delete from usuario where id = ?";
        $resultado = $pdo->prepare($query);
        return $resultado->execute(array($usuario->getId()));
    }

    /**
     * @return array
     */
    public function listar($id)
    {
        try {
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $usuarios = [];

            $query = "select u.id, u.nome, u.email, u.nivel, u.id_cliente_sistema, c.nome as nome_cliente from usuario as u right join cliente_sistema as c on u.id_cliente_sistema = c.id WHERE ? = c.id order by u.id_cliente_sistema";

            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $id
            ));

            while ($u = $resultado->fetch(PDO::FETCH_OBJ)) {
                array_push($usuarios, $u);
            }

            return $usuarios;
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function senhaCorreta($id, $senhaAntiga)
    {
        try {
            $senhaCorreta = false;
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();
            $query = "select * from usuario where id = ? and senha = ?";
            $resultado = $pdo->prepare($query);

            $resultado->execute(
                array(
                    $id,
                    $senhaAntiga
                )
            );

            $usuario = $resultado->fetch(PDO::FETCH_OBJ);

            if ($usuario != false) {
                $senhaCorreta = true;
            }

            return $senhaCorreta;
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}