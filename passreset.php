<?php 
include("include/include.php");
 $txtusername=isset($_POST['txtusername']) ? $_POST['txtusername']:'';
      $query="SELECT `email`FROM `ti_user` WHERE `uname`='$txtusername'";
      $un=$conn->query($query);
      $un->setfetchmode(PDO::FETCH_ASSOC);
      while($u=$un->fetch())
      {
		  echo $u['email'];
		  exit;
$to = "mail@tekksol.com";
$subject = "Online Order";
$headers = "From: info@tekksol.com" . "\r\n" .
"CC: dd.vs@hotmail.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$msg_style='
        <style>
            .header{
                min-height: 70px;
                color:#fff;
                background-color: #26100f;
                text-align: center;
                font-size: 1.5em;
                line-height: 70px;
            }
            .header-border{
                height: 10px;
                background-color: #cccccc;  
            }
            .customer{
                border:1px solid #b2b2b2;
                padding:15px;
            }
            .col-4{
                width:24%;
                display: inline-block;
                padding: 2px;
                float: left;
                margin-top: 5px;
                margin-bottom: 5px;
                color:#808080;
                font-size:11pt;
            }
            .col-2{
                width:16%;
                display: inline-block;
                padding: 2px;
                float: left;
                margin-top: 5px;
                margin-bottom: 5px;  
            }
            .row{
                width:100%;
                display: block;
                clear: both;
            }
            .title-bar{
                height: 40px;
                background-color: #26100f;
                color:#fff;
                font-size: 1em;
                font-weight: 700;
                text-transform: uppercase;
                line-height: 40px;
                padding-left: 20px;
                text-align:left;
            }
            .container{
                width:75%; 
                height:auto; 
                font-family:Sans-serif; 
                padding-left:5%; 
                padding-right:5%;
                margin-left: auto;
                margin-right: auto;
            };
       </style>';
       
       
       
      
$errors = array();


	

	
	if(!empty($_POST['name']))
		$sender_name  = stripslashes(strip_tags(trim($_POST['name'])));
	
	if(!empty($_POST['Text-Area']))
		$message_area      = stripslashes(strip_tags(trim($_POST['Text-Area'])));
	
	if(!empty($_POST['email']))
		$sender_email = stripslashes(strip_tags(trim($_POST['email'])));
	
	if(!empty($_POST['Subject']))
		$subject      = stripslashes(strip_tags(trim($_POST['Subject'])));


	if(empty($errors)) {
		
		
	 $msg_contact.= 
                
	'<div class="container">
            <div class="header">Online Order</div>
            <div class="header-border"></div>
            <div class="customer">
                <h3>Customer Details</h3>'.
		'<div class="col-2">Name:</div> ' .'<div class="col-4">'. $sender_name.'</div>'.
		'<div class="col-2">Email:</div> ' .'<div class="col-4">'. $sender_email.'</div></br>'.
		
		'<div class="col-2">Subject:</div> ' .  '<div class="col-4">'.$subject.'</div></br>'.
		'<br><div class="col-2">Message</div> ' .'<div class="col-4">'. $message_area.'</div></br></div>' . '<div class="row"></div>';

			$content = $msg_style;
		$content .= $msg_contact;
		//$content .= $message;
		$message = wordwrap($message, 70);
		echo $content;
		mail($to,$subject,$content,$headers);
		
	//header('location:contact.html'); 
		}else {
		echo implode('<br>', $errors );
	}
}
?>
