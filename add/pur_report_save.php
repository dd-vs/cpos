<?php 

	include("../include/include.php"); 
	if(isset($_POST['submit']))
	{
	   
	    $query="select *,max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	    $date=isset($_POST['date']) ? $_POST['date']:'';
	    $invid=isset($_POST['invid']) ? $_POST['invid']:'';
	    //~ $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
	     $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'10';
	    $supplier=isset($_POST['supplier']) ? $_POST['supplier']:'';
	    $sup_id=isset($_POST['sup_id']) ? $_POST['sup_id']:'';
	
	$sumadx=0;
	    $hidden=isset($_POST['hidden']) ? $_POST['hidden']:'10';
$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';
$amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
$discount=isset($_POST['discount']) ? $_POST['discount']:'';
$fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
$time=date('Y-m-d');
$time1=date('Y-m-d H:i:s');
	 
	if (trim($amtpart) !='') {
		$params= array();
		$params[':invoice_id'] = $invid;
		$params[':amt'] = $amtpart;
		if ($cash_credit == 11) {
			$query_payments_out = "UPDATE ti_payments_in SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_out);
			$stmt->execute($params);
		} else if ($cash_credit ==10) {
			$query_payments_in = "UPDATE ti_payments_in SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_in);
			$stmt->execute($params);
			$query_payments_out = "UPDATE ti_payments_out SET amt=:amt WHERE invoice_id=:invoice_id";
			$stmt= $conn->prepare($query_payments_out);
			$stmt->execute($params);
		}
	}	
    			$query='INSERT INTO `ti_purchse_items`( `inv_id`, `product_id`, `qty`, `buy_price`,`cgst_percent`,`sgst_percent`, `IsActive`) VALUES ';
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
$cgst=$_POST['cgst'][$i];
$sgst=$_POST['sgst'][$i];
//~ $cgst=$_POST['cgst'][$i];
$totalcs=$cgst+$sgst;
$cgstamt=$_POST['cgstamt'][$i];
$sgst=$_POST['sgst'][$i];
$sgstamt=$_POST['sgstamt'][$i];

$adx=$rate*$sqft;
$sumadx+=$adx;

$aw=$adx*$totalcs;
$az=100+$totalcs;
$nw=round($aw,2)/round($az,2);
$gross=$adx-$nw;
$grossamt=round($gross,2);

$taxamt1=$grossamt*$cgst;
$tabletaxamt2=$taxamt1/100;
$taxamt12=$grossamt*$sgst;
$tabletaxamt21=$taxamt12/100;


$qu="UPDATE `ti_purchase_invoice` set `amt`='$amtpart' ,`roundOff`='$fraction',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst' where invoice_id='$invid'";
			$r5=$conn->query($qu);
					if($cash_credit==11){
		
		
	$qzcust="UPDATE `ti_suppllier` SET `sup_balance`=`sup_balance`+'$sumadx' WHERE  id='$sup_id'";
							
							
							  $rzcust=$conn->query($qzcust);
							  
							   
							
	}
	
					
						$q="select ti_product.id,ti_product.item_stock from ti_product  where ti_product.name='$iparr[0]' ";
						$r12=$conn->query($q);
					
						$a12=$r12->setfetchmode(PDO::FETCH_ASSOC);
						$a13=$r12->fetch();
					
						$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$invid'";
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
						
						 $qq="select ti_product.item_stock from ti_product  where ti_product.id='$id' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
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
								
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$id'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
									
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
										$ststock=$stockimm+$rate;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$id','$rate','','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
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
											$this_stock=$new_stock+$rate;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$id','$rate','','$this_stock',1)";
											$tm=$conn->query($insert);
											
											$sel="select id from ti_stock where p_id='$id' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock+'$rate' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
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
										$ststock=$stockimm+$rate;
									
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
							
							
							
							}
								//STOCK PART
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$id'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
								
					}
						
						$append_query .="('$invid','$id','$rate','$sqft',$cgst,$sgst,1),";
				
				
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}
			}
			
			
					
	    
	    
			
	  $query='INSERT INTO `ti_purchse_items`( `inv_id`, `product_id`, `qty`, `buy_price`, `IsActive`) VALUES ';
			$append_query='';
			$pt=0;
			$tab=0;
			$tab1=0;
	    if(isset($_POST['saleproid']) && count($_POST['saleproid']) >0) {
				$i=0; $j=0;
				foreach($_POST['saleproid'] as $row) {
$ip=$_POST['saleproid'][$i];
$id=$_POST['proid'][$i];
$j=print_r($ip,true);
$iparr = preg_split ("/-/", $j); 
$sqft=$_POST['salerate'][$i];
$_SESSION['rate']=$sqft;
$rate=$_POST['saleqty'][$i];
$_SESSION['qty']=$rate; 
$idpro=$_POST['id'][$i];
$_SESSION['isw']=$idpro;
$purchaseid=$_POST['purchaseid'][$i];
$_SESSION['purchaseid']=$purchaseid;

$cgst=$_POST['salecgst'][$i];
$sgst=$_POST['salesgst'][$i];

$totalcs=$cgst+$sgst;

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
$taxamt12=$grossamt*$_SESSION['sgst'];
$tabletaxamt21=$taxamt12/100;
$tab1+=$tabletaxamt21;


					
						
						$quq="SELECT *,date(pur_date) as purdate FROM `ti_purchase_invoice` WHERE `invoice_id`='$invid' ";
	    $req=$conn->query($quq);
	    
	    $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
	$aeq2q=$req->fetch();
	$invid1=$aeq2q['invoice_id'];
	$invcreditq=$aeq2q['cash_credit'];
	$date1=$aeq2q['purdate'];
	
						
						$updatequery="UPDATE ti_purchse_items set IsActive=0 WHERE product_id='".$_SESSION['isw']."' and id='".$_SESSION['purchaseid']."' and inv_id='$invid'"; $conn->query($updatequery);
						
		
		
		$qrw123="UPDATE `ti_product` SET `item_stock`=item_stock-'".$_SESSION['qty']."' WHERE id='".$_SESSION['isw']."'";
		$prow123=$conn->query($qrw123);
		
		
		$qq="select ti_product.item_stock from ti_product  where ti_product.id='".$_SESSION['isw']."' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
						$item_stock=$aq13['item_stock'];
				//STOCK PART
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='".$_SESSION['isw']."' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
						$item_stock=$aq13['item_stock'];
						//stock part
					 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='".$_SESSION['isw']."'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$_SESSION['qty'];
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','".$_SESSION['isw']."','".$_SESSION['qty']."','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							if($count!=0){
								
								$up="update ti_stock set qty_in=qty_in-'".$_SESSION['qty']."' ,qty_stock=qty_stock-'".$_SESSION['qty']."' where p_id='".$_SESSION['isw']."' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='".$_SESSION['isw']."'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
								
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
										$ststock=$stockimm-$_SESSION['qty'];
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','".$_SESSION['isw']."','','".$_SESSION['qty']."','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
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
											$this_stock=$new_stock-$_SESSION['qty'];
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','".$_SESSION['isw']."','','".$_SESSION['qty']."','$this_stock',1)";
											$tm=$conn->query($insert);
										
										
											$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
									
										
										}
											}
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
										$ststock=$stockimm-$_SESSION['qty'];
									
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','".$_SESSION['isw']."','','".$_SESSION['qty']."','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='".$_SESSION['isw']."' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'".$_SESSION['qty']."' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}
		
		//STOCK PART
	$quw="SELECT `id` FROM `ti_suppllier` WHERE `id`='$sup_id' ";
	    $rew=$conn->query($quw);
	$aew=$rew->setfetchmode(PDO::FETCH_ASSOC);
	$ae2w=$rew->fetch();
	$ideqw=$ae2w['id'];
	$fraction=isset($_POST['fraction']) ? $_POST['fraction']:'';
$amtpart=isset($_POST['amtpart']) ? $_POST['amtpart']:'';
		$cgst12="UPDATE `ti_purchase_invoice` SET `cgst_amt`='$totcgst',`sgst_amt`='$totsgst',`amt`='$amtpart',`roundOff`='$fraction' WHERE `invoice_id`='$invid' ";
		$cgst34=$conn->query($cgst12);
		
		
	
	
	if($invcreditq==11){
		
		
	$qzcust="UPDATE `ti_suppllier` SET `sup_balance`=`sup_balance`-'$pt' WHERE `id`='$ideqw'";
							
							
							  $rzcust=$conn->query($qzcust);
							  
							   
							
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
			header('Location: ' . $_SERVER['HTTP_REFERER']);	    
	
}
if(isset($_POST['delete'])){
$invid1=isset($_POST['invid']) ? $_POST['invid']:'';
  $supplier=isset($_POST['supplier']) ? $_POST['supplier']:'';
  $sup_id=isset($_POST['sup_id']) ? $_POST['sup_id']:'';
  $amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';

  $time=date('Y-m-d');
  
$params= array();
$params[':invoice_id'] = $invid1;
$params[':isactive'] = 0;
$query_payments_in = "UPDATE ti_payments_in SET IsActive=:isactive WHERE invoice_id=:invoice_id";
$stmt= $conn->prepare($query_payments_in);
$stmt->execute($params);
$query_payments_out = "UPDATE ti_payments_out SET IsActive=:isactive WHERE invoice_id=:invoice_id";
$stmt= $conn->prepare($query_payments_out);
$stmt->execute($params);

  $saleinv="SELECT `cgst_amt`, `sgst_amt`,`amt` FROM `ti_purchase_invoice` WHERE invoice_id='$invid1'";
      $sale=$conn->query($saleinv);
      $sale->setfetchmode(PDO::FETCH_ASSOC);
      $sale_inv=$sale->fetch();
      $c1amt=$sale_inv['cgst_amt'];
      $s1amt=$sale_inv['sgst_amt'];
      $scamt=$sale_inv['amt'];
      $upsale="update ti_purchase_invoice set cgst_amt=cgst_amt-'$c1amt',sgst_amt=sgst_amt-'$s1amt',amt=amt-'$scamt' where invoice_id= '$invid1' ";
$upsale=$conn->query($upsale);
    $qu="SELECT `id` FROM `ti_suppllier` WHERE `id`='$sup_id' ";
      $re=$conn->query($qu);
$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
$ae2=$re->fetch();
$ide=$ae2['id'];
      $qq="SELECT `has_return` FROM `ti_purchase_invoice` WHERE `invoice_id`='$invid1'   ";
$rq12=$conn->query($qq);
$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
$aq13=$rq12->fetch();
$wq=$aq13['has_return'];

if($wq!=1)
{

      
$quq="SELECT *,date(pur_date) as purdate FROM `ti_purchase_invoice` WHERE `invoice_id`='$invid1' ";
      $req=$conn->query($quq);
      $aeq=$req->setfetchmode(PDO::FETCH_ASSOC);
$aeq2=$req->fetch();

$invcredit=$aeq2['cash_credit'];
$date1=$aeq2['purdate'];
if($invcredit==11){

$qzcs="UPDATE `ti_suppllier` SET `sup_balance`=`sup_balance`-'$scamt' WHERE `id`='$ide'";


  $rzcs=$conn->query($qzcs);
  

  
}
$quww="SELECT `product_id`, `qty` FROM `ti_purchse_items` WHERE inv_id='$invid1'";
      $reww=$conn->query($quww);
      $reww->setfetchmode(PDO::FETCH_ASSOC);
while($aww=$reww->fetch())
{
$pid=$aww['product_id'];
$pqty=$aww['qty'];
$qr="UPDATE `ti_product` SET `item_stock`=item_stock-'$pqty' WHERE id='$pid'";
$pro=$conn->query($qr);

$que="UPDATE `ti_purchase_invoice` SET `IsActive`=0   WHERE invoice_id ='$invid1'";
$del=$conn->query($que);

$queq="UPDATE `ti_purchse_items` SET `IsActive`=0   WHERE inv_id ='$invid1'";
$del=$conn->query($queq);

$qq="select ti_product.item_stock from ti_product   where ti_product.id='$pid' ";
$rq12=$conn->query($qq);
$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
$aq13=$rq12->fetch();

$item_stock=$aq13['item_stock'];
//stock part
$q12="SELECT count(id) as num FROM `ti_stock` where p_id='$pid'";
                                              $r12=$conn->query($q12);
                                              $r12->setfetchmode(PDO::FETCH_ASSOC);
                                              $s12=$r12->fetch();
                                              $num1=$s12['num'];
                                              $stock=$item_stock-$pqty;
                                      if($num1==0){


$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,   `qty_out`, `qty_stock`, `isActive`) VALUES 
('$date1','$pid','$pqty','$stock',1)";
$rz1=$conn->query($qz1);

}
else{


$check1="select count(id) as count from ti_stock where p_id='$pid' and transaction_date='$date1'";
$ckcon=$conn->query($check1);
$ckcon->setfetchmode(PDO::FETCH_ASSOC);
$kcconn=$ckcon->fetch();
$count=$kcconn['count'];
if($count!=0){

$up="update ti_stock set qty_in=qty_in-'$pqty' ,qty_stock=qty_stock-'$pqty' 
where p_id='$pid' and transaction_date='$date1'";
$pu=$conn->query($up);
$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
$selconn=$conn->query($sel);
$selconn->setfetchmode(PDO::FETCH_ASSOC);
while($tel=$selconn->fetch()){
$tlid=$tel['id'];
$upsel="update ti_stock set qty_stock=qty_stock-'$pqty' where id='$tlid' ";
$selup=$conn->query($upsel);
}
}
else {

$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock 
where p_id='$pid'";
$smd1=$conn->query($semd);
$smd1->setfetchmode(PDO::FETCH_ASSOC);
$tmd=$smd1->fetch();
$maxdate=$tmd['maxdate'];
$mindate=$tmd['mindate'];


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
$ststock=$stockimm-$pqty;
$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
('$date1','$pid','','$pqty','$ststock',1)";
$cndate=$conn->query($indate);

}
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
$this_stock=$new_stock-$pqty;
$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
('$date1','$pid','','$pqty','$this_stock',1)";
$tm=$conn->query($insert);


$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
$selconn=$conn->query($sel);
$selconn->setfetchmode(PDO::FETCH_ASSOC);


while($tel=$selconn->fetch()){
$tlid=$tel['id'];
$upsel="update ti_stock set qty_stock=qty_stock-'$pqty' where id='$tlid' ";
$selup=$conn->query($upsel);


}
}
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
$ststock=$stockimm-$pqty;

$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
('$date1','$pid','','$pqty','$ststock',1)";
$cndate=$conn->query($indate);
$sel="select id from ti_stock where p_id='$pid' and transaction_date>'$date1'";
$selconn=$conn->query($sel);
$selconn->setfetchmode(PDO::FETCH_ASSOC);
while($tel=$selconn->fetch()){
$tlid=$tel['id'];
$upsel="update ti_stock set qty_stock=qty_stock-'$pqty' where id='$tlid' ";
$selup=$conn->query($upsel);
}

}

}



}

//STOCK PART


}}
else {
$_SESSION['i']='101';
$_SESSION['status']= "Invoice cannot be deleted";
header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit();
}
$_SESSION['did']=1;

header("location:../pages/purchaseinvoice.php"); 
}
