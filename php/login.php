<?php
$servname = "localhost";
$usrname = "root";
$pasword = "";
$dbname = "mysql";
$con=new mysqli($servname,$usrname,$pasword,$dbname);
if ($con->connect_error) {
    die("Connection Failed : " . $con->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data["username"];
        $password = $data["password"];
       
        $stmt = $con->prepare("SELECT name, password ,email FROM users1 WHERE name = ?");
        
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($dbUsername, $dbPassword,$dbEmail);
                $stmt->fetch();
                if ($password===$dbPassword) {
                    $response = array("status" => "success", "message" => "Login Successful!!","username"=>$username);
                    // $response = array("status" => "success", "message" => "Login Successful!!","username"=>$username,"email"=>$email,"dob"=>$dob,"age"=>$age,"contact"=>$contact);
                    echo json_encode($response);
                } else {
                    $response = array("status" => "error", "message" => "Incorrect Password  ");
                    echo json_encode($response);
                }
            }
             else 
            {
                $response = array("status" => "error", "message" => "User Not Found :" . $stmt->error);
                echo json_encode($response);
            }

            $stmt->close();
        }
         else
          {
            $response = array("status" => "error", "message" => "User Not Found :");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "Invalid Request Method");
        echo json_encode($response);
    }

    $con->close();
}
// }
?>
