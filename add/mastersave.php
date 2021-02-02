
<?php 

include("../include/include.php"); 
	
	$item_name=isset($_POST['item_name']) ? $_POST['item_name']:'';
	$item_name=test($item_name);
	$item_type=isset($_POST['item_type']) ? $_POST['item_type']:'';
	$item_type=test($item_type);
	$item_value=isset($_POST['item_value']) ? $_POST['item_value']:'';
	$item_value=test($item_value);
	 if($item_type==1){
		 $insert="INSERT INTO `master_allowance`( `allowance_name`, `default_val`, `IsActive`) VALUES
		 ('$item_name','$item_value',1)";
		 $co=$conn->query($insert);
		 
		 }
	 else if($item_type==2){
		 $insert="INSERT INTO `master_deduction`( `deduction_name`, `default_val`, `IsActive`) VALUES
		 ('$item_name','$item_value',1)";
		 $co=$conn->query($insert);
		 
		 }
	$_SESSION['i']=1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);




?>
