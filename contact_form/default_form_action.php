<?php
//function to validate the email address
//returns false if email is invalid
function checkEmail($email){

    if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)){
        return FALSE;
    }

    list($Username, $Domain) = split("@",$email);

    if(@getmxrr($Domain, $MXHost)){
        return TRUE;

    } else {
        if(@fsockopen($Domain, 25, $errno, $errstr, 30)){
            return TRUE;
        } else {

            return FALSE;
        }
    }
}
//Email Address. Change this to yours.
$from="Web Form";
$to="username@example.com<br>";
$subj="Default Email Subject<br>";
$header="From:". $from . "<br>";
$header.="Reply-To:". $from . "<br>";
$header.="To:". $to . "<br>";
$header.="X-Mailer: PHP/".phpversion();

//response array with status code and message
$response_array = array();

//validate the post form
//check the name field
if(empty($_POST['name'])){

    //set the response
    $response_array['status'] = 'error';
    $response_array['message'] = '<div class="alert alert-error">Name is blank</div>';

//check the email field
} elseif(!checkEmail($_POST['email'])) {

    //set the response
    $response_array['status'] = 'error';
    $response_array['message'] = '<div class="alert alert-error">Email is blank or invalid</div>';

//check the message field
} elseif(empty($_POST['message'])) {

    //set the response
    $response_array['status'] = 'error';
    $response_array['message'] = '<div class="alert alert-error">Message is blank</div>';

//form validated. send email
} else {

    //send the email
    $body = $_POST['name'] . " sent you a message<br>";
    $body .= "You can reply to ". $_POST['email']."<br>";
    $body .= "Details:<br>" . $_POST['message'];
    mail( $to, $subj, $body, $header );

    //set the response
    $response_array['status'] = 'success';
    $response_array['message'] = '<div class="alert alert-success">Email sent!</div>';
}

//send the response back
echo json_encode($response_array);
