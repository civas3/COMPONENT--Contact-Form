<?php
    $userAttachment =  $_FILES['file']['name'];
    $userAttachmentName = $_FILES['file']['tmp_name']; 
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userCountry = $_POST['country'];
    $userSubject = $_POST['subject'];
    $userMessage = $_POST['message'];
    
    $message ="\r\n  Name: ". $userName . "\r\n  Email: " . $userEmail . "\r\n  Country: " . $userCountry . "\r\n  Subject: " . $userSubject . "\r\n\r\n  Message: \r\n\r\n  " . $userMessage; 
    
    


    $subject = "[ ".$userSubject." ]"." from ". "[ ".$userCountry." ]";
    $fromname = "SUKHI222 Contact Form";
    $fromemail = 'autoreply@sukhi222.org';  //if u dont have an email create one on your cpanel
    $mailto = 'paul@sukhi222.org';  //the email which u want to recv this email
    $content = file_get_contents($userAttachmentName);
    $content = chunk_split(base64_encode($content));
    // a random hash will be necessary to send mixed content
    $separator = md5(time());
    // carriage return type (RFC)
    $eol = "\r\n";
    // main header (multipart mandatory)
    $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;
    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;
    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $userAttachment . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";
    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK"; // do what you want after sending the email
        
        
    } else {
        echo "mail send ... ERROR!";
        print_r( error_get_last() );
    }