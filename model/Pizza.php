<?php

namespace model;

class Pizza{
    private $id;
    private $nome;
    private $ingrediente;
    private $valor;
    private $id_cliente;

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * @param mixed $id_cliente
     */
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getIngrediente(){
        return $this->ingrediente;
    }

    public function setIngrediente($ingrediente){
        $this->ingrediente = $ingrediente;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }
}