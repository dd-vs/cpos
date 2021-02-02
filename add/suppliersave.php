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
	    $cin=isset($_POST['cin']) ? $_POST['cin']:'';
	    	     $tin=test($tin);
	     $pan=test($pan);
	     $cin=test($cin);
	    $city=isset($_POST['cities']) ? $_POST['cities']:'';
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	       $address=test($address);
	    $notes=isset($_POST['notes']) ? $_POST['notes']:'';
	       $notes=test($notes);
	    $balance=isset($_POST['balance']) ? $_POST['balance']:'';
	    $isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	    
	
	
	
	$query="INSERT INTO `ti_suppllier`( `name`, `mail`, `phone`, `TIN`, `CIN`, `PAN`, `address`, `city_id`, `supplier_notes`, `sup_balance`, `IsActive`) VALUES
	 ('$name','$email','$mobile','$tin','$cin','$pan','$address','$city','$notes','$balance','$isactive')";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

