<?php 

	include("../include/include.php"); 
	$status=$_GET['status'];
$id=$_GET['pid'];

if($id!=$_SESSION['UID']){
if($status==0)
{
	$query="UPDATE `ti_user` SET `IsActive`=0 WHERE id='$id' ";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		$query="UPDATE `ti_user` SET `IsActive`='$status' WHERE id='$id'";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
		
		}
	}
else
{
	$_SESSION['l']='101';
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	
	}
