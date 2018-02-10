<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:19
 */

namespace control\DAO;

require_once "ConnectionFactory.php";
require_once __DIR__ . "/../../model/Pizza.php";

use model\Pizza;
use PDO;
use PDOException;

class DAOPizza
{
    public function cadastrar(Pizza $pizza)
    {
        $connectionFactory = new ConnectionFactory();
        $pdo = $connectionFactory->getConnection();

        $query = "select * from pizza where nome = ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $pizza->getNome()
        ]);

        if ($resultado->rowCount() == 0) {
            $query = "insert into pizza(nome, ingrediente, valor, id_cliente) values(?, ?, ?, ?)";
            $resultado = $pdo->prepare($query);

            return
                $resultado->execute(array(
                    $pizza->getNome(),
                    $pizza->getIngrediente(),
                    $pizza->getValor(),
                    $pizza->getIdCliente()
                ));
        }

        return false;
    }

    public function buscar(Pizza $pizza)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select nome, ingrediente, valor, id_cliente from canal where id= ?";

        $resultado = $pdo->prepare($query);
        $resultado->execute([
            $pizza->getId()
        ]);

        $userBD = $resultado->fetch(PDO::FETCH_OBJ);

        $pizza->setNome($userBD->nome);
        $pizza->setIngrediente($userBD->ingrediente);
        $pizza->setValor($userBD->valor);
        $pizza->setIdCliente($userBD->id_cliente);

        return $pizza;
    }

    public function alterar(Pizza $pizza)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select * from pizza where nome = ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $pizza->getNome()
        ]);

        if ($resultado->rowCount() == 0) {
            $query = "update pizza set nome = ?, ingrediente = ?, valor = ? where id = ?";
            $resultado = $pdo->prepare($query);
            return
                $resultado->execute(array(
                    $pizza->getNome(),
                    $pizza->getIngrediente(),
                    $pizza->getValor(),
                    $pizza->getId()
                ));

        }

        return false;
    }

    public function remover(Pizza $pizza)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();
        $query = "delete from pizza where id = ?";
        $resultado = $pdo->prepare($query);
        return $resultado->execute(array(
            $pizza->getId()
        ));
    }

    /**
     * @return array
     */

    public function listar($id)
    {
        try {
            $pizzas = [];
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select pi.id, pi.nome, pi.ingrediente, pi.valor, pi.id_cliente from pizza as pi inner join cliente on pi.id_cliente = cliente.id where cliente.id = ? order by pi.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $id
            ));

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                $pizza = new Pizza();
                $pizza->setId($c->id);
                $pizza->setNome($c->nome);
                $pizza->setIngrediente($c->ingrediente);
                $pizza->setValor($c->valor);
                $pizza->setIdCliente($c->id_cliente);
                array_push($pizzas, $pizza);
            }
            return $pizzas;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function listaJson($id)
    {
        try {
            $canais = [];
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select c.id, c.nome, c.source, c.medium, c.id_cliente from canal as c inner join cliente on c.id_cliente = cliente.id where cliente.id = ? order by c.id";

            if ($id == 1) {
                $query = "select c.id, c.nome, c.source, c.medium, c.id_cliente from canal as c inner join cliente on c.id_cliente = cliente.id order by c.id";
            }

            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $id
            ));

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                array_push($canais, $c);
            }
            return json_encode($canais);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}

