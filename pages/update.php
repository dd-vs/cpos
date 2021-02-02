<?php 
include("../include/include.php");

	if(isset($_SESSION['UID'])){
	$qu="update ti_user set activelog=0 where id='".$_SESSION['UID']."' ";
	$st=$conn->query($qu);
	header("location:../logout.php");
}
else{$qu="update ti_user set activelog=0 where id='".$_SESSION['inid']."' ";
	$st=$conn->query($qu);
	header("location:../logout.php");
}
