<?php
//
//include('PHPMailer/PHPMailerAutoload.php');
//SendRequestEmailToShift();
//function SendRequestEmailToShift()
//{
//
//    $subject = "ทักทาย";
//    $toAddress = "devilsjackiez5008@gmail.com";
//    /*$toAddress = "matthias.schenk@clbs.co.th,sandra.palfy@dbs-gmbh.de";*/
//    $updateContent = 'จะทำไม มีปัญหาไรปะ';
//    $agentName = "Ann Jcj";
//    $mail = new PHPMailer;
//    $mail->isSMTP();
//    $mail->Host = 'localhost';
//    $mail->SMTPAuth = false;
//    $mail->CharSet = "utf-8";
//    $mail->From = "ladyaplusann@gmail.com ";
//    $mail->FromName = $agentName;
//    $addrList = explode(',', $toAddress);
//    foreach ($addrList as $address) {
//        $mail->addAddress($address);
//    }
//    $mail->WordWrap = 50;
//    $mail->isHTML(true);
//    $mail->Subject = $subject;
//    $mail->Body = $updateContent;
//    $mail->AltBody = $updateContent;
//
//    notifySendingResult($mail);
//}
//
//function notifySendingResult($mail)
//{
//    if (!$mail->send()) {
//        echo "<h2>Mailer Error:" . $mail->ErrorInfo . "</h2>";
//    } else {
//        echo '<h2>Email has been sent.</h2>';
//    }
//
//}
//
//?>