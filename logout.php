<?php 
include("include/include.php");
session_unset();
    session_destroy();
    header("location:index.php"); exit;
/*	if(isset($_SESSION['USERID'])){
	$qu="update ti_user set activelog=0 where id='".$_SESSION['USERID']."' ";
	$st=$conn->query($qu);
	session_unset();
    session_destroy();
    header("location:./"); exit;
}*/
	
    

?>
