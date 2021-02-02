<?php 

	include("../include/include.php"); 
	    $cat=isset($_POST['catname']) ? $_POST['catname']:'';
	    $cat=test($cat);
	$proid=isset($_POST['proid']) ? $_POST['proid']:'';
	$description=isset($_POST['catdescription']) ? $_POST['catdescription']:'';
	 $description=test($description);
	$isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	
	
	$query="UPDATE `ti_category` SET `name`='$cat',`category_desc`='$description'  WHERE id='$proid'";//,`IsActive`='$isactive'
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

