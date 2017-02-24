<?php

require_once '../includes/DbOperations.php';

// json response array
$response = array();

if ($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_POST['username']) && isset($_POST['password'])) {

        # call dboperation function from DbOperations.php
        $db = new DbOperation();

        if ($db->userLogin($_POST['username'], $_POST['password'])) {
            $user = $db->getUserByUsername($_POST['username']);

            $response['error'] = false;
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];
            $response['fullname'] = $user['fullname'];
            $response['grade'] = $user['grade'];
            $response['sec'] = $user['sec'];
            $response['branch'] = $user['branch'];
            echo json_encode($response);
        }
        else{

        // required post params is missing
        $response["error"] = true;
        $response["error_msg"] = "Required username or password is wrong!";
        echo json_encode($response);
        }
    }
    
} else {

    // required post params is missing
    $response["error"] = true;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>