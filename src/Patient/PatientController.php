<?php
namespace Patient;
use Exception;

class PatientController
{
    private $patientModel;
    private $data;
    private $patientData;
    private $request;

    public function __construct(PatientModel $patientModel, $data)
    {
        $this->patientModel = $patientModel;
        $this->data = $data;
        $this->patientData = $data['data'];
        $this->request = $data['request'];
    }

    public function __destruct()
    {
        try
        {
            if(method_exists($this->patientModel, $this->request))
            {
                $this->patientModel->{$this->request}($this->patientData);
            }else
            {
                throw new Exception("Error Processing Request", 1);
            }
        }catch(Exception $ex)
        {
            http_response_code(400);
            echo json_encode(array("Error" => "Bad request"));
        }
    }
}

