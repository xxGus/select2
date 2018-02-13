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
                $query = "insert into cliente(nome, endereco, telefone, celular, id_cliente_sistema) VALUES (?, ?, ?, ?, ?)";
                $resultado = $pdo->prepare($query);

                return $resultado->execute(array(
                    $cliente->getNome(),
                    $cliente->getEndereco(),
                    $cliente->getTelefone(),
                    $cliente->getCelular(),
                    $cliente->getIdClienteSistema()
                ));

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
        $query = "select nome, endereco, telefone, celular, id_cliente_sistema from cliente where id = ?";

        $resultado = $pdo->prepare($query);

        $resultado->execute(array(
            $cliente->getId()
        ));

        $clienteBD = $resultado->fetch(PDO::FETCH_OBJ);
        $cliente->setNome($clienteBD->nome);
        $cliente->setEndereco($clienteBD->endereco);
        $cliente->setTelefone($clienteBD->telefone);
        $cliente->setCelular($clienteBD->celular);
        $cliente->setIdClienteSistema($clienteBD->id_cliente_sistema);
        return $cliente;
    }

    public function alterar(Cliente $cliente)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

//        $query = "select * from cliente WHERE nome = ?";
//        $resultado = $pdo->prepare($query);
//        $resultado->execute([
//            $cliente->getNome()
//        ]);
//
//        if ($resultado->rowCount() == 0) {
            $query = "update cliente set nome = ?, endereco = ?, telefone  = ?, celular = ? where id = ?";
            $resultado = $pdo->prepare($query);

            return $resultado->execute(array(
                $cliente->getNome(),
                $cliente->getEndereco(),
                $cliente->getTelefone(),
                $cliente->getCelular(),
                $cliente->getId()
            ));
//        }
//        return false;
    }

    public function remover(Cliente $cliente)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "delete from cliente where id = ?";

        $resultado = $pdo->prepare($query);

        return $resultado->execute(array(
            $cliente->getId()
        ));
    }

    public function listar($id)
    {
        try {
            $clientes = [];

            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select c.id, c.nome, c.endereco, c.telefone, c.celular, c.id_cliente_sistema from cliente as c inner join cliente_sistema on c.id_cliente_sistema = cliente_sistema.id where cliente_sistema.id = ? order by c.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute([$id]);

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                $cliente = new Cliente();
                $cliente->setId($c->id);
                $cliente->setNome($c->nome);
                $cliente->setEndereco($c->endereco);
                $cliente->setTelefone($c->telefone);
                $cliente->setCelular($c->celular);
                $cliente->setIdClienteSistema($c->id_cliente_sistema);
                array_push($clientes, $cliente);
            }

            return $clientes;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function listaJson($id){
        try {

            $clientes = [];
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select c.id, c.nome, c.endereco, c.telefone, c.id_cliente_sistema from cliente as c inner join cliente_sistema on c.id_cliente_sistema = cliente_sistema.id where cliente_sistema.id = ? order by c.id";

            if ($id == 1) {
                $query = "select c.id, c.nome, c.endereco, c.telefone, c.id_cliente_sistema from cliente as c inner join cliente_sistema on c.id_cliente_sistema = cliente_sistema.id order by c.id";
            }

            $resultado = $pdo->prepare($query);
            $resultado->execute([$id]);

            while ($cli = $resultado->fetch(PDO::FETCH_OBJ)) {
                array_push($clientes, $cli);
            }
            return json_encode($clientes);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}