<?php

namespace src\trasactions;

final class Transaction
{
    private static $conn;

    private function __construct()
    {
        
    }

    public static function open($database)
    {
        if(empty(self::$conn)){
            //self::$conn = Conn
        }
    }
}