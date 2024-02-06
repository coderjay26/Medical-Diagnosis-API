<?php
namespace User;
use Configuration\Configuration;
use Database\Database;

class UserModel
{
    public function createuser(array $userData)
    {
        $dataParam = array($userData['username'], $userData['name'], $userData['password'], $userData['phone']);

        $result = Database::executeQuery(Configuration::$dbase, "Call createUsers(?, ?, ?, ?)", $dataParam);

        $result = json_decode($result);

        if($result[0]->message == "exist")
        {
            http_response_code(401);
            echo json_encode(array("error" => "User already exist!"));
        }
        else
        {
            echo json_encode(array("success" => true));
        }
    }

    public static function login(array $userData)
    {
        $dataParam = array ($userData['username'], $userData['password']);

        $result = Database::executeQuery(Configuration::$dbase, "Call LoginUser(?, ?)", $dataParam);
        $result = json_decode($result);
        if($result[0]->Id === null)
        {   
            http_response_code(401);
            echo json_encode(["error" => "Email or Password is incorrect!"]);
        }else
        {
            http_response_code(200);
            echo json_encode(array("success" => true, "data" => $result));
        }
    }

    public static function getusers()
    {
        $result = Database::executeQuery(Configuration::$dbase, "Call GetUsers");
        $result = json_decode($result);
        echo json_encode(array("success" => true, "data" => $result));
    }
}