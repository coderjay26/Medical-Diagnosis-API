<?php
namespace Diagnosis;
use Diagnosis\DiagnosisModel;
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
        foreach ($this->diagnoses as $diagnosis) {
            if ($diagnosis->matches($inputSymptoms)) {
                return $diagnosis->recommendation;
            }
        }
        return "Diagnosis not found";
    }
}