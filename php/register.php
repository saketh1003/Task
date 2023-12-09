<?php
$servname = "localhost";
$usrname = "root";
$pasword = "";
$dbname = "mysql";
require_once 'C:\xampp\htdocs\guvi\vendor\autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017/");
$database = $mongoClient->selectDatabase('myDB');
$collection = $database->selectCollection('customprof');
$con = new mysqli($servname, $usrname, $pasword, $dbname);

if ($con->connect_error) {
    die("Connection Failed : " . $con->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data["username"];
        $password = $data["password"];
        $email = $data["email"];

        $stmt = $con->prepare("INSERT INTO users1(name, email, password) VALUES (?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {

                $dataToInsert = [
                    "username" => $name,
                    "email" => $email,
                ];
                $result = $collection->insertOne($dataToInsert);
                $response = array("status" => "success", "message" => "Registration Successful!!");
                echo json_encode($response);
            } else {
                $response = array("status" => "error", "message" => "Error: " . $stmt->error);
                echo json_encode($response);
            }

            $stmt->close();
        } else {
            $response = array("status" => "error", "message" => "Error: " . $con->error);
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "Invalid request method");
        echo json_encode($response);
    }
    $con->close();
}
?>
