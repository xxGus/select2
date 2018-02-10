<?php
/**
 * Created by Gustavo.
 * User: Gustavo
 * Date: 09/02/2018
 * Time: 23:06
 */

namespace control\DAO;

require_once "ConnectionFactory.php";
require_once __DIR__ . "/../../model/Cliente.php";
require_once __DIR__ . "/../../model/Usuario.php";

use model\Cliente;
use PDO;
use PDOException;

class DAOCliente
{
    public function cadastrar(Cliente $cliente)
    {
        try {
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select * from cliente where nome = ?";
            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $cliente->getNome()
            ));

            if ($resultado->rowCount() == 0) {
                $query = "insert into cliente(nome, endereco, telefone, celular, bloqueado) VALUES (?, ?, ?, ?, ?)";
                $resultado = $pdo->prepare($query);

                $resultado->execute(array(
                    $cliente->getNome(),
                    $cliente->getEndereco(),
                    $cliente->getTelefone(),
                    $cliente->getCelular(),
                    $cliente->getBloqueado()
                ));

                return $pdo->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function buscar(Cliente $cliente)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();
        $query = "select * from cliente where id = ?";

        $resultado = $pdo->prepare($query);

        $resultado->execute(array(
            $cliente->getId()
        ));

        $clienteBD = $resultado->fetch(PDO::FETCH_OBJ);
        $cliente->setNome($clienteBD->nome);
        $cliente->setEndereco($clienteBD->endereco);
        $cliente->setTelefone($clienteBD->telefone);
        $cliente->setCelular($clienteBD->celular);
        $cliente->setBloqueado($clienteBD->bloqueado);

        return $cliente;
    }

    public function alterar(Cliente $cliente)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select * from cliente WHERE nome = ?";
        $resultado = $pdo->prepare($query);
        $resultado->execute([
            $cliente->getNome()
        ]);

        if ($resultado->rowCount() == 0) {
            $query = "update cliente set nome = ?, endereco = ?, telefone = ?, celular = ?, bloqueado = ? where id = ?";
            $resultado = $pdo->prepare($query);

            return $resultado->execute(array(
                $cliente->getNome(),
                $cliente->getEndereco(),
                $cliente->getTelefone(),
                $cliente->getCelular(),
                $cliente->getBloqueado(),
                $cliente->getId()
            ));
        }
        return false;
    }

    public function remover(Cliente $cliente)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "delete from usuario where id_cliente = ?;
                  delete from pizza where id_cliente = ?;
                  delete from produto where id_cliente = ?;
                  delete from cliente where id = ?;";

        $resultado = $pdo->prepare($query);

        return $resultado->execute(array(
            $cliente->getId(),
            $cliente->getId(),
            $cliente->getId(),
            $cliente->getId()
        ));
    }

    public function listar()
    {
        try {
            $clientes = [];

            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();
            $query = "select * from cliente";
            $resultado = $pdo->prepare($query);
            $resultado->execute();

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                $cliente = new Cliente();
                $cliente->setId($c->id);
                $cliente->setNome($c->nome);
                $cliente->setEndereco($c->endereco);
                $cliente->setTelefone($c->telefone);
                $cliente->setCelular($c->celular);
                $cliente->setBloqueado($c->bloqueado);
                array_push($clientes, $cliente);
            }

            return $clientes;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}