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
	    $city=isset($_POST['cities11']) ? $_POST['cities11']:'';
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	      $address=test($address);
	    $proid=isset($_POST['proid']) ? $_POST['proid']:'';
	    	    $balance=isset($_POST['balance']) ? $_POST['balance']:'';
	    	    $notes=isset($_POST['notes']) ? $_POST['notes']:'';
	    	    $notes=test($notes);
	    
	
	
	
	$query="UPDATE `ti_suppllier` SET `name`='$name',`mail`='$email',`phone`='$mobile',`TIN`='$tin',`CIN`='$cin',`PAN`='$pan',`address`='$address',`city_id`='$city',`supplier_notes`='$notes',`sup_balance`='$balance'  where id='$proid'";
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

