<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
	$status=$_GET['status'];
$id=$_GET['pid'];
echo $id;

if($status==0)
{
	$query="UPDATE `vehicle_details` SET `IsActive`=0 WHERE id='$id'";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	echo $query;
	echo"done";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		$query="UPDATE `vehicle_details` SET `IsActive`='$status' WHERE id='$id'";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	echo $query;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
		
		}
	
