<?php include("../include/include.php");
 $date=isset($_POST['date']) ? $_POST['date']:'';
  $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
	    $inward=isset($_POST['inword']) ? $_POST['inword']:'';
	    $supplier=isset($_POST['customer']) ? $_POST['customer']:'';
	    $select=isset($_POST['select']) ? $_POST['select']:'';
	    $amt=isset($_POST['amt']) ? $_POST['amt']:'';
	    $reference=isset($_POST['reference']) ? $_POST['reference']:'';
	      $cust_id=isset($_POST['cust_id']) ? $_POST['cust_id']:''; 
	      $sup_id=isset($_POST['sup_id']) ? $_POST['sup_id']:'';
	      $selectmode=isset($_POST['selectmode']) ? $_POST['selectmode']:'';
	       $query="select id from master_paymodes where mode='$selectmode'";
$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$w=$s->fetch();
$id=$w['id'];
	 if($inward==0){
			$qqq22="INSERT INTO `ti_cash_book`( `payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`)
	 VALUES(1,2,'$id','$show_date','$cust_id','','','$amt','$reference',1)";
		$qqqi=$conn->query($qqq22);
		$a=$qqqi->setfetchmode(PDO::FETCH_ASSOC);
	    $lid=$conn->lastInsertId();
			 $query="UPDATE `ti_customer` SET `cus_balance`=cus_balance-'$amt' WHERE id='$cust_id'";
$s1=$conn->query($query);
		$params= array();
	$params[':date'] = $show_date;
	$params[':cid'] = $cust_id;
	$params[':party_type'] = 1;
	$params[':purpose_code'] = 5;
	$params[':invoice_id'] = $lid;
	$params[':amt'] = $amt;
	$params[':isactive'] = 1;
	
		$query_payments_in = "INSERT INTO `ti_payments_in`(`pay_date`,`from_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
		$stmt= $conn->prepare($query_payments_in);
		$stmt->execute($params);
		$params[':amt'] = 0;
		$query_payments_out = "INSERT INTO `ti_payments_out`(`pay_date`,`to_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
		$stmt= $conn->prepare($query_payments_out);
		$stmt->execute($params);
	


			 	}
			else{
				
				$qqq22="INSERT INTO `ti_cash_book`( `payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`)
	 VALUES(2,1,'$id','$show_date','$sup_id','','','$amt','$reference',1)";
		$qqqi=$conn->query($qqq22);
		$a=$qqqi->setfetchmode(PDO::FETCH_ASSOC);
	    $lid=$conn->lastInsertId();
		$query="UPDATE `ti_suppllier` SET `sup_balance`=sup_balance-'$amt' WHERE id='$sup_id'";
$s1=$conn->query($query); 

		$params= array();
	$params[':date'] = $show_date;
	$params[':cid'] = $sup_id;
	$params[':party_type'] = 2;
	$params[':purpose_code'] = 5;
	$params[':invoice_id'] = $lid;
	$params[':amt'] = 0;
	$params[':isactive'] = 1;
	
		$query_payments_in = "INSERT INTO `ti_payments_in`(`pay_date`,`from_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
		$stmt= $conn->prepare($query_payments_in);
		$stmt->execute($params);
		$params[':amt'] = $amt;
		$query_payments_out = "INSERT INTO `ti_payments_out`(`pay_date`,`to_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
		$stmt= $conn->prepare($query_payments_out);
		$stmt->execute($params);


			}
			 $_SESSION['i']='100';
header('Location:../pages/cash_book.php');
 
