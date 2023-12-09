<?php
require_once 'C:\xampp\htdocs\guvi\vendor\autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017/");
$database = $mongoClient->selectDatabase('myDB'); 
$collection = $database->selectCollection('customprof');

// var_dump($result);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
//    / $data =$_GET['username'];
    $username = $_GET["username"];
    // echo $username;
    $mongoQuery = array("username" => $username);
    $result = $collection->findOne($mongoQuery);
    // echo json_encode(array("response"=>$result));
    echo json_encode($result);
    // echo $result;
    // var_dump($insertOneResult->getInsertedId());
    // $response = array("status" => "success", "message" => "Profile Saved Successful!!","username"=>$username,"contact"=>$contact,"dob"=>$dob,"email"=>$email,"age"=>$age);
    // echo json_encode($result);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $dob = $data["dob"];
    $contactnumber = $data["contactnumber"];
    $age = $data["age"];
    $username=$data["username"];
    $email=$data["email"];
    $existingDoc = $collection->findOne(['username' => $username]);
    if ($existingDoc) {
        $updateResult = $collection->updateOne(
            ['username' => $username],
            [
                '$set' => [
                    'dob' => $dob,
                    'age' => $age,
                    'contact' => $contactnumber
                ]
            ]
        );

        if ($updateResult->getModifiedCount() > 0) {
            $response = array("status" => "success", "message" => "Profile updated successfully!");
        } else {
            $response = array("status" => "error", "message" => "Failed to update profile!");
        }
    } else {
        $insertResult = $collection->insertOne([
            'username' => $username,
            'dob' => $dob,
            'age' => $age,
            'contact' => $contactnumber
        ]);
    }

    $response = array("status" => "success", "message" => "Profile Saved Successful!!","age"=>$age,"contact"=>$contactnumber,"dob"=>$dob,"username"=>$username,"email"=>$email);
    echo json_encode($response);
}
?>
