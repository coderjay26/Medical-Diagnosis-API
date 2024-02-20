<?php
namespace Diagnosis;
use Exception;
use Diagnosis\ExpertSystemModel;

class ExpertSystemController
{
    private $model;
    private $symptoms;
    private $request;
    private $userInput;

    public function __construct(ExpertSystemModel $model, array $data)
    {
        $this->model = $model;
        $this->symptoms = $data['data']['symptoms'];
        $this->request = $data['request'];
        $this->userInput = $data['data']; // Assign the entire data array
    }

    public function __destruct()
    {
        try
        {
            if(method_exists($this->model, $this->request))
            {
                $symptomsString = implode(",", $this->symptoms);
                $diagnosisResult = $this->model->{$this->request}($symptomsString);
                // Output the diagnosis result
                echo $diagnosisResult;
            }else
            {
                throw new Exception("Error Processing Request", 1);
            }
        }catch(Exeption $ex)
        {
            http_response_code(400);
            echo json_encode(["Error" => "Bad request"]);
        }
    }
}
