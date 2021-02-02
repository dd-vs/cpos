<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
	        $veh_no=isset($_POST['veh_no']) ? $_POST['veh_no']:'';

	    
	    $veh_name=isset($_POST['veh_name']) ? $_POST['veh_name']:'';
	    $qty=isset($_POST['qty']) ? $_POST['qty']:'';
	    $qty1=isset($_POST['qty1']) ? $_POST['qty1']:'';
	   $proid=isset($_POST['proid']) ? $_POST['proid']:'';
	    
	
	
	$query="UPDATE `vehicle_details` SET `vehicle_name`='$veh_name',`vehicle_no`='$veh_no',`transport_qty1`='$qty1',`transport_qty2`='$qty' where id='$proid'";
	 //~ select id from master_cities where name='$city')
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);;


?>

