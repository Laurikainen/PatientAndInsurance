<?php

// Creating the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_task";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Exercise 2 part a
// Select the needed columns from the database and display them row by row
$sql_a = "SELECT pn, last, first, iname, DATE_FORMAT(from_date, '%m-%d-%y') AS from_date, DATE_FORMAT(to_date, '%m-%d-%y') AS to_date FROM patient, insurance WHERE patient._id = patient_id ORDER BY insurance.from_date, last";
$result_a = $conn->query($sql_a);
if ($result_a->num_rows > 0) {
    // output data of each row
    while($row = $result_a->fetch_assoc()) {
        echo $row['pn'] . ', ' . $row['last'] . ', ' . $row['first'] . ', ' . $row['iname'] . ', ' . $row['from_date'] . ', ' . $row['to_date'] . PHP_EOL;
    }
} else {
    echo "No results to display";
}

echo PHP_EOL;

// Exercise 2 part b
// Select all patient names from the database and calculate how many times each letter has occurred and when all the
// letters have been counted sort the letters and display the gathered data and each letters occurrence percentage
// row by row
$sql_b = "SELECT last, first FROM patient";
$result_b = $conn->query($sql_b);
$allTheLettersWithTheirCount = [];
$totalCountOfAllLetters = 0;
if ($result_b->num_rows > 0) {
    // Output data of each row
    while($row = $result_b->fetch_assoc()) {
		foreach (str_split($row['last']) as $char) {
		    if ($char != '-') {
                $char = strtoupper($char);
                if (array_key_exists($char, $allTheLettersWithTheirCount)) {
                    $allTheLettersWithTheirCount[$char] += 1;
                } else {
                    $allTheLettersWithTheirCount[$char] = 1;
                }
                $totalCountOfAllLetters += 1;
            }
		}
        foreach (str_split($row['first']) as $char) {
            if ($char != '-') {
                $char = strtoupper($char);
                if (array_key_exists($char, $allTheLettersWithTheirCount)) {
                    $allTheLettersWithTheirCount[$char] += 1;
                } else {
                    $allTheLettersWithTheirCount[$char] = 1;
                }
                $totalCountOfAllLetters += 1;
            }
		}
    }
    ksort($allTheLettersWithTheirCount, SORT_STRING );
    foreach ($allTheLettersWithTheirCount as $key => $value) {
        echo $key . "\t" . $value . "\t" . round(($value * 100) / $totalCountOfAllLetters, 2) . ' %' . PHP_EOL;
    }
} else {
    echo "No results to display";
}

// Closing the connection to the database
$conn->close();

?>