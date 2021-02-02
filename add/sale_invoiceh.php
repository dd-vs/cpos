<?php 

	include("../include/include.php"); 
	   

	    $date=isset($_POST['date']) ? $_POST['date']:'';
	    $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
	     $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'11';
	    $supplier=isset($_POST['customer']) ? $_POST['customer']:'';
	    
	     $vehicle_num=isset($_POST['vehicle_num']) ? $_POST['vehicle_num']:'';
	  $vehicle_num=test($vehicle_num);

	
	    $hidden=isset($_POST['hidden']) ? $_POST['hidden']:'10';
$tottax=isset($_POST['tottax11']) ? $_POST['tottax11']:'';
$totamt=isset($_POST['totamt']) ? $_POST['totamt']:'';
$discount=isset($_POST['amount1']) ? $_POST['amount1']:'';
$selectsale=isset($_POST['selectsale']) ? $_POST['selectsale']:'';
if($selectsale==0){
		    $query="select max(ti_sale_invoice.invoice_num)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=11 and ti_sale_invoice.sale_type=0 and ti_sale_invoice.IsActive=1";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	}
else if($selectsale==1){
		    $query="select max(ti_sale_invoice.invoice_num)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=11 and ti_sale_invoice.sale_type=1 and ti_sale_invoice.IsActive=1";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	}

$timestamp=date('Y/m/d H:i:s');
$time=$show_date;

    $qu="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide=isset($ae2['id']) ? $ae2['id']:'1';
	 
	if(isset($_POST['proname1']) && count($_POST['proname1']) >0) {
	$query="INSERT INTO `ti_sale_invoice`( `invoice_num`, `cust_id`, `sale_date`, `amt`, `cgst_amt`,`sgst_amt`, `cash_credit`, `discount`,`sale_type`,`IsHidden`, `IsActive`) VALUES 
	 ('$in_no','$ide',' $time','','','','$cash_credit','$discount','$selectsale','$hidden',1)";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	$lid=$conn->lastInsertId();
	$q1="INSERT INTO `ti_transport`( `invoice_type`, `invoice_id`, `vehicle_num`, `name`, `time`, `IsActive`) VALUES('1','$lid','$vehicle_num','','$timestamp','1')";
	$tmp=$conn->query($q1);

	
	
}

	


		if($lid > 0 ) {
			$conn->beginTransaction();
		
			$query='INSERT INTO `ti_sale_item`( `invoice_id`, `product_id`, `qty`, `sell_price`,`cgst_percent`,`sgst_percent`, `IsActive`) VALUES ';
			$append_query='';
			if(isset($_POST['proname1']) && count($_POST['proname1']) >0) {
				$i=0; $j=0;
				foreach($_POST['proname1'] as $row) {
$ip=$_POST['proname1'][$i];
$id=$_POST['proid'][$i];
$j=print_r($ip,true);
$iparr = preg_split ("/-/", $j); 
$sqft=$_POST['buyprice1'][$i];
$rate=$_POST['qty1'][$i]; 

 $sum=$_POST['added1'][$i];
$dis=$_POST['disprice1'][$i];
$new=$sum/$rate;
$cgst=$_POST['cgst'][$i];
$sgst=$_POST['sgst'][$i];

$totalcs=$cgst+$sgst;
$cgstamt=$_POST['cgstamt'][$i];
$sgst=$_POST['sgst'][$i];
$sgstamt=$_POST['sgstamt'][$i];

$adx=$rate*$sqft;

$aw=$adx*$totalcs;
$az=100+$totalcs;
$nw=round($aw,2)/round($az,2);
$gross=$adx-$nw;
$grossamt=round($gross,2);

$taxamt1=$grossamt*$cgst;
$tabletaxamt2=$taxamt1/100;
$taxamt12=$grossamt*$sgst;
$tabletaxamt21=$taxamt12/100;

  $querytax="INSERT INTO `ti_tax`( `inv_type`, `inv_id`,  `cgst_tax_percent`, `sgst_tax_percent`, `taxable_amt`, `ctax_amt`, `stax_amt`, `isActive`) VALUES 
('1','$lid','$cgst','$sgst','$grossamt','$tabletaxamt2','$tabletaxamt21','1')";
$tax=$conn->query($querytax);
$atax=$tax->setfetchmode(PDO::FETCH_ASSOC);
						$q="select ti_product.id,ti_product.item_stock from ti_product  where ti_product.name='$iparr[0]' ";

						$r12=$conn->query($q);
						$a12=$r12->setfetchmode(PDO::FETCH_ASSOC);
						$a13=$r12->fetch();
					
                        $q1="SELECT date(`sale_date`) as date1 from ti_sale_invoice  where invoice_id='$lid'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
							
						//STOCK PART	
							$qq="select ti_product.item_stock from ti_product  where ti_product.id='$id' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
						$item_stock=$aq13['item_stock'];
						//checking product exists
                        $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$id'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$rate;
             	//if product not exists
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$id','$rate','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						//if product  exists
						else{
						
						
							//checking date exists
							$check1="select count(id) as count from ti_stock where p_id='$id' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							//if not exists
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out+'$rate' , qty_stock=qty_stock-'$rate' where p_id='$id' and transaction_date='$date1'";
								$pu=$conn->query($up);
								$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								
								}
								//if exists
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$id'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
							//checking date is max 
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$id' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$id' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$rate;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$id','','$rate','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										//checking date is min
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$id' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock-$rate;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$id','','$rate','$this_stock',1)";
											$tm=$conn->query($insert);
										
											$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											//checking date in between
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$id' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$id' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$rate;
									;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$id','','$rate','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}
                      //STOCK PART
					}
						$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$id'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
						$append_query .="('$lid','$id','$rate','$new','$cgst','$sgst',1),";
				
				
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}
			}
			

					$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';	
					$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					$balance=isset($_POST['balance-amount']) ? $_POST['balance-amount']:'';
					$fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
					$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
						$qu="UPDATE `ti_sale_invoice` set `amt`='$amtpart',`roundOff`='$fraction',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst' where invoice_id='$lid'";
			$r5=$conn->query($qu);
					
			
			
			
			
			if($cash_credit==11){
						$difference=isset($_POST['difference']) ? $_POST['difference']:'';
				  $qu="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide11=isset($ae2['id']) ? $ae2['id']:'1';
	 
		$qqqqqq="UPDATE `ti_customer` SET `cus_balance`=cus_balance+'$difference' where id ='$ide11'";
		
		$qi=$conn->query($qqqqqq);
	
	$qqq22="INSERT INTO `ti_cash_book`( `payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`)
	 VALUES(2,2,1,'$time','$ide11',1,'$lid','$balance','sale invoice',1)";
		$qqqi=$conn->query($qqq22);
		}
	$a5=$r5->setfetchmode(PDO::FETCH_ASSOC);
	
			
			$conn->commit();
			
			
			$_SESSION['uid']='200';
			$_SESSION['status']='Succesfully Saved Data';
		} else {
			$_SESSION['ERRORCODE']='401';
			$_SESSION['ERRORMESSAGE']='Invalid Process';
		}
		 $_SESSION['i']='100';
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
?>


