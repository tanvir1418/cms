<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

require "includes/init.php";

$email = "";
$subject = "";
$message = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $errors = [];

    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $errors[] = 'Please enter a valid email address';
    }

    if($subject == ''){
        $errors[] = 'Please enter a subject';
    }

    if($message == ''){
        $errors[] = 'Please enter a message';
    }

    if(empty($errors)){
        
        // tanvir@SendGrid123

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.sendgrid.net';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'apikey';                     //SMTP username
            $mail->Password   = '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';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 25587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('tanvirahmed1418@gmail.com', 'Tanvir Ahmed');
            $mail->addAddress($email, 'Jypsy');     //Add a recipient
            // $mail->addReplyTo($email, 'Information');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}

?>


<?php require "includes/header.php" ?>

<h2>Contact</h2>

<?php if(!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" id="formContact">
    <div class="form-group">
        <label for="email">Your email</label>
        <input  class="form-control"type="email" name="email" id="email" placeholder="Your email" value="<?= htmlspecialchars($email) ?>">
    </div>
    <div class="form-group">
        <label for="subject">Subject</label>
        <input  class="form-control"type="text" name="subject" id="subject" placeholder="Subject" value="<?= htmlspecialchars($subject) ?>">
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" name="message" id="message" placeholder="Message"><?= htmlspecialchars($message) ?></textarea>
    </div>
    <button class="btn">Send</button>
</form>

<?php require "includes/footer.php" ?>