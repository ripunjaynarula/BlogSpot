<?php
//get data from form  
if(isset($_POST['contact-submit'])){
    $email= $_POST['contactEmail'];
    $message= $_POST['contactMessage'];
    $to = "ripunjaynarula30@gmail.com";
    $subject = "Mail From BlogSquare";
    $txt ="\r\n  Email = " . $email . "\r\n Message =" . $message;
    $headers = "From: noreply@blogsquare.com" . "\r\n" ."CC: somebodyelse@example.com";
    if($email!=NULL){
        mail($to,$subject,$txt,$headers);
    }
}

?>