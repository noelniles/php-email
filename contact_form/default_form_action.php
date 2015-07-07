<?php

if (isset($_POST)) {
    /* Set default status codes. */
    $response_array = array();
    $response_array['status'] = 'nothing';
    $response_array['message'] = '<div class="alert alert-error">nothing</div>';
    /* This is where everything starts. */
    /* Initialize `to`, `from`, and `subj`. */
    $to = "";
    $from = "";
    $subj = "";
    respond();
}

/* Uses the functions: validate_fields, build_headers, and send to craft 
 * and email based on the data from the POST.
 */
function respond()
{
    if (validate_fields()) {
        build_header();
        send();
    }
}
/* Returns true given a valid email. */
function checkEmail($email)
{
    if (preg_match("[\w+@\w+\.\w+$]", $email)) {
        return false;
    }
    list($Username, $Domain) = split("@",$email);

    if (@getmxrr($Domain, $MXHost)) {
        return true;
    } else {
        if (@fsockopen($Domain, 25, $errno, $errstr, 30)) {
            return true;
        } else {
            return false;
        }
    }
}
function build_header()
{
    $from = "noreply@example.com";              /* The `from` line */
    $to = "username@example.com";                /* Where the email is sent */
    $subj = "Default Email Subject";            /* The `subject` line */
    /* Start building the header. */
    $header = "MIME-Version: 1.0" . PHP_EOL;
    $header .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
    $header .= "From:". $from . PHP_EOL;         /* The `from` line from the form */
    $header .= "Reply-To:". $from . PHP_EOL;     /* The `reply-to` from the form */
    $header .= "To:". $to . PHP_EOL;
    $header .= "X-Mailer: PHP/".phpversion();
}
function validate_fields()
{
    /* Make sure the name field is filled in from the form. */
    if (empty($_POST['name'])) {
        $response_array['status'] = 'name error';
        $response_array['message'] = '<div class="alert alert-error">Name is blank</div>';
    }
    /* Make sure the return email is valid. */
    else if (!checkEmail($_POST['email'])) {
        $response_array['status'] = 'check email error';
        $response_array['message'] = '<div class="alert alert-error">Email is blank or invalid</div>';
        return false;
    }
    /* Make sure the message text field is filled in. */
    else if (empty($_POST['message'])) {
        $response_array['status'] = 'message error';
        $response_array['message'] = '<div class="alert alert-error">Message is blank</div>';
        return false;
    }
    else {
        return true;
    }
}
function send()
{
    $body = $_POST['name'] . " sent you a message<br>";
    $body .= "You can reply to ". $_POST['email']."<br>";
    $body .= "Details:<br>" . $_POST['message'];
    if (mail($to, $subj, $body, $header)) {
        $response_array['status'] = 'success';
        $response_array['message'] = '<div class="alert alert-success">Email sent!</div>';
    } else {
        $response_array['status'] = 'epic fail';
        $response_array['message'] = '<div class="alert alert-error">Undetermined Error!</div>';
    }
}
/* Return the response back to the page. */
echo json_encode($response_array);
