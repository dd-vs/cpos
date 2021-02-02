<?php 

	include("../include/include.php"); 
	    $item_name=isset($_POST['item_name']) ? $_POST['item_name']:'';
	    $item_name=test($item_name);
	$proid=isset($_POST['proid']) ? $_POST['proid']:'';
	$item_value=isset($_POST['item_value']) ? $_POST['item_value']:'';
	 $item_value=test($item_value);

	
	
	$query="UPDATE `master_deduction` SET `deduction_name`='$item_name',`default_val`='$item_value'   WHERE id='$proid'";//,`IsActive`='$isactive'
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
header('Location: ' . $_SERVER['HTTP_REFERER']);
}


?>

