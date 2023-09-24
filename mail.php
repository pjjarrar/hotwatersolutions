<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $to = "sam@hotwatersolutions.com";

    // $headers = "From: ".$name. "\r\n" .
    // "CC: contact@BASICLABCONTROLS.COM";

    $headers = "From: ".$name. "\r\n";

    $txt = "You have recieved an e-mail from ".$name ."\r\nEmail: ".$email ."\r\n
        Message: ". $message;

    if($email!=NULL) {
        mail($to, $subject, $txt, $headers);
    }

    header('Location:thankyou.html');
?>