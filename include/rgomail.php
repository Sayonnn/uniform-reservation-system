<?php
 session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions
if (isset($_GET["itemid"])) {
  $srcode = $_GET['sr'];
  $name = $_GET['itemname'];
  $price = $_GET['price'];
  $id = $_GET['itemid'];
  $subject = $_GET['subject'];
  $message = $_GET['message'];

  //get the values fo the inputs
  $subject = $srcode."@g.batstate-u.edu.ph - Item Reservation Canceled";
  $stmt = "We are sorry for the inconvenience. Your reservation number ".$id." ".$name." Price: ".$price." has been canceled by the Resource Generation Office. Reason:" .$message;
  $mail = new PHPMailer(true);
  $mail->isSMTP();// Set mailer to use SMTP
  $mail->CharSet = "utf-8";// set charset to utf8
  $mail->SMTPAuth = true;// Enable SMTP authentication
  $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted
  
  $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
  $mail->Port = 587;// TCP port to connect to
  $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
  );
  $mail->isHTML(true);// Set email format to HTML
  
  $mail->Username = $srcode.'@g.batstate-u.edu.ph';// SMTP username
  //$mail->Username = 'rgo.lipa@g.batstate-u.edu.ph';// SMTP username

  $mail->Password = 'iagy axhb aahc qfui';// SMTP password
  
  $mail->setFrom($srcode.'@g.batstate-u.edu.ph', 'LAUDZION CASCALLA');//Your application NAME and EMAIL
  //$mail->setFrom('rgo.lipa@g.batstate-u.edu.ph','Resouce Generration Office - Lipa' );
  $mail->Subject = $subject;//Message subject
  $mail->MsgHTML($stmt);// Message body
 // $mail->addAddress('21-37635@g.batstate-u.edu.ph', 'Neil Daniel M Pamintuan');// Target email
  $mail->addAddress($srcode.'@g.batstate-u.edu.ph', 'Laud Zion Cascalla');// Target email
  //$mail->addAddress('21-30452@g.batstate-u.edu.ph', 'Jerome Panganiban');// Target email
  //$mail->addAddress('21-35348@g.batstate-u.edu.ph', 'Max Daniel De Silva');// Target email
  //$mail->addAddress('21-33878@g.batstate-u.edu.ph', 'Dominique Frank Cabangisan');// Target email



  
  
  $mail->send();
    echo
    " 
    <script> 
     alert('Email Notification was sent successfully!');
     document.location.href = '../admin/edit.php';
    </script>
    ";

    if ($mail->send()) {
      echo 'Email sent successfully.';
  } else {
      echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
  }
}