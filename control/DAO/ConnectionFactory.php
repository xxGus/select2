<?php
/**
 * Created by PhpStorm.
 * User: Bolder
 * Date: 13/09/2017
 * Time: 17:19
 */
namespace control\dao;
use PDO;
use PDOException;

class ConnectionFactory{
    private $conn = null;
    private $dbType = "mysql";
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "select2";

    public function getConnectionFactory()
    {
        try{
            $this->conn = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->dbName, $this->user, $this->pass);
            //$this->conn->exec("SET CHARACTER SET UTF8");
            return $this->conn;
        }catch (PDOException $ex){
            echo "Error: ".$ex->getMessage();
        }
    }
}