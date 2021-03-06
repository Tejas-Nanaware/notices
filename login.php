<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
try{
    // json response array
    $response = array("error" => FALSE);
     
    if (isset($_GET['email']) && isset($_GET['password'])) {
     
        // receiving the GET params
        $email = $_GET['email'];
        $password = $_GET['password'];
     
        // get the user by email and password
        $user = $db->getUserByEmailAndPassword($email, $password);
     
        if ($user != false) {
            // use is found
            $response["error"] = FALSE;
                $response["uid"] = $user["uniqueid"];
                $response["user"]["name"] = $user["name"];
                $response["user"]["year"] = $user["year"];
                $response["user"]["branch"] = $user["branch"];
                $response["user"]["rollno"] = $user["rollno"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["created_at"] = $user["createdat"];
                $response["user"]["updated_at"] = $user["updatedat"];
            echo json_encode($response);
        } else {
            // user is not found with the credentials
            $response["error"] = TRUE;
            $response["error_msg"] = "Login credentials are wrong. Please try again!";
            echo json_encode($response);
        }
    } else {
        // required GET params is missing
        $response["error"] = TRUE;
        $response["error_msg"] = "Required parameters email or password is missing!";
        echo json_encode($response);
    }
}catch(Exception $e){
    $response["error"] = TRUE;
    $response["error_msg"] = var_dump($e->getMessage());

    echo json_encode($response);
}
?>