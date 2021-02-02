<?php
	include("../include/include.php"); 
	if(isset($_POST['invdate']) && isset($_POST['invNum'])){
		$retDate=isset($_POST['retDate']) ? $_POST['retDate']:'';
	    $return_date = DateTime::createFromFormat('d/m/Y', $retDate)->format('Y-m-d');
		$invdate=isset($_POST['invdate']) ? $_POST['invdate']:'';
	    $invoice_date = DateTime::createFromFormat('d/m/Y', $invdate)->format('Y-m-d');
		if(isset($_POST['cust_id'])){$custid = $_POST['cust_id'];} else{$custid = 1;}
		$invNum = $_POST['invNum'];
		$query="INSERT INTO `ti_creditnote`( `cnDate`, `invid`, `invDate`, `custid`) VALUES 
		('$return_date','$invNum','$invoice_date','$custid')";
		$r=$conn->query($query);
		$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	}
	header('Location: ../pages/maillanding.php'); exit();
 ?>