<?php
    $_SESSION['inv_mail_status']='';

    #//Insert Query - prepare sql and bind parameters

    
    #// VALUE ASSIGN / SET DEFAULT VALUES     

        $tomail             =   $_POST['customermail'];
        $file_tmp           =   $_FILES['invoice']['tmp_name'];
        $file_name          =   $_FILES['invoice']['name'];
        $inv_from_mail      =   "cpos@techcloudinnovations.com";
        $inv_send_name      =   "MS-TRADERS";
        $inv_mail_passowrd  =   "h~?;LrBMIucE";
        $inv_mail_subject   =   "SALES INVOICE";
        $inv_mail_server    =   "md-in-84.webhostbox.net";

    
    #//PREPARE EMAIL
        $message = '<table style="padding: 5px 5px; background: #eaeaea; font-family: Arial,sans-serif; min-width: 70%;">
                        <thead>
                            <tr><th colspan="2" style="background: #2e2e2e; padding: 15px; color: #d7d7d7;">MS-TRADERS</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 30px 25px;border-bottom: 1px solid #d6d6d6;background: #fafafa;">Dear Sir/Madam; <br> Your Invoice has been generated, it is attached along this mail. <br> Kindly check attachment  </td>                              
                            </tr>
                        </tbody>
                    </table> Powered by <a href="http://www.techcloudinnovations.com">TCi</a>';
    

        require 'vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        //Enable SMTP debugging. 
        $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only                             
        //Set PHPMailer to use SMTP.
        $mail->IsSMTP(); // enable SMTP          
        //Set SMTP host name                          
        $mail->Host = $inv_mail_server;
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;                          
        //Provide username and password     
        $mail->Username = $inv_from_mail;                 
        $mail->Password = $inv_mail_passowrd;                           
        //If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "tls";                           
        //Set TCP port to connect to 
        $mail->Port = 587;                                   
        //Attach Invoice
        $mail->AddAttachment($file_tmp, $file_name);
        $mail->From = $inv_from_mail;
        $mail->FromName = $inv_send_name;
        $mail->addAddress($tomail);
        $mail->isHTML(true);
        $mail->Subject = $inv_mail_subject;
        $mail->Body = $message;
        $mail->AltBody = "No HTML Support";
        
        if(!$mail->send()) 
        {    
            $_SESSION['inv_mail_status'] = 'ERROR, TRY AGAIN!!!';
            header("Location: saleinvoice.php");
        } 
        else 
        {    
            $_SESSION['inv_mail_status'] = 'MAIL SEND';
            header("Location: saleinvoice.php");
            
        }

?>