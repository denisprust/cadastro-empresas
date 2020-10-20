<?php

namespace TesteElian\Core;

use TesteElian\Core\Connection;

class Model
{
    public $Error = false;
    public $Connection;

    function __construct()
    {
        $this->Connection = (new Connection())->Connection;
    }

    function beginTransaction()
    {
        return $this->Connection->beginTransaction();
    }

    function commit()
    {
        return $this->Connection->commit();
    }

    function rollback()
    {
        return $this->Connection->rollBack();
    }

    function close()
    {
        return $this->Connection->close();
    }
}