<?php
 
require_once 'DB_Functions.php';
$db = new DB_Functions();
        // receiving the post params
        $name = $_GET['name'];
        $year = $_GET['year'];
        $branch = $_GET['branch'];
        $rollno = $_GET['rollno'];
        $email = $_GET['email'];
        $password = $_GET['password'];

 try {


    // json response array
    $response = array("error" => FALSE);
     $testfile = fopen("testfile.txt", 'w');
     fwrite($testfile, $name);
     fwrite($testfile, $year);
     fwrite($testfile, $branch);
     fwrite($testfile, $rollno);
     fwrite($testfile, $email);
     fwrite($testfile, $password);
    if (isset($_GET['name']) && isset($_GET['year']) && isset($_GET['branch']) && isset($_GET['rollno']) && isset($_GET['email']) && isset($_GET['password'])) {
     

     
        // check if user is already existed with the same email
        if ($db->isUserExisted($email)) {
            // user already existed
            $response["error"] = TRUE;
            $response["error_msg"] = "User already existed with " . $email;
            echo json_encode($response);
        }
        else{
            // create a new user
            $user = $db->storeUser($name, $year, $branch, $rollno, $email, $password);
            if ($user) {
                // user stored successfully
                $response["error"] = FALSE;
                $response["error_msg"] = "User saved";
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = TRUE;
                $response["error_msg"] = "Unknown error occurred in registration!";
                echo json_encode($response);
            }
        }
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Required parameters (name, year, branch, rollno, email or password) is missing!";
        echo json_encode($response);
    }
}catch(Exception $e){
    $response["error"] = TRUE;
    $response["error_msg"] = var_dump($e->getMessage());

    echo json_encode($response);
}
?>