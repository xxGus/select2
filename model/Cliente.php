<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 13/09/2017
 * Time: 17:00
 */

namespace model;

class Cliente
{
    private $id;
    private $nome;
    private $endereco;
    private $telefone;
    private $celular;
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
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
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
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }



}