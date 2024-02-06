<?php
namespace User;
use Exception;

class UserController 
{
    private $userModel;
    private $data;
    private $userData;
    private $request;

    function __construct(UserModel $user, array $data)
    {
        $this->userModel = $user;
        $this->data = $data;
        $this->userData = $data['data'];
        $this->request = $data['request'];
    }
    function __destruct()
    {
        try 
        {
            if(method_exists($this->userModel, $this->request))
            {
                $this->userModel->{$this->request}($this->userData);
            }else
            {
                throw new Exception("Error Processing Request", 1);
            }

        } catch (Exception $ex) {
            http_response_code(400);
            echo json_encode(["Error" => "Bad request"]);
        }        
    }
}