<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php");
	$sql="select max(ti_purchase_invoice.invoice_id)+1 as eno from ti_purchase_invoice where IsHidden=11 and IsActive=1";
	$s=$conn->query($sql); $res=$s->fetch(); 
	    $in_id=isset($res['in_id']) ? $res['in_id']:'';
	    $in_no=isset($_POST['in_no']) ? $_POST['in_no']:'';
	    $date=isset($_POST['date']) ? $_POST['date']:'';
	    $dt=isset($_POST['date']) ? implode('-',array_reverse(explode('-',$_POST['date']))).' '.date("Y-m-d"): date("Y-m-d H:i:s") ;
	    $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'10';
	    $supplier=isset($_POST['supplier']) ? $_POST['supplier']:'';
	    //~ echo $supplier;
	    //~ exit;
	    $hidden=isset($_POST['hidden']) ? $_POST['hidden']:'';
	       $discount=isset($_POST['amount1']) ? $_POST['amount1']:'';
	    $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
$time=$show_date;
	    $qu="SELECT `id` FROM `ti_suppllier` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide=isset($ae2['id']) ? $ae2['id']:'1';
	
	//echo $cash_credit;

	
	if(isset($_POST['proname1']) && count($_POST['proname1']) >0) {
	$query="INSERT INTO `ti_purchase_invoice`(`invoice_id`, `invoice_num`, `supplier_id`, `pur_date`, `amt`, `cgst_amt`,`sgst_amt`, `cash_credit`,`discount`, `IsHidden`, `IsActive`) 
	VALUES 
	 ('$in_id','$in_no','$ide',' $time','','','','$cash_credit','$discount','$hidden',1)";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	$lid=$conn->lastInsertId();
}
	
	
	
	
	//~ if($a)
//~ {	echo "dff";
		//~ $_SESSION['uid']=1;
		//~ $_SESSION['status']="successfully saved";
	//~ header("location:addcustomer.php");
//~ }

		if($lid > 0 ) {
			$conn->beginTransaction();
			//$query="UPDATE enq_item_details set modify_status='3' WHERE enq_no='$enq_no' ";
			//$conn->query($query);
			$query='INSERT INTO `ti_purchse_items`( `inv_id`, `product_id`, `qty`, `buy_price`, `cess`, `IsActive`) VALUES ';
			$append_query='';
			if(isset($_POST['proname1']) && count($_POST['proname1']) >0) {
				$i=0;
				foreach($_POST['proname1'] as $row) {
$ip=$_POST['proname1'][$i];
$id=$_POST['proid'][$i];
$j=print_r($ip,true);
$iparr = preg_split ("/-/", $j); 
$sqft=$_POST['buyprice1'][$i];
$rate=$_POST['qty1'][$i]; 
//~ $tax=$_POST['tax1'][$i];
//~ $tax2=$_POST['tax2'][$i];
$sum=$_POST['added1'][$i];
$cess=$_POST['cess1'][$i];
$cgst=$_POST['cgst'][$i];
$sgst=$_POST['sgst'][$i];
//~ $cgst=$_POST['cgst'][$i];
$totalcs=$cgst+$sgst;
$cgstamt=$_POST['cgstamt'][$i];
$sgst=$_POST['sgst'][$i];
$sgstamt=$_POST['sgstamt'][$i];

$adx=$rate*$sqft;
//echo $adx;
//~ echo $sgst;
//~ echo $cgstamt;
//~ echo $cgst;
$aw=$adx*$totalcs;
$az=100+$totalcs;
$nw=round($aw,2)/round($az,2);
$gross=$adx-$nw;
$grossamt=round($gross,2);
//echo $grossamt;
$taxamt1=$grossamt*$cgst;
$tabletaxamt2=$taxamt1/100;
$taxamt12=$grossamt*$sgst;
$tabletaxamt21=$taxamt12/100;

  //~ $querytax="INSERT INTO `ti_tax`( `inv_type`, `inv_id`,  `cgst_tax_percent`, `sgst_tax_percent`, `taxable_amt`, `ctax_amt`, `stax_amt`, `isActive`) VALUES 
//~ ('2','$lid','$cgst','$sgst','$grossamt','$tabletaxamt2','$tabletaxamt21','1')";
//~ $tax=$conn->query($querytax);
//~ $atax=$tax->setfetchmode(PDO::FETCH_ASSOC);
					
						
						$q="select ti_product.id,ti_product.item_stock from ti_product  where ti_product.name='$iparr[0]' ";
						$r12=$conn->query($q);
						$a12=$r12->setfetchmode(PDO::FETCH_ASSOC);
						$a13=$r12->fetch();
						//$id=$a13['id'];
						//~ $item_stock=$a13['item_stock'];
						$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$lid'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                      
                       /// $s11=$r11->fetch();
                        //echo $q1;
                         
                        while($s11=$r11->fetch()){
							$date1=$show_date;
							//echo $date1;
							//exit;
                      
                       //STOCK PART 
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$id' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						//$qid=$aq13['id'];
						$item_stock=$aq13['item_stock'];
					 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$id'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock+$rate;
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_in`, `qty_stock`, `isActive`) VALUES ('$date1','$id','$rate','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='$id' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
					
							if($count!=0){
								
								$up="update ti_stock set qty_in=qty_in+'$rate' ,qty_stock=qty_stock+'$rate' where p_id='$id' and transaction_date='$date1'";
								$pu=$conn->query($up);
								
									$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								
								
								}
								else {
									echo 1;
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$id'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									//~ echo $mindate;
									//~ echo $maxdate;
									//~ echo $date1;
									
									if($date1>$maxdate){
										echo 2;
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
										$ststock=$stockimm+$rate;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$id','$rate','','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										else if($date1<$mindate){
											echo 3;
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$id' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock+$rate;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$id','$rate','','$this_stock',1)";
											$tm=$conn->query($insert);
											//echo $insert;
										
											$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											//echo $sel;
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										echo $upsel;
										
										}
											}
											else if($date1>$mindate && $date1<$maxdate){
												echo 4;
												//exit;
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
										$ststock=$stockimm+$rate;
										//echo $ssim2['qty_stock'];
										//~ echo $ststock;
										//~ exit;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$id','$rate','','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}//STOCK PART
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$id'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
								
					}
						
						$append_query .="('$lid','$id','$rate','$sqft','$cess',1),";
				
				
					//~ if(((int)$estatus==3) &&  ((int)$eitem_id) >0 ) {
						//~ //$updatequery="UPDATE enq_item_details set modify_status='$estatus' WHERE id='$eitem_id' "; $conn->query($updatequery);
					//~ }
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}
			}
			
			
					$balance=isset($_POST['balance-amount']) ? $_POST['balance-amount']:'';
							$balance=isset($_POST['balance-amount']) ? $_POST['balance-amount']:'';
						$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';
			$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					$amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
					$totcessamt=isset($_POST['totcessamt']) ? $_POST['totcessamt']:'';
						$fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
					$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
					echo $fraction;
					echo $amtpart;
					
			$qu="UPDATE `ti_purchase_invoice` set `amt`='$amtpart', `roundOff`='$fraction',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst',`totCess_amt`= '$totcessamt' where invoice_id='$lid'";
			$r5=$conn->query($qu);
		
			
			
			/* ROUND OFF CODE
							
					//~ $whole = floor($balance);      // 1
//~ $fraction = $balance - $whole;
//~ if($fraction>0.50){
	//~ //echo $fraction;
	
	//~ $dec=1-$fraction;
	
	//~ $amtblnc=$balance+$dec;
	//~ $totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';
			//~ $totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					//~ $amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
					//~ $totcessamt=isset($_POST['totcessamt']) ? $_POST['totcessamt']:'';
			//~ $qu="UPDATE `ti_purchase_invoice` set `amt`='$amtblnc', `roundOff`='$dec',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst',`totCess_amt`= '$totcessamt' where invoice_id='$lid'";
			//~ $r5=$conn->query($qu);
		//~ }
		//~ else{
			//~ $amtblnc=$balance-$fraction;
			//~ $totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';
			//~ $totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					//~ $amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
					//~ $totcessamt=isset($_POST['totcessamt']) ? $_POST['totcessamt']:'';
			//~ $qu="UPDATE `ti_purchase_invoice` set `amt`='$amtblnc',  `roundOff`=-'$fraction',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst',`totCess_amt`= '$totcessamt' where invoice_id='$lid'";
			//~ $r5=$conn->query($qu);
			//~ }
			ROUDD OFF*/
			  $qu="SELECT `id` FROM `ti_suppllier` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide=isset($ae2['id']) ? $ae2['id']:'1';
		$difference=isset($_POST['difference']) ? $_POST['difference']:'';

			if($cash_credit==11){
				$difference=isset($_POST['difference']) ? $_POST['difference']:'';
		$qqqqq="UPDATE `ti_suppllier` SET `sup_balance`=sup_balance+'$difference' where id ='$ide'";
		$que1ry1="INSERT INTO `ti_cash_book`(`payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`) 
VALUES(1,1,1,'$time','$ide',2, '$lid','$amttotal','',1)"; 

$r121=$conn->query($que1ry1);


$a121=$r121->setfetchmode(PDO::FETCH_ASSOC);
		//~ echo $qqqqq;
		//~ exit;
		$qi=$conn->query($qqqqq);
		
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
	//sexit;
?>


