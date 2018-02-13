<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 12/02/2018
 * Time: 12:45
 */

namespace model;


class ClienteSistema
{
    private $id;
    private $nome;
    private $bloqueado;

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
    public function getBloqueado()
    {
        return $this->bloqueado;
    }

    /**
     * @param mixed $bloqueado
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;
    }
}