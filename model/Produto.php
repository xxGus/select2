<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30/09/2017
 * Time: 02:18
 */

namespace model;

class Produto
{
    private $id;
    private $nome;
    private $valor;
    private $id_cliente_sistema;

    /**
     * @return mixed
     */
    public function getIdClienteSistema()
    {
        return $this->id_cliente_sistema;
    }

    /**
     * @param mixed $id_cliente_sistema
     */
    public function setIdClienteSistema($id_cliente_sistema)
    {
        $this->id_cliente_sistema = $id_cliente_sistema;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
}