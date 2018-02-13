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
        $pdo = $connectionFactory->getConnectionFactory();

        $query = "select * from pizza where nome = ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $pizza->getNome()
        ]);

        if ($resultado->rowCount() == 0) {
            $query = "insert into pizza(nome, ingrediente, valor, id_cliente_sistema) values(?, ?, ?, ?)";
            $resultado = $pdo->prepare($query);

            return
                $resultado->execute(array(
                    $pizza->getNome(),
                    $pizza->getIngrediente(),
                    $pizza->getValor(),
                    $pizza->getIdClienteSistema()
                ));
        }

        return false;
    }

    public function buscar(Pizza $pizza)
    {

        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select nome, ingrediente, valor, id_cliente_sistema from pizza where id= ?";

        $resultado = $pdo->prepare($query);
        $resultado->execute([
            $pizza->getId()
        ]);

        $userBD = $resultado->fetch(PDO::FETCH_OBJ);

        $pizza->setNome($userBD->nome);
        $pizza->setIngrediente($userBD->ingrediente);
        $pizza->setValor($userBD->valor);
        $pizza->setIdClienteSistema($userBD->id_cliente_sistema);

        return $pizza;
    }

    public function alterar(Pizza $pizza)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

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

            $query = "select pi.id, pi.nome, pi.ingrediente, pi.valor, pi.id_cliente_sistema from pizza as pi inner join cliente_sistema on pi.id_cliente_sistema = cliente_sistema.id where cliente_sistema.id = ? order by pi.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $id
            ));

            while ($pi = $resultado->fetch(PDO::FETCH_OBJ)) {
                $pizza = new Pizza();
                $pizza->setId($pi->id);
                $pizza->setNome($pi->nome);
                $pizza->setIngrediente($pi->ingrediente);
                $pizza->setValor($pi->valor);
                $pizza->setIdClienteSistema($pi->id_cliente_sistema);
                array_push($pizzas, $pizza);
            }
            return $pizzas;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}

