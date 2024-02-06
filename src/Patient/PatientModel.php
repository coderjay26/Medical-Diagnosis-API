<?php
namespace Patient;
use Database\Database;
use Configuration\Configuration;

class PatientModel
{
    public static function getpatient(array $patientData)
    {
        $dataParam = array($patientData['userid'], $patientData['patientname']);
        $result = Database::executeQuery(Configuration::$dbase, "Call GetPatient(?, ?)", $dataParam);

        $result = json_decode($result);

        if($result[0]->Id === null)
        {
            http_response_code(401);
            echo json_encode(array("Error" => "No patient found!"));
        }else
        {
            http_response_code(200);
            echo json_encode(array("success" => true, "data" => $result));
        }
    }

    public static function getpatients(array $patientData)
    {
        $dataParam = array($patientData['userid']);

        $result = Database::executeQuery(Configuration::$dbase, "Call GetPatients(?)", $dataParam);
        $result = json_decode($result);
        echo json_encode(array("success" => true, "data" => $result));
    }

    public static function createpatient(array $patientData)
    {

    }
}