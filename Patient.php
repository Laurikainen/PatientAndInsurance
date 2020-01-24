<?php

// Include the necessary files that the class uses
include ('PatientRecord.php');
include ('Insurance.php');

// A class to represent Patient table and its related insurance records
class Patient implements PatientRecord
{
    private $patient_id;
    private $pn;
    private $first;
    private $last;
    private $dob;
    private $insuranceRecords;

    /**
     * Patient constructor.
     * @param $pn
     * Create a connection to the database and fill out all class properties.
     */
    public function __construct($pn)
    {
        $this->pn = $pn;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test_task";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT patient._id AS patient_table, first, last, dob, insurance._id AS insurance_id FROM patient, insurance WHERE pn = '$pn' && patient_id = patient._id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $int = 0;
            while($row = $result->fetch_assoc()) {
                if ($int == 0) {
                    $this->patient_id = intval($row['patient_table']);
                    $this->first = $row['first'];
                    $this->last = $row['last'];
                    $this->dob = $row['dob'];
                    $this->insuranceRecords = [];
                    array_push($this->insuranceRecords, new Insurance(intval($row['insurance_id'])));
                    $int ++;
                }
                else {
                    array_push($this->insuranceRecords, new Insurance(intval($row['insurance_id'])));
                }
            }
        } else {
            echo "No data to display";
        }
        $conn->close();
    }

    /**
     * Get the records id number.
     * @return int
     */
    public function returnImplementingRecordId()
    {
        return $this->patient_id;
    }

    /**
     * Get the patient number.
     * @return string
     */
    public function returnImplementingRecordsPatientNumber()
    {
        return $this->pn;
    }

    /**
     * Get the patients first and last name.
     * @return string
     */
    public function getFirstAndLast()
    {
        return $this->first . ' ' . $this->last;
    }

    /**
     * Get all the insurance records connected to the patient.
     * @return array
     */
    public function getInsuranceRecords()
    {
        return $this->insuranceRecords;
    }

    /**
     * Print a patients data.
     * @param $date
     * Use patient and insurance class methods to display if patients insurance is valid or not.
     */
    public function displayPatientDataAndInsuranceValidity($date) {
        foreach ($this->insuranceRecords as $insurance) {
            $insuranceName = $insurance->getIname();
            $isValid = $insurance->checkIfInsuranceIsValid($date);
            if ($isValid) {
                echo $this->pn . ', ' . $this->getFirstAndLast() . ', ' . $insuranceName . ', Yes' . PHP_EOL;
            }
            else {
                echo $this->pn . ', ' . $this->getFirstAndLast() . ', ' . $insuranceName . ', No' . PHP_EOL;
            }
        }
    }
}

?>