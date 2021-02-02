<?php 

	include("../include/include.php"); 
	$status=$_GET['status'];
$id=$_GET['pid'];

if($status==0)
{
	$query="UPDATE `master_allowance` SET `IsActive`=0 WHERE id='$id'";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		$query="UPDATE `master_allowance` SET `IsActive`='$status' WHERE id='$id'";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
		
		}
	
