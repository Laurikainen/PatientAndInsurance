<?php

// A class to represent Insurance table and the related patient numbers.
class Insurance implements PatientRecord
{
    private $insurance_id;
    private $patient_id;
    private $iname;
    private $from_date;
    private $to_date;
    private $pn;

    /**
     * Insurance constructor.
     * @param $insurance_id
     * Create a connection to the database and fill out all class properties.
     */
    public function __construct($insurance_id)
    {
        $this->insurance_id = $insurance_id;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test_task";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT patient_id, iname, from_date, to_date, pn FROM insurance, patient WHERE insurance._id = '$insurance_id' && patient._id = patient_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $this->patient_id = intval($row['patient_id']);
                $this->iname = $row['iname'];
                $this->from_date = $row['from_date'];
                $this->to_date = $row['to_date'];
                $this->pn = $row['pn'];
            }
        } else {
            echo "No data to display";
        }
        $conn->close();
    }

    /**
     * @return int
     */
    public function returnImplementingRecordId()
    {
        return $this->insurance_id;
    }

    /**
     * @return string
     */
    public function returnImplementingRecordsPatientNumber()
    {
        return $this->pn;
    }

    /**
     * @return string
     */
    public function getIname()
    {
        return $this->iname;
    }

    /**
     * @param $date
     * @return boolean
     * Display whether the insurance is valid or not when there is a date given.
     */
    public function checkIfInsuranceIsValid($date) {
        $dateTime = datetime::createFromFormat('m-d-y', $date);
        $this->from_date = strtotime($this->from_date);
        if ($this->to_date != null) {
            $this->to_date = strtotime($this->to_date);
            $dateTime = $dateTime->getTimestamp() . PHP_EOL;
            if ($dateTime >= $this->from_date and $dateTime <= $this->to_date) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            $dateTime = $dateTime->getTimestamp() . PHP_EOL;
            if ($dateTime >= $this->from_date) {
                return true;
            }
            else {
                return false;
            }
        }
    }
}
?>