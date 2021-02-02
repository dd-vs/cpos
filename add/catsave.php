<?php 

	include("../include/include.php"); 
	    $cat=isset($_POST['catname']) ? $_POST['catname']:'';
	 $cat=test($cat);
	$description=isset($_POST['catdescription']) ? $_POST['catdescription']:'';
	 $description=test($description);
	$isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	
	
	$query="INSERT INTO `ti_category`( `name`, `category_desc`, `IsActive`) VALUES ('$cat','$description','$isactive')";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

