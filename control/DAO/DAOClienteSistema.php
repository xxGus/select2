<?php
/**
 * Created by Gustavo.
 * User: Gustavo
 * Date: 09/02/2018
 * Time: 23:06
 */

namespace control\DAO;

require_once "ConnectionFactory.php";
require_once __DIR__ . "/../../model/ClienteSistema.php";
require_once __DIR__ . "/../../model/Usuario.php";

use model\ClienteSistema;
use PDO;
use PDOException;

class DAOClienteSistema
{
    public function cadastrar(ClienteSistema $clienteSistema)
    {
        try {
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select * from cliente_sistema where nome = ?";
            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $clienteSistema->getNome()
            ));

            if ($resultado->rowCount() == 0) {
                $query = "insert into cliente_sistema(nome, bloqueado) VALUES (?, ?)";
                $resultado = $pdo->prepare($query);

                $resultado->execute(array(
                    $clienteSistema->getNome(),
                    $clienteSistema->getBloqueado()
                ));

                return $pdo->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function buscar(ClienteSistema $clienteSistema)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();
        $query = "select * from cliente_sistema where id = ?";

        $resultado = $pdo->prepare($query);

        $resultado->execute(array(
            $clienteSistema->getId()
        ));

        $clienteSistemaBD = $resultado->fetch(PDO::FETCH_OBJ);
        $clienteSistema->setNome($clienteSistemaBD->nome);
        $clienteSistema->setBloqueado($clienteSistemaBD->bloqueado);

        return $clienteSistema;
    }

    public function alterar(ClienteSistema $clienteSistema)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "update cliente_sistema set nome = ?, bloqueado = ? where id = ?";
        $resultado = $pdo->prepare($query);

        return $resultado->execute(array(
            $clienteSistema->getNome(),
            $clienteSistema->getBloqueado(),
            $clienteSistema->getId()
        ));

    }

    public function remover(ClienteSistema $clienteSistema)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "delete from usuario where id_cliente_sistema = ?;
                  delete from pizza where id_cliente_sistema = ?;
                  delete from produto where id_cliente_sistema = ?;
                  delete from cliente_sistema where id = ?;";

        $resultado = $pdo->prepare($query);

        return $resultado->execute(array(
            $clienteSistema->getId(),
            $clienteSistema->getId(),
            $clienteSistema->getId(),
            $clienteSistema->getId()
        ));
    }

    public function listar()
    {
        try {
            $clientesSistema = [];

            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();
            $query = "select * from cliente_sistema";
            $resultado = $pdo->prepare($query);
            $resultado->execute();

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                $clienteSistema = new ClienteSistema();
                $clienteSistema->setId($c->id);
                $clienteSistema->setNome($c->nome);
                $clienteSistema->setBloqueado($c->bloqueado);
                array_push($clientesSistema, $clienteSistema);
            }

            return $clientesSistema;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}