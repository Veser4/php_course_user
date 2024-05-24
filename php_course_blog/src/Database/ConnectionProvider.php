<?php

namespace App\Database;
use App\Database\DBconfig;

class ConnectionProvider
{
    public static function getConnection(): \PDO
    {
        return new \PDO('mysql:host=' . DBconfig::HOST . ';dbname=' . DBconfig::DBname, DBconfig::USER, DBconfig::PASSWORD);
    }
}
?> 