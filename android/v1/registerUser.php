<?php
 
    require_once '../includes/DbOperations.php';
     
    // json response array
    $response = array("error" => false);
     
    if ($_SERVER['REQUEST_METHOD']=='POST'){

        if(
            isset($_POST['username']) and 
                isset($_POST['email']) and 
                    isset($_POST['password']))
        {

            $db = new DbOperation();

            $result = $db->createUser(  $_POST['username'],
                                        $_POST['password'],
                                        $_POST['email']);

            if($result == 1){
                $response['error'] = false;
                $response['message'] = "User registered successfully";
                
            }elseif ($result == 2) {
                $response['error'] = true;
                $response['message'] = "Some error occured. Please try again.";
            }elseif ($result == 0) {
                $response['error'] = true;
                $response['message'] = "User Already exists.";
            }
            
            
        }else{
            $response['error'] = true;
            $response['message'] = "Required fields are missing.";
        }

     }else {
        $response["error"] = true;
        $response["message"] = "Required parameters (name, email or password) is missing!";
    }
    echo json_encode($response);
?>