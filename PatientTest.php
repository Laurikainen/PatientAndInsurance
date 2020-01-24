<?php

include ('Patient.php');

use PHPUnit\Framework\TestCase;

// Class to check all Patient and Insurance class methods
class PatientTest extends TestCase
{
    // Test cases for the Patient class
    public function testPatientReturnImplementingRecordId()
    {
        $patient = new Patient('00000000001');
        $this->assertSame(1, $patient->returnImplementingRecordId());
    }
    public function testPatientReturnImplementingRecordPatientsNumber()
    {
        $patient = new Patient('00000000001');
        $this->assertSame('00000000001', $patient->returnImplementingRecordsPatientNumber());
    }
    public function testPatientPatientName()
    {
        $patient = new Patient('00000000001');
        $this->assertSame('Mark Stone', $patient->getFirstAndLast());
    }
    public function testPatientGetInsuranceRecords()
    {
        $patient = new Patient('00000000001');
        $insurance1 = new Insurance(1);
        $insurance2 = new Insurance(2);
        $insurance = [$insurance1, $insurance2];
        $this->assertEquals($insurance, $patient->getInsuranceRecords());
    }

    // Test cases for Insurance class
    public function testInsuranceReturnImplementingRecordId()
    {
        $insurance = new Insurance(1);
        $this->assertSame(1, $insurance->returnImplementingRecordId());
    }
    public function testInsuranceReturnImplementingRecordsPatientNumber()
    {
        $insurance = new Insurance(1);
        $this->assertSame('00000000001', $insurance->returnImplementingRecordsPatientNumber());
    }
    public function testInsuranceGetIname()
    {
        $insurance = new Insurance(1);
        $this->assertSame('Seesam', $insurance->getIname());
    }
    public function testInsuranceInsuranceIsValid()
    {
        $insurance = new Insurance(1);
        $dateTime = new DateTime();
        $this->assertTrue($insurance->checkIfInsuranceIsValid($dateTime->format('m-d-y')));
    }

    // Test case for Patient and Insurance class
    // Create a connection to the database and compare the database data with the expected output.
    public function testDisplayPatientDataAndInsuranceValidity()
    {
        $patients = [];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test_task";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT pn FROM patient ORDER BY pn";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $patient = (new Patient($row['pn']));
                array_push($patients, $patient);
            }
        } else {
            echo "No data to display";
        }
        $conn->close();

        $pn1 = '00000000001, Mark Stone, Seesam, Yes' . PHP_EOL . '00000000001, Mark Stone, Kasko, No' . PHP_EOL;
        $pn2 = '00000000002, Mary Miller, Ergo, No' . PHP_EOL . '00000000002, Mary Miller, If, No' . PHP_EOL;
        $pn3 = '00000000003, James Parker, Salva, Yes' . PHP_EOL . '00000000003, James Parker, Iizi, No' . PHP_EOL;
        $pn4 = '00000000004, Alan Brown, PZU, No' . PHP_EOL . '00000000004, Alan Brown, Inges, Yes' . PHP_EOL . '00000000004, Alan Brown, BZA, Yes' . PHP_EOL;
        $pn5 = '00000000005, Willow Loper, Poliis, No' . PHP_EOL . '00000000005, Willow Loper, BTA, Yes' . PHP_EOL;
        $correctAnswer = $pn1 . $pn2 . $pn3 . $pn4 . $pn5;
        $this->expectOutputString($correctAnswer);
        foreach ($patients as $patient) {
            $patient->displayPatientDataAndInsuranceValidity(date('m-d-y'));
        }

    }
}
