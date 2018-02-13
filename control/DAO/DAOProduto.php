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
            $query = "insert into produto(nome, valor, id_cliente_sistema) values (?, ?, ?)";
            $resultado = $pdo->prepare($query);

            return
                $resultado->execute(array(
                    $produto->getNome(),
                    $produto->getValor(),
                    $produto->getIdClienteSistema()
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

        $query = "select nome, valor, id_cliente_sistema from produto where id= ?";
        $resultado = $pdo->prepare($query);

        $resultado->execute([
            $produto->getId()
        ]);

        $userBD = $resultado->fetch(PDO::FETCH_OBJ);

        $produto->setNome($userBD->nome);
        $produto->setValor($userBD->valor);
        $produto->setIdClienteSistema($userBD->id_cliente_sistema);

        return $produto;
    }

    public function alterar(Produto $produto)
    {

        $objConnectionFactory = new ConnectionFactory();
        $pdo = $objConnectionFactory->getConnectionFactory();

        $query = "update produto set nome = ?, valor = ? where id = ?";
        $resultado = $pdo->prepare($query);

        return $resultado->execute(array(
            $produto->getNome(),
            $produto->getValor(),
            $produto->getId()
        ));

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
            $query = "select po.id, po.nome, po.valor, po.id_cliente_sistema from produto as po inner join cliente_sistema on po.id_cliente_sistema = cliente_sistema.id where cliente_sistema.id = ? order by po.id";

            $resultado = $pdo->prepare($query);
            $resultado->execute([
                $id
            ]);


            while ($po = $resultado->fetch(PDO::FETCH_OBJ)) {

                $produto = new Produto();
                $produto->setId($po->id);
                $produto->setNome($po->nome);
                $produto->setValor($po->valor);
                $produto->setIdClienteSistema($po->id_cliente_sistema);
                array_push($produtos, $produto);
            }

            return $produtos;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}