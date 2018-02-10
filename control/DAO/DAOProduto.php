<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 02/10/2017
 * Time: 16:19
 */

namespace control\DAO;

require_once "ConnectionFactory.php";
require_once __DIR__ . "/../../model/Produto.php";

use model\Produto;
use PDO;
use PDOException;


class DAOProduto
{

    public function cadastrar(Produto $produto)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select * from produto where nome = ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute(array($produto->getNome()));

        if ($resultado->rowCount() == 0) {
            $query = "insert into produto(nome, valor, id_cliente) values (?, ?, ?)";
            $resultado = $pdo->prepare($query);

            return
                $resultado->execute(array(
                    $produto->getNome(),
                    $produto->getValor(),
                    $produto->getIdCliente()
                ));
        }

        return false;
    }

    public function buscarPorNome(Produto $produto)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();
        $query = "select * from produto where ? = produto.nome";

        $resultado = $pdo->prepare($query);
        $resultado->execute(array(
            $produto->getNome()
        ));

        return $resultado->fetch(PDO::FETCH_OBJ);
    }

    public function buscar(Produto $produto)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select nome, valor, id_cliente from produto where id= ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $produto->getId()
        ]);

        $userBD = $resultado->fetch(PDO::FETCH_OBJ);

        $produto->setNome($userBD->nome);
        $produto->setValor($userBD->valor);
        $produto->setIdCliente($userBD->id_cliente);

        return $produto;
    }

    public function alterar(Produto $produto)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "select * from produto where nome = ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $produto->getNome()
        ]);

        if ($resultado->rowCount() == 0) {
            $query = "update campanha set nome = ?, valor = ? where id = ?";
            $resultado = $pdo->prepare($query);
            return
                $resultado->execute(array(
                    $produto->getNome(),
                    $produto->getValor(),
                    $produto->getId()
                ));
        }

        return false;
    }

    public function remover(Produto $produto)
    {
        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();
        $query = "delete from produto where id = ?";
        $resultado = $pdo->prepare($query);
        return $resultado->execute(array(
            $produto->getId()
        ));
    }

    /**
     * @return array
     */
    public function listar($id)
    {
        try {
            $produtos = [];
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();
            $query = "select po.id, po.nome, po.valor, po.id_cliente from produto as po inner join cliente on po.id_cliente = cliente.id where cliente.id = ? order by c.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute([
                $id
            ]);

            while ($po = $resultado->fetch(PDO::FETCH_OBJ)) {
                $produto = new Produto();
                $produto->setId($po->id);
                $produto->setNome($po->nome);
                $produto->setValor($po->valor);
                $produto->setIdCliente($po->id_cliente);
                array_push($produtos, $produto);
            }

            return $produtos;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function listaJSON($id)
    {
        try {
            $campanhas = [];
            $objConnectionFactory = new ConnectionFactory();
            $pdo = $objConnectionFactory->getConnectionFactory();

            $query = "select c.id, c.nome, c.id_cliente from campanha as c inner join cliente on c.id_cliente = cliente.id where cliente.id = ? order by c.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute(array(
                $id
            ));

            while ($c = $resultado->fetch(PDO::FETCH_OBJ)) {
                array_push($campanhas, $c);
            }

            return json_encode($campanhas);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}