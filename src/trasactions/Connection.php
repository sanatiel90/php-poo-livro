<?php

namespace src\trasactions;

use Exception;
use PDO;

class Connection
{
    private function __construct()
    {
        
    }

    public static function open($configFile)
    {
        //verifica se existe arq de config para este banco, possivel de armazenar de outra forma
        if(file_exists("config/{$configFile}.ini")) {
            $db = parse_ini_file("config/{$configFile}.ini");
        } else {
            throw new Exception("Arquivo {$configFile} não encontrado");
        }

        try {
            //lê as informacoes do arq
            $user = isset($db['user']) ? $db['user'] : null;
            $pass = isset($db['pass']) ? $db['pass'] : null;
            $dbName = isset($db['dbName']) ? $db['dbName'] : null;
            $host = isset($db['host']) ? $db['host'] : null;
            $type = isset($db['type']) ? $db['type'] : null;
            $port = isset($db['port']) ? $db['port'] : null;

            switch($type){
                case "pgsql":
                    $port = $port ? $port : '5432';
                    $conn = new PDO("pgsql:host={$host};port={$port};dbname={$dbName}", $user, $pass);
                    break;
                case "mysql":
                    $port = $port ? $port : '3306';
                    $conn = new PDO("mysql:host={$host};port={$port};dbname={$dbName}", $user, $pass);
                    break;
                case "sqlite":
                    $port = $port ? $port : '3306';
                    $conn = new PDO("sqlite:{$dbName}");
                    break;
                case "ibase":                    
                    $conn = new PDO("firebird:dbname={$dbName}", $user, $pass);
                    break;
                case "oci8":                    
                    $conn = new PDO("oci:dbname={$dbName}", $user, $pass);
                    break;
                case "mssql":                    
                    $conn = new PDO("mssql:host={$host},1433,;dbname={$dbName}", $user, $pass);
                    break;                
            }        

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
          
    }
}