<?php 

	include("../include/include.php"); 
	    $name=isset($_POST['name']) ? $_POST['name']:'';
	    $name=test($name);
	    $mobile=isset($_POST['mobile']) ? $_POST['mobile']:'';
	    $mobile=test($mobile);
	    $email=isset($_POST['email']) ? $_POST['email']:'';
	     $email=test($email);
	    $tin=isset($_POST['tin']) ? $_POST['tin']:'';
	    $pan=isset($_POST['pan']) ? $_POST['pan']:'';
	    	     $tin=test($tin);
	     $pan=test($pan);
	     $cin=test($cin);
	    $city=isset($_POST['cities']) ? $_POST['cities']:'';
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	      $address=test($address);
	    $balance=isset($_POST['balance']) ? $_POST['balance']:'';
	    $isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	    
	
	
	
	$query="INSERT INTO `ti_customer`( `name`, `mobile`, `email`, `TIN`, `PAN`, `Address_l1`, `city_id`,`cus_balance`,`IsActive`) VALUES
	 ('$name','$mobile','$email','$tin','$pan','$address','$city','$balance','$isactive')";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);;
}

?>

