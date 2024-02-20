<?php
namespace Diagnosis;

class DiagnosisModel
{
    public $condition;
    public $recommendation;

    public function __construct($condition, $recommendation) {
        $this->condition = $condition;
        $this->recommendation = $recommendation;
    }

    public function matches($inputSymptoms) {
        $inputSymptomsArray = explode(",", $inputSymptoms);
        sort($inputSymptomsArray);

        $conditionCopy = $this->condition; 
        sort($conditionCopy);

        return $inputSymptomsArray == $conditionCopy;
    }
}