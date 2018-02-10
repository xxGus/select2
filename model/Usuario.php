<?php
/**
 * Created by Gustavo.
 * User: Gustavo
 * Date: 09/02/2018
 * Time: 23:06
 */

namespace model;

class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $foto;
    private $id_cliente;
    private $nivel;


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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $login
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

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


    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
}