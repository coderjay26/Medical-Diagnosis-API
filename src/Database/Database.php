<?php
namespace Database;
use PDO;
use PDOException;

class Database
{
    static function openConnection($dbase)
    {
        $option = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
						PDO::ATTR_EMULATE_PREPARES   => false];
        $dsn = "mysql:host={$dbase['host']};dbname={$dbase['dbname']};charset=utf8";

        $conn = new PDO($dsn, $dbase['username'], $dbase['password'], $option);

        return $conn;
    }
    static function executeQuery($dbase, $query, $param = null)
    {
        $result = "";
        try
        {
          $conn = Self::openConnection($dbase);
            $stmt = $conn->prepare($query);
    
            if($param == null)
            {
                $stmt->execute();
            }else
            {
                $stmt->execute($param);
            }

            $result = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
             
        }catch(PDOException $ex)
        {
            return "Database error: ".$ex->getMessage();
        }
        return $result;
    }
}