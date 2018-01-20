<link href="style.css" rel="stylesheet" type="text/css" />
<?php
use phpmailer\PHPMailer;

$errorMsg = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fName = trim(htmlspecialchars($_POST['first_name']));
    $lName = trim(htmlspecialchars($_POST['last_name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $phone = trim(htmlspecialchars($_POST['phone']));
}

if(!empty($_POST) && isset($fName,$lName,$email,$phone) && empty($fName) || empty($lName) || empty($email) || empty($phone)){
    $errorMsg = 'Please fill the personal data field with Valid data';
}

$poll = array(
                array(  '1. What type of pet do you currently have?',
                        'Dog',
                        'Cat',
                        'Bird',
                        'Fish',
                        'Chinchila'),

                array(  '2. For how many years have you been a pet owner?',
                        '0-2 years',
                        '2-5 years',
                        '6-10 years',
                        '11 – 15 years',
                        '16 or more years'),

                array(  '3. At what age did you first become a pet owner?',
                        'As a young child',
                        'As a teenager',
                        'While in college',
                        'Once I was married or in a permanent relationship',
                        'Once I had children'),

                array(  '4. If you have children, would you say that your relationship with your pet has changed since you’ve had kids?',
                        'Yes, I devote less attention to my pet',
                        'Yes, I devote more attention to my pet',
                        'Yes, I think of my pet more like an animal and less like a child',
                        'No, my relationship with my pet has not changed',
                        'Not applicable/I do not have children'),

                array(  '5. Where does your pet sleep?',
                        'Outside',
                        'In a tank',
                        'In a family member’s bed',
                        'In his/her own bed',
                        'On the floor')
            );



require("phpmailer/PHPMailer.php");

    $mail = new PHPMailer(true);


if(!empty($_POST) && empty($errorMsg)){


    $result = '';
    $result .= "First name: ".$fName."\n";
    $result .= "Last name: ".$lName."\n";
    $result .= "Email: ".$email."\n";
    $result .= "Phone number: ".$phone."\n";
    $result .= "1. What type of pet do you currently have? \n".$_POST['question1']."\n";
    $result .= "2. For how many years have you been a pet owner? \n".$_POST['question2']."\n";
    $result .= "3. At what age did you first become a pet owner? \n".$_POST['question3']."\n";
    $result .= "4. If you have children, would you say that your relationship with your pet has changed since you’ve had kids? \n".$_POST['question4']."\n";
    $result .= "5. Where does your pet sleep? \n".$_POST['question5']."\n";

    var_dump($result);

    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $result);
    fclose($myfile);

    //Recipients
    $mail->setFrom($email, $fName);
    $mail->addAddress('dispina.savopulo1992@gmail.com', 'Desi');

    //Content
    $mail->isHTML(false);
    $mail->Subject = 'Poll Answers from '.$fName.' '.$lName;
    $mail->Body    = $result;

        if($mail->send()){
            header("location:thankyou.php");
            exit;
        }
    $error_message = 'Message could not be sent.';
    $error_message = 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    if(!empty($_POST) && !empty($errorMsg)){
        echo $errorMsg;
    }
}


include('template.html');
