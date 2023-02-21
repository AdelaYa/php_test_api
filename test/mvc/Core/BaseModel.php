<?php

namespace Core;


use Models\DbConnect;

class BaseModel
{
    protected ?\PDO $dbConnect = null;

    public function __construct()
    {
        $this->dbConnect = DbConnect::getConnect();
    }
}