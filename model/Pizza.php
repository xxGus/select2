<?php

namespace model;

class Pizza{
    private $id;
    private $nome;
    private $ingrediente;
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