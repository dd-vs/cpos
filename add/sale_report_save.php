<?php 
	include("../include/include.php"); 
	
	if(isset($_POST['submit']))
	{
		
	    
	    $query="select *,max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	    $date=isset($_POST['date']) ? $_POST['date']:'';
	   
	   
	    // $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
	  
	
	    $invno=isset($_POST['invoiceid']) ? $_POST['invoiceid']:'';
	  
	     $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'10';
	    $supplier=isset($_POST['customer']) ? $_POST['customer']:'';
	    $discount=isset($_POST['discount']) ? $_POST['discount']:'';
	 
	  
	  
	    $hidden=isset($_POST['hidden']) ? $_POST['hidden']:'10';
$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';
$amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
$fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
$sales_man=isset($_POST['sales_man']) ? $_POST['sales_man']:'';
$invcreditsale=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'11';

$time=date('Y-m-d');
$time1=date('Y-m-d H:i:s');
$quq="SELECT * FROM `ti_sale_invoice` WHERE `invoice_id`='$invno' ";
	    $req=$conn->query($quq);
	    $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2=$req->fetch();
	$invid=$aeq2['invoice_id'];
	$disss=$aeq2['discount'];

	$quwsale="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	$rewsale=$conn->query($quwsale);
	$aewsale=$rewsale->setfetchmode(PDO::FETCH_ASSOC);
	$ae2wsale=$rewsale->fetch();
	$ideqwsale=$_POST['cust_id'];
	
	$saleupdate="UPDATE `ti_sale_invoice` SET cust_id='$ideqwsale' ,`sales_man`='$sales_man' WHERE invoice_id='$invno'";
	$sale=$conn->query($saleupdate);
	if (trim($amtpart) !='') {
		$params= array();
		$params[':invoice_id'] = $invno;
		$params[':amt'] = $amtpart;
		if ($invcreditsale == 11) {
			$query_payments_out = "UPDATE ti_payments_out SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_out);
			$stmt->execute($params);
		} else if ($invcreditsale ==10) {
			$query_payments_in = "UPDATE ti_payments_in SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_in);
			$stmt->execute($params);
			$query_payments_out = "UPDATE ti_payments_out SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_out);
			$stmt->execute($params);
		}
	}			

	if($disss>$discount){
		
		
		$upddis="UPDATE `ti_sale_invoice` SET `amt`=amt+'$discount',`discount`='$discount' ,`sale_date`='$show_date',`sales_man`='$sales_man'  WHERE `invoice_id`='$invid'";
		
		$disc=$conn->query($upddis);
	
		}
		else if($disss<$discount)
		{
			$upddis="UPDATE `ti_sale_invoice` SET `amt`=amt-'$discount',`discount`='$discount',`sale_date`='$show_date',`sales_man`='$sales_man'  WHERE `invoice_id`='$invid'";
		$disc=$conn->query($upddis);
			
			
			}
		//ADDING ITEMS	
	$query='INSERT INTO `ti_sale_item`( `invoice_id`, `product_id`, `qty`, `discount`,`sell_price`,`cgst_percent`,`sgst_percent`, `IsActive`) VALUES ';
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
$pot=$sqft*$rate;
$poot+=$pot; 
$dis=$_POST['disprice1'][$i];

$estatus=$_POST['estatus'][$i];
$sum=$_POST['added1'][$i];
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
$saleupdate="UPDATE `ti_sale_invoice` SET `amt`='$amtpart' ,`roundOff`='$fraction',cgst_amt='$totcgst',sgst_amt='$totsgst',`sales_man`='$sales_man'  WHERE invoice_id='$invno'";

						$sale=$conn->query($saleupdate);
						$quqsale="SELECT * FROM `ti_sale_invoice` WHERE `invoice_id`='$invno' ";
	    $reqsale=$conn->query($quqsale);
	    $aeqsale=$reqsale->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2sale=$reqsale->fetch();

	
	
$quwsale="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $rewsale=$conn->query($quwsale);
	$aewsale=$rewsale->setfetchmode(PDO::FETCH_ASSOC);
	$ae2wsale=$rewsale->fetch();
	$ideqwsale=$_POST['cust_id'];
	$invcreditsale=$aeq2sale['cash_credit'];
	if($invcreditsale==11){
	$qzcssale="UPDATE `ti_customer` SET `cus_balance`=`cus_balance`+'$poot' WHERE `id`='$ideqwsale'";
							  $rzcssale=$conn->query($qzcssale);	  
	}


$querytax="INSERT INTO `ti_tax`( `inv_type`, `inv_id`,  `cgst_tax_percent`, `sgst_tax_percent`, `taxable_amt`, `ctax_amt`, `stax_amt`, `isActive`) VALUES 
('1','$invid','$cgst','$sgst','$grossamt','$tabletaxamt2','$tabletaxamt21','1')";
$tax=$conn->query($querytax);
$atax=$tax->setfetchmode(PDO::FETCH_ASSOC);
						$q="select ti_product.id,ti_product.item_stock from ti_product  where ti_product.name='$iparr[0]' ";

						$r12=$conn->query($q);
						$a12=$r12->setfetchmode(PDO::FETCH_ASSOC);
						$a13=$r12->fetch();
					
                        $q1="SELECT date(`sale_date`) as date1 from ti_sale_invoice  where invoice_id='$invid'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$s11['date1'];
							
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
							
							
							
							}	//STOCK PART
					}
						$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$id'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
						
						$append_query .="('$invno','$id','$rate','$dis','$sqft','$cgst','$sgst',1),";
				
								
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}
			}
			
			//REMOVING ITEMS
	 $query='INSERT INTO `ti_sale_item`( `invoice_id`, `product_id`, `qty`, `sell_price`, `IsActive`) VALUES ';
			$append_query='';
			$pt=0;
			$tab=0;
			$tab1=0;
	    if(isset($_POST['saleproid']) && count($_POST['saleproid']) >0) {
				$i=0; $j=0;
				foreach($_POST['saleproid'] as $row) {
$ip=$_POST['saleproid'][$i];
$id=$_POST['proid'][$i];
$_SESSION['pro']=$id;
$j=print_r($ip,true);
$iparr = preg_split ("/-/", $j); 
$sqft=$_POST['salerate'][$i];
$_SESSION['rate']=$sqft;
$rate=$_POST['saleqty'][$i];
$_SESSION['qty']=$rate;


$cgst=$_POST['salecgst'][$i];
$_SESSION['cgst']=$cgst;

$dis=$_POST['dis'][$i];
$_SESSION['dis']=$dis;

$sgst=$_POST['salesgst'][$i];
$_SESSION['sgst']=$sgst;
$idpro=$_POST['id'][$i];
$_SESSION['isw']=$idpro;
$saleid=$_POST['saleid'][$i];
$_SESSION['saleid']=$saleid;

$totalcs=$cgst+$sgst;
$_SESSION['total']=$totalcs;

$adx=$rate*$sqft;


//~ $aw=$adx*$totalcs;
//~ $az=100+$totalcs;
//~ $nw=round($aw,2)/round($az,2);
//~ $gross=$adx-$nw;
//~ $grossamt=round($gross,2);

//~ $taxamt1=$grossamt*$cgst;
//~ $tabletaxamt2=$taxamt1/100;
//~ $taxamt12=$grossamt*$sgst;
//~ $tabletaxamt21=$taxamt12/100;
$estatus=$_POST['estatus'][$i];
				if((int)$estatus==0) {
					
						$ptamt=$_SESSION['rate']*$_SESSION['qty'];
						
$pt+=$ptamt;

$aw=$pt*$_SESSION['total'];
$az=100+$_SESSION['total'];
$nw=round($aw,2)/round($az,2);
$gross=$pt-$nw;
$grossamt=round($gross,2);

$taxamt1=$grossamt*$_SESSION['cgst'];
$tabletaxamt2=$taxamt1/100;
$tab+=$tabletaxamt2;
$ctab=round($tab,2);

$taxamt12=$grossamt*$_SESSION['sgst'];
$tabletaxamt21=$taxamt12/100;
$tab1+=$tabletaxamt21;
$stab=round($tab1,2);



						
						$qqw="select id  from `ti_product` WHERE id='".$_SESSION['pro']."' ";
							$cow=$conn->query($qqw);
							
							$cow->setfetchmode(PDO::FETCH_ASSOC);
							while($cpw=$cow->fetch()){
							$idew=$cpw['id'];
							
						}
						
						$quq="SELECT * FROM `ti_sale_invoice` WHERE `invoice_id`='$invno' ";
	    $req=$conn->query($quq);
	    
	    $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2q=$req->fetch();
	$invid1=$aeq2q['invoice_id'];
	$invcreditq=$aeq2q['cash_credit'];
	$_SESSION['cash']=$invcreditq;
	$date1=$aeq2q['sale_date'];

						
						$updatequery="UPDATE ti_sale_item set IsActive=0 WHERE product_id='".$_SESSION['isw']."' and id='".$_SESSION['saleid']."' and invoice_id='$invid'"; $conn->query($updatequery);
						
		
		
		//STOCK PART
			$qq="select ti_product.item_stock from ti_product  where ti_product.id='".$_SESSION['isw']."' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
						$item_stock=$aq13['item_stock'];
								    $q12="SELECT count(id) as num FROM `ti_stock` where p_id='".$_SESSION['isw']."'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock+$_SESSION['qty'];
             	//if product not exists
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_in`, `qty_stock`, `isActive`) VALUES ('$date1','".$_SESSION['isw']."','".$_SESSION['qty']."','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						//if product  exists
						else{
						
							//checking date exists
							$check1="select count(id) as count from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							//if not exists
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out-'".$_SESSION['qty']."' , qty_stock=qty_stock+'".$_SESSION['qty']."' where p_id='".$_SESSION['isw']."' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								//if exists
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='".$_SESSION['isw']."'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
							//checking date is max 
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='".$_SESSION['isw']."' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm+$_SESSION['qty'];
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','".$_SESSION['isw']."','".$_SESSION['qty']."','','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										//checking date is min
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock+$_SESSION['qty'];
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','".$_SESSION['isw']."','".$_SESSION['qty']."','','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											//checking date in between
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='".$_SESSION['isw']."' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm+$_SESSION['qty'];
										
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','".$_SESSION['isw']."','".$_SESSION['qty']."','','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}
							//STOCK PART
		
	$qrw123="UPDATE `ti_product` SET `item_stock`=item_stock+'".$_SESSION['qty']."' WHERE id='".$_SESSION['isw']."'";
		$prow123=$conn->query($qrw123);
	$quw="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $rew=$conn->query($quw);
	$aew=$rew->setfetchmode(PDO::FETCH_ASSOC);
	$ae2w=$rew->fetch();
	$ideqw=$_POST['cust_id'];
	  $fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
$sales_man=isset($_POST['sales_man']) ? $_POST['sales_man']:'';
		$cgst12="UPDATE `ti_sale_invoice` SET `cgst_amt`='$totcgst',`sgst_amt`='$totsgst',`amt`='$amtpart',`roundOff`='$fraction',`sales_man`='$sales_man'   WHERE `invoice_id`='$invid' ";//,`sale_date`='$show_date'
		$cgst34=$conn->query($cgst12);
		 
		 
		 $tax="SELECT min(id) as idmin FROM `ti_tax` WHERE `inv_id`='$invid1' and ctax_amt='$ctab' and stax_amt='$stab' ";
	
							$tax1=$conn->query($tax);
							$tax1->setfetchmode(PDO::FETCH_ASSOC);
							while($tax2=$tax1->fetch()){
								$tax3=$tax2['idmin'];
		
		$qrqew="UPDATE `ti_tax` SET `taxable_amt`=taxable_amt-'$grossamt',`ctax_amt`=ctax_amt-'$ctab',`stax_amt`=stax_amt-'$stab' WHERE `id`='$tax3'  ";
		$pror=$conn->query($qrqew);
		 
		}
		 
	
	
	
	
	if($invcreditq==11){
		
		
	$qzcust="UPDATE `ti_customer` SET `cus_balance`=`cus_balance`-'$pt' WHERE `id`='$ideqw'";
	$rzcust=$conn->query($qzcust);
	}
	
		
							 }
							 
							 
							 
							 //estatus chcking closing IN CASE OF DISCOUNT EDITING
							 else if((int)$estatus==3){
								 
								 	$quw="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $rew=$conn->query($quw);
	$aew=$rew->setfetchmode(PDO::FETCH_ASSOC);
	$ae2w=$rew->fetch();
	$ideqw=$_POST['cust_id'];
								 $quq="SELECT * FROM `ti_sale_invoice` WHERE `invoice_id`='$invno' ";
								
	    $req=$conn->query($quq);
	    
	    $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2q=$req->fetch();
	$invid1=$aeq2q['invoice_id'];
	$invcreditq=$aeq2q['cash_credit'];
	
	$_SESSION['cash']=$invcreditq;
	
	$date1=$aeq2q['sale_date']; 
								$newqty=$_SESSION['qty']; 
								$newcgst= $_SESSION['cgst'];
								$newsgst=$_SESSION['sgst'];
								$currcgst=$newcgst/100;
								$currsgst=$newsgst/100;
								$newdis=$_SESSION['dis'];
								$newq="select discount from ti_sale_item where invoice_id='$invno' and id='$saleid'";
								$qex=$conn->query($newq);
								$qex->setfetchmode(PDO::FETCH_ASSOC);
								$qexf=$qex->fetch();
								$discountold=$qexf['discount'];
								$diss_diff=$discountold-$newdis;
								
								if($diss_diff!=0){
									$diss_cgst=$diss_diff*$currcgst;
									$diss_sgst=$diss_diff*$currsgst;
									
									$tottx=$newcgst+$newsgst;
									$tnw=$diss_diff*$tottx;//with that discount value difference of old discount value minus new discount value
									$tnw1=100+$tottx;
									$tnw2=$tnw/$tnw1;
									$gm=$diss_diff-$tnw2;
									$cgstgm=($gm*$newcgst)/100;
									$sgstgm=($gm*$newsgst)/100;
									$cgstround=round($cgstgm,2);									
									$sgstround=round($sgstgm,2);
									$newp=$diss_diff/$newqty;
									$updininvoice="update ti_sale_invoice set amt=amt+'$diss_diff',cgst_amt=cgst_amt+'$cgstround',sgst_amt=sgst_amt+'$sgstround' where invoice_id='$invno'";
								
								
									$connupdateinv=$conn->query($updininvoice);
									$updtaxquery="update ti_tax set taxable_amt=taxable_amt+'', ctax_amt=ctax_amt+'$cgstround',	stax_amt=stax_amt+'$sgstround' where cgst_tax_percent='$newcgst' and sgst_tax_percent='$newsgst'	and inv_id='$invno' ";
									$connselect=$conn->query($updtaxquery);
									
									$updatte="update ti_sale_item set discount=discount-'$diss_diff',sell_price=sell_price+'$newp' where invoice_id= '$invno' and id='$saleid'";
								
									
									$toup=$conn->query($updatte);
									
									if($_SESSION['cash']==11){
		
		
	$qzcust1="UPDATE `ti_customer` SET `cus_balance`=`cus_balance`+'$diss_diff' WHERE `id`='$ideqw'";
	
	$rzcust1=$conn->query($qzcust1);
	}
									}
								 }
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}
			}
			$_SESSION['eid']=1;
            if(isset($_SESSION['customermail'])&&!empty($_SESSION['customermail']))
                {header('Location: ../pages/maillanding.php');}
            else{header('Location: ' . $_SERVER['HTTP_REFERER']);}
					    	
}
if(isset($_POST['delete'])){
	 $invno=isset($_POST['invoiceid']) ? $_POST['invoiceid']:'';
	  $supplier=isset($_POST['customer']) ? $_POST['customer']:'';
	  $amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
	    $fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
$sales_man=isset($_POST['sales_man']) ? $_POST['sales_man']:'';
	  $time=date('Y-m-d');
	
	   $qu="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide=$_POST['cust_id'];
	    $qq="SELECT `has_return` FROM `ti_sale_invoice` WHERE `invoice_id`='$invno'  ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						$wq=$aq13['has_return'];
					
						if($wq!=1)
						{
					$saleinv="SELECT `cgst_amt`, `sgst_amt`,`amt` FROM `ti_sale_invoice` WHERE invoice_id='$invno'";
      $sale=$conn->query($saleinv);
      $sale->setfetchmode(PDO::FETCH_ASSOC);
      $sale_inv=$sale->fetch();
      $c1amt=$sale_inv['cgst_amt'];
      $s1amt=$sale_inv['sgst_amt'];
      $scamt=$sale_inv['amt'];
      $upsale="update ti_sale_invoice set cgst_amt=cgst_amt-'$c1amt',sgst_amt=sgst_amt-'$s1amt',amt=amt-'$scamt',`sales_man`='$sales_man' where invoice_id= '$invno' ";
$upsale=$conn->query($upsale);	
	    
	$quq="SELECT * FROM `ti_sale_invoice` WHERE `invoice_id`='$invno' ";
	    $req=$conn->query($quq);
	    $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2=$req->fetch();
	$invid1=$aeq2['invoice_id'];
	$invcredit=$aeq2['cash_credit'];
	$date1=$aeq2['sale_date'];
	if($invcredit==11){
		
	$qzcs="UPDATE `ti_customer` SET `cus_balance`=`cus_balance`-'$scamt' WHERE `id`='$ide'";
							
							
							  $rzcs=$conn->query($qzcs);
							 
							
							  
	}
	$quww="SELECT `product_id`, `qty` FROM `ti_sale_item` WHERE invoice_id='$invid1'";
	    $reww=$conn->query($quww);
	    $reww->setfetchmode(PDO::FETCH_ASSOC);
	while($aww=$reww->fetch())
	{
		$pid=$aww['product_id'];
		$pqty=$aww['qty'];
		$qr="UPDATE `ti_product` SET `item_stock`=item_stock+'$pqty' WHERE id='$pid'";
		$pro=$conn->query($qr);
		
	$que="UPDATE `ti_sale_invoice` SET `IsActive`=0  WHERE invoice_id='$invid1'";
		$del=$conn->query($que);
		$queq="UPDATE `ti_sale_item` SET `IsActive`=0  WHERE invoice_id ='$invid1'";
		$del=$conn->query($queq);
	$queq="UPDATE `ti_tax` SET `IsActive`=0  WHERE inv_id ='$invid1'";
		$del=$conn->query($queq);
			
		//STOCK PART
			$qq="select ti_product.item_stock from ti_product  where ti_product.id='$pid' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
								    $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$pid'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock+$pqty;
             	//if product not exists
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_in`, `qty_stock`, `isActive`) VALUES 
						('$date1','$pid','$pqty','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						//if product  exists
						else{
						
							//checking date exists
							$check1="select count(id) as count from ti_stock where p_id='$pid' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							//if not exists
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out-'$pqty' , qty_stock=qty_stock+'$pqty' where p_id='$pid' and
								 transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$pqty' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								//if exists
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock
									 where p_id='$pid'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
							//checking date is max 
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$pid' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$pid' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm+$pqty;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$pid','$pqty','','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										//checking date is min
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$pid' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock+$pqty;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$pid','$pqty','','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
										
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$pqty' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											//checking date in between
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$pid' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$pid' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm+$pqty;
									
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$pid','$pqty','','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$pqty' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}
							//STOCK PART
		

		
}

$params= array();
$params[':invoice_id'] = $invno;
$params[':isactive'] = 0;
$query_payments_in = "UPDATE ti_payments_in SET IsActive=:isactive WHERE invoice_id=:invoice_id";
$stmt= $conn->prepare($query_payments_in);
$stmt->execute($params);
$query_payments_out = "UPDATE ti_payments_out SET IsActive=:isactive WHERE invoice_id=:invoice_id";
$stmt= $conn->prepare($query_payments_out);
$stmt->execute($params);
}
else {
		$_SESSION['i']='101';
$_SESSION['status']= "Invoice cannot be deleted";
		  header('Location: ' . $_SERVER['HTTP_REFERER']);
		  exit();
		}
$_SESSION['did']=1;
			
header('Location:../pages/saleinvoice.php');
}
