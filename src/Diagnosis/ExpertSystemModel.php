<?php
namespace Diagnosis;
use Diagnosis\DiagnosisModel;
use Database\Database;
use Configuration\Configuration;
class ExpertSystemModel
{
    private $diagnoses = [];

    public function __construct() {
        $this->loadDiagnoses('backup.json');
    }

    private function loadDiagnoses($jsonFilePath) {
        // Load diagnoses from JSON file
        $diagnosesData = json_decode(file_get_contents($jsonFilePath), true);
        
        // Create instances of Diagnosis from JSON data and add them to the model
        foreach ($diagnosesData as $diagnosisData) {
            $diagnosis = new DiagnosisModel($diagnosisData['condition'], $diagnosisData['recommendation']);
            $this->addDiagnosis($diagnosis);
        }
    }

    public function addDiagnosis(DiagnosisModel $diagnosis) {
        $this->diagnoses[] = $diagnosis;
    }

    public function diagnose($inputSymptoms) {
        $inputSymptoms = json_encode($inputSymptoms['symptoms']);
        //echo $inputSymptoms;
        foreach ($this->diagnoses as $diagnosis) {
            if ($diagnosis->matches($inputSymptoms)) {
                echo $diagnosis->recommendation;
            }
        }
        echo "Diagnosis not found";
    }

    public function symptoms($data)
    {
        $categoryParam = array($data['category']);
        $result = Database::executeQuery(Configuration::$dbase, "Call getSymptoms(?)", $categoryParam);
        
        $result = json_decode($result);
        
        
        if(!$result == [] || !$result == null)
        {   
            $symptomsArray = explode(", ", $result[0]->symptoms);
            $result[0]->symptoms = $symptomsArray;
            http_response_code(200);
            echo json_encode(array("success" => true, "data" => $result));
        }else
        {
            http_response_code(401);
            echo json_encode(["error" => "Category not Found"]);
        }
    }
}