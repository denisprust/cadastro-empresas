<?php
namespace TesteElian\Core;

use PDO;
use PDOException;

class Connection {

    public $Connection = null;

    function __construct()
    {
        if (!$this->Connection) {
            $this->connect();
        }
    }

    /**
     * Faz a conexão com o banco de dados
     */
    public function connect()
    {
        try {
            $this->Connection = new PDO('mysql:host=localhost;dbname=elian', 'root', ''); 

            $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falha na conexão com o banco de dados.: ' . $e->getMessage();
        }

        return true;
    }

}