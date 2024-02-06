<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    // Specify the base directory for your project
    $baseDir = __DIR__ . '/src/';

    // Replace the namespace separator with the directory separator
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";

    // Check if the file exists before requiring it
    if (file_exists($file)) {
        require $file;
    }
});

use User\UserController;
use User\UserModel;
use Patient\PatientModel;
use Patient\PatientController;


//Set the content-type to application/json
header("Content-type: application/json; charset=UTF8");

$jsonurl = explode("/", $_SERVER["REQUEST_URI"]);
$method = strtolower($_SERVER['REQUEST_METHOD']);
$requestModule = null;
$requestProcess = null;
$data = null;

//get the data from request
$requestData = json_decode(file_get_contents('php://input'), true);

if (!empty($requestData)) {
    $requestModule = strtolower($requestData['module'] ?? '');
    $requestProcess = strtolower($requestData['request'] ?? '');
}else{
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

//checking for valid method and request
if($method === 'post' && $requestModule !== null && $requestProcess != null)
{   
    switch($requestModule)
    {
        case 'user':
            $model = new UserModel();
            $controller = new UserController($model, $requestData);
            break;
        case 'patient':
            $model = new PatientModel();
            $controller = new PatientController($model, $requestData);
            break;
        default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }

}else
{
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

?>