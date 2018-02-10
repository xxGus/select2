<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 26/09/2017
 * Time: 14:33
 */
namespace model;

class Login
{
    private $email;
    private $senha;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
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


}