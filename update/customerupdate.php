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
	    $city=isset($_POST['cities11']) ? $_POST['cities11']:'';
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	     $address=test($address);
	    $proid=isset($_POST['proid']) ? $_POST['proid']:'';
	    $balance=isset($_POST['balance']) ? $_POST['balance']:'';
	    
	
	
	
	$query="UPDATE `ti_customer` SET `name`='$name',`mobile`='$mobile',`email`='$email',`TIN`='$tin',`PAN`='$pan',`Address_l1`='$address',`city_id`='$city',`cus_balance`='$balance' where id='$proid'";
	 //~ select id from master_cities where name='$city')
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);;
}

?>

