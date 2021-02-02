<?php 

include("../include/include.php"); 
$inv_num=isset($_POST['inv_id']) ? $_POST['inv_id']:'';
$q1="select ti_purchase_invoice.supplier_id from ti_purchase_invoice where ti_purchase_invoice.invoice_id='$inv_num'";
$stmt1=$conn->query($q1);$stmt1->setfetchmode(PDO::FETCH_ASSOC); $s11=$stmt1->fetch();
$supplier_id=$s11['supplier_id'];
if(isset($_POST['cash'])){
		$date=isset($_POST['date']) ? $_POST['date']:'';
	    $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
		$re_qty=isset($_POST['qty1']) ? $_POST['qty1']:'';
		$rate1=isset($_POST['totamt1']) ? $_POST['totamt1']:'';
		$rate=isset($_POST['amttot']) ? $_POST['amttot']:'';
		$nwcgst=isset($_POST['cgsttot']) ? $_POST['cgsttot']:'';
		$nwsgst=isset($_POST['sgsttot']) ? $_POST['sgsttot']:'';
		$time=$show_date;
			
		$qe1e="UPDATE `ti_purchase_invoice` SET `has_return`=1  WHERE `invoice_id`='$inv_num'";
		$eqeq=$conn->query($qe1e);
		$q1="SELECT count(ti_purchase_return.id)  as number FROM `ti_purchase_return` left join ti_purchase_invoice on 
		ti_purchase_return.invoice_id=ti_purchase_invoice.invoice_id WHERE ti_purchase_invoice.invoice_id='$inv_num'";
	
$r1=$conn->query($q1);
$r1->setfetchmode(PDO::FETCH_ASSOC);
$rc=$r1->fetch();
$number=$rc['number'];

//FULLY RETURN
if($number<=0){

			$q="INSERT INTO `ti_purchase_return`( `invoice_id`, `ret_date`, `ret_amt`,`ret_cgst_amt`, `ret_sgst_amt`, `pay_mode`, `IsHidden`, `IsActive`) VALUES
			('$inv_num','$time','$rate','$nwcgst','$nwsgst',10,'',1)";
			$stmt=$conn->query($q); $sale_ret=$conn->lastInsertId();
		
			$sale_inv="UPDATE `ti_purchase_invoice` SET `amt`= `amt`-'$rate',`cgst_amt`=cgst_amt-'$nwcgst',`sgst_amt`=sgst_amt-'$nwsgst' WHERE invoice_id='$inv_num'";
			$saleinvs=$conn->query($sale_inv);



			
						
				
		if($sale_ret>0){
	$query='INSERT INTO `ti_purchase_return_item`(`return_inv_id`, `product_id`, `ret_qty`, `IsActive`) VALUES';
	$append_query='';
	if(isset($_POST['dispatch_qty']) && count($_POST['dispatch_qty'])>0) {
		$model=isset($_POST['prodname']) ? $_POST['prodname']:'';

		$sqft=isset($_POST['dispatch_qty']) ? $_POST['dispatch_qty']:'';

			$i=0; $j=0;
$cgstpercent=isset($_POST['cgst']) ? $_POST['cgst']:'';
$sgstpercent=isset($_POST['sgst']) ? $_POST['sgst']:'';
$cgstamt=isset($_POST['changecgst']) ? $_POST['changecgst']:'';
$sgstamt=isset($_POST['changesgst']) ? $_POST['changesgst']:'';
$grossamt=isset($_POST['grossamt']) ? $_POST['grossamt']:'';
foreach($_POST['dispatch_qty'] as $row) {
$model=$_POST['proid'][$i];$purid=$_POST['purid'][$i];
$sqft=$_POST['dispatch_qty'][$i];
$cgstpercent=$_POST['cgst'][$i];
$sgstpercent=$_POST['sgst'][$i];
$cgstamt=$_POST['changecgst'][$i];
$sgstamt=$_POST['changesgst'][$i];
$grossamt=$_POST['grossamt'][$i];





if($sqft !=0 && $sqft !='' && $sqft !='0') {
		$append_query .="('$sale_ret','$model','$sqft',1),"; 
		
		
										$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$sale_ret'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
                      
                        
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
					
						$item_stock=$aq13['item_stock'];
						//stock part
					 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$model'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$sqft;
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$model','$sqft','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='$model' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out+'$sqft' ,qty_stock=qty_stock-'$sqft' where p_id='$model' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$model'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
									
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$model' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock-$sqft;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$model','','$sqft','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
							
							
							
							}
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$model'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
								
					}
					
				
				}
				//isactive part
				
		
				
				
				
				
				
				//isactive part
				$i++;
		}
		 if($append_query !='') {
		$query .=rtrim($append_query,',');
		$conn->query($query);
	}
			$newsele="select ti_purchase_return.invoice_id,ti_purchase_return_item.return_inv_id,ti_purchase_return_item.product_id,ti_purchase_return_item.ret_qty 
from ti_purchase_return left join ti_purchase_return_item 
				on ti_purchase_return.id=ti_purchase_return_item.return_inv_id where ti_purchase_return.invoice_id='$inv_num'";
		
				$consel=$conn->query($newsele);
				while($selsel=$consel->fetch()){
					$selinv=$selsel['invoice_id'];
					$selretqty=$selsel['ret_qty'];
					$selpro=$selsel['product_id'];
					$newsel1="select ti_purchse_items.id as sale_id ,ti_purchse_items.qty from ti_purchse_items where ti_purchse_items.product_id='$selpro' 
					and ti_purchse_items.inv_id='$inv_num'";
					
					
					$consel1=$conn->query($newsel1);
					while($selsel1=$consel1->fetch()){
						$saleidpro=$selsel1['sale_id'];
						$saleidqty=$selsel1['qty'];
						
						if($saleidqty==$selretqty){
							$updsale="update ti_purchse_items set IsActive=0 where id='$saleidpro'";
							$conupsa=$conn->query($updsale);
							
							}
						
						}
					}
					$sale1="SELECT count(id) as id FROM ti_purchse_items where inv_id='$inv_num' and IsActive=1";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$saler1=$conn->query($sale1);
			$saler1->setfetchmode(PDO::FETCH_ASSOC);
			
					$sale2=$saler1->fetch();
					$isact=$sale2['id'];
					if($isact==0)
					{
				$qe1e1="UPDATE `ti_purchase_invoice` SET `IsActive`=0  WHERE `invoice_id`='$inv_num'";
			$eqeq1=$conn->query($qe1e1);
		}
				
			
	}
	
	}
}
//PARTIAL RETURN
else{
	
			$q="UPDATE `ti_purchase_return` SET `ret_date`='$time',`ret_amt`=ret_amt+'$rate',`ret_cgst_amt`=ret_cgst_amt+'$nwcgst',
			`ret_sgst_amt`=ret_sgst_amt+'$nwsgst'  WHERE`invoice_id` ='$inv_num'";
			
			$stmt=$conn->query($q); 
			$sel="SELECT  `id` FROM `ti_purchase_return` WHERE `invoice_id`='$inv_num'";
			$del=$conn->query($sel);
			$del->setfetchmode(PDO::FETCH_ASSOC);
			$pel=$del->fetch();
			$sale_ret=$pel['id'];
			
			
			
			$q1="select ti_purchase_invoice.supplier_id from ti_purchase_invoice where ti_purchase_invoice.invoice_id='$inv_num'";
			$stmt1=$conn->query($q1);$stmt1->setfetchmode(PDO::FETCH_ASSOC); $s11=$stmt1->fetch();
			$supplier_id=$s11['supplier_id'];
			
			
		if($sale_ret>0){	
	$q23="SELECT ti_purchase_return_item.return_inv_id as xnum FROM `ti_purchase_return_item` left join ti_purchase_return 
	on ti_purchase_return_item.return_inv_id=ti_purchase_return.id left join ti_purchase_invoice on ti_purchase_return.invoice_id=ti_purchase_invoice.invoice_id
			where  ti_purchase_invoice.invoice_id='$sale_ret'";
			$qc3=$conn->query($q23);
			$qc3->setfetchmode(PDO::FETCH_ASSOC);
			
					$rcc3=$qc3->fetch();
			$xnum=$rcc3['xnum'];
			$sale_inv1="UPDATE `ti_purchase_invoice` SET `amt`= `amt`-'$rate',`cgst_amt`=cgst_amt-'$nwcgst',`sgst_amt`=sgst_amt-'$nwsgst' WHERE invoice_id='$inv_num'";
						$saleinvs1=$conn->query($sale_inv1);
			if(isset($_POST['dispatch_qty']) && count($_POST['dispatch_qty'])>0) {
			$model=isset($_POST['prodname']) ? $_POST['prodname']:'';
			$sqft=isset($_POST['dispatch_qty']) ? $_POST['dispatch_qty']:'';
			for($i=0;$i<count($_POST['dispatch_qty']);$i++) {
				$model=$_POST['proid'][$i];$purid=$_POST['purid'][$i];
				$sqft=$_POST['dispatch_qty'][$i];
				
				if($sqft !=0 && $sqft !='' && $sqft !='0') {
					$sq="SELECT count(product_id) as nm1 FROM `ti_purchase_return_item` WHERE product_id='$model' and return_inv_id='$sale_ret'";
					$qs=$conn->query($sq);
					$qs->setfetchmode(PDO::FETCH_ASSOC);
					$qs1=$qs->fetch();
					$nm1=$qs1['nm1'];
					
					
					if($nm1>0){
					$update="UPDATE `ti_purchase_return_item` SET `ret_qty`=ret_qty+'$sqft' WHERE  `product_id`='$model' and return_inv_id='$sale_ret'";
					$up=$conn->query($update);
					
				} else {
					$query="INSERT INTO `ti_purchase_return_item`( `return_inv_id`, `product_id`, `ret_qty`, `IsActive`) VALUES
	('$sale_ret','$model','$sqft',1)";
					
					
	
	$conn->query($query);

			
			
		}
		
		$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$sale_ret'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
                      
                        
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
			//STOCK PART
								 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$model'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$sqft;
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$model','$sqft','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='$model' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out+'$sqft' ,qty_stock=qty_stock-'$sqft' where p_id='$model' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$model'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
									
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$model' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock-$sqft;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$model','','$sqft','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
									
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
								}//STOCK PART
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$model'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
						
								
					}
					}
//isactive part
				$newsele="select ti_purchase_return.invoice_id,ti_purchase_return_item.return_inv_id,ti_purchase_return_item.product_id,ti_purchase_return_item.ret_qty 
from ti_purchase_return left join ti_purchase_return_item 
				on ti_purchase_return.id=ti_purchase_return_item.return_inv_id where ti_purchase_return.invoice_id='$inv_num'";
				
				$consel=$conn->query($newsele);
				while($selsel=$consel->fetch()){
					$selinv=$selsel['invoice_id'];
					$selretqty=$selsel['ret_qty'];
					$selpro=$selsel['product_id'];
					$newsel1="select ti_purchse_items.id as sale_id ,ti_purchse_items.qty from ti_purchse_items where ti_purchse_items.product_id='$selpro' 
					and ti_purchse_items.inv_id='$inv_num'";
					
					
					$consel1=$conn->query($newsel1);
					while($selsel1=$consel1->fetch()){
						$saleidpro=$selsel1['sale_id'];
						$saleidqty=$selsel1['qty'];
					
						if($saleidqty==$selretqty){
							$updsale="update ti_purchse_items set IsActive=0 where id='$saleidpro'";
							$conupsa=$conn->query($updsale);
							
							}
						
						}
					}
					$sale1="SELECT count(id) as id FROM ti_purchse_items where inv_id='$inv_num' and IsActive=1";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$saler1=$conn->query($sale1);
			$saler1->setfetchmode(PDO::FETCH_ASSOC);
			
					$sale2=$saler1->fetch();
					$isact=$sale2['id'];
					if($isact==0)
					{
				$qe1e1="UPDATE `ti_purchase_invoice` SET `IsActive`=0  WHERE `invoice_id`='$inv_num'";
			$eqeq1=$conn->query($qe1e1);
		}	
						
					
			//isactive part		
				}}}
		

	}
	$params= array();
	$params[':date'] = $time;
	$params[':cid'] = $supplier_id;
	$params[':party_type'] = 2;
	$params[':purpose_code'] =2;
	$params[':invoice_id'] = $sale_ret;
	$params[':amt'] = $rate;
	$params[':isactive'] = 1;
	
	$query_payments_in = "INSERT INTO `ti_payments_in`(`pay_date`,`from_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
	$stmt= $conn->prepare($query_payments_in);
	$stmt->execute($params);
	$query_payments_out = "INSERT INTO `ti_payments_out`(`pay_date`,`to_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
	$stmt= $conn->prepare($query_payments_out);
	$stmt->execute($params);
	
	$_SESSION['i']=1;   
	header('Location: ' . $_SERVER['HTTP_REFERER']);	
	}
	//CREDIT PART		
	if(isset($_POST['credit'])){
			$inv_num=isset($_POST['inv_id']) ? $_POST['inv_id']:'';
		
		$date=isset($_POST['date']) ? $_POST['date']:'';
	    $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
			$re_qty=isset($_POST['qty1']) ? $_POST['qty1']:'';
			$rate1=isset($_POST['totamt1']) ? $_POST['totamt1']:'';
			$rate=isset($_POST['amttot']) ? $_POST['amttot']:'';
			$nwcgst=isset($_POST['cgsttot']) ? $_POST['cgsttot']:'';
			$nwsgst=isset($_POST['sgsttot']) ? $_POST['sgsttot']:'';
			$time=date('Y-m-d H:i:s');
			
			$q1="SELECT count(ti_purchase_return.id)  as number FROM `ti_purchase_return` left join ti_purchase_invoice on 
			ti_purchase_return.invoice_id=ti_purchase_invoice.invoice_id WHERE ti_purchase_invoice.invoice_id='$inv_num'";
			
	$qe1e="UPDATE `ti_purchase_invoice` SET `has_return`=1  WHERE `invoice_id`='$inv_num'";
			$eqeq=$conn->query($qe1e);
$r1=$conn->query($q1);
		$r1->setfetchmode(PDO::FETCH_ASSOC);
		$rc=$r1->fetch();
$number=$rc['number'];

//FULLY RETURN
if($number<=0){
	
			$q="INSERT INTO `ti_purchase_return`( `invoice_id`, `ret_date`, `ret_amt`,`ret_cgst_amt`, `ret_sgst_amt`, `pay_mode`, `IsHidden`, `IsActive`) VALUES
			('$inv_num','$time','$rate','$nwcgst','$nwsgst',11,'',1)";
			$stmt=$conn->query($q); $sale_ret=$conn->lastInsertId();
		
			$q1="select ti_purchase_invoice.supplier_id from ti_purchase_invoice where ti_purchase_invoice.invoice_id='$inv_num' and ti_purchase_invoice.supplier_id>1";
			$stmt1=$conn->query($q1);$stmt1->setfetchmode(PDO::FETCH_ASSOC); $s11=$stmt1->fetch();
			$supplier_id=$s11['supplier_id'];
			$update11="UPDATE `ti_suppllier` set sup_balance=sup_balance-'".$rate."' where id='$supplier_id'";
			$up=$conn->query($update11);
			 $query1="INSERT INTO `ti_cash_book`(`payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`) 
VALUES(2,1,1,'$time','$supplier_id',4, '$sale_ret','$rate','',1)"; 

$r1=$conn->query($query1);
$a=$r1->setfetchmode(PDO::FETCH_ASSOC);
$sale_inv="UPDATE `ti_purchase_invoice` SET `amt`= `amt`-'$rate',`cgst_amt`=cgst_amt-'$nwcgst',`sgst_amt`=sgst_amt-'$nwsgst' WHERE invoice_id='$inv_num'";
						$saleinvs=$conn->query($sale_inv);
		if($sale_ret>0){
	$query='INSERT INTO `ti_purchase_return_item`(`return_inv_id`, `product_id`, `ret_qty`, `IsActive`) VALUES';
	$append_query='';
	if(isset($_POST['dispatch_qty']) && count($_POST['dispatch_qty'])>0) {
		$model=isset($_POST['prodname']) ? $_POST['prodname']:'';

		$sqft=isset($_POST['dispatch_qty']) ? $_POST['dispatch_qty']:'';

			$i=0; $j=0;
$cgstpercent=isset($_POST['cgst']) ? $_POST['cgst']:'';
$sgstpercent=isset($_POST['sgst']) ? $_POST['sgst']:'';
$cgstamt=isset($_POST['changecgst']) ? $_POST['changecgst']:'';
$sgstamt=isset($_POST['changesgst']) ? $_POST['changesgst']:'';
$grossamt=isset($_POST['grossamt']) ? $_POST['grossamt']:'';
foreach($_POST['dispatch_qty'] as $row) {
$model=$_POST['proid'][$i];$purid=$_POST['purid'][$i];
$sqft=$_POST['dispatch_qty'][$i];
$cgstpercent=$_POST['cgst'][$i];
$sgstpercent=$_POST['sgst'][$i];
$cgstamt=$_POST['changecgst'][$i];
$sgstamt=$_POST['changesgst'][$i];
$grossamt=$_POST['grossamt'][$i];





if($sqft !=0 && $sqft !='' && $sqft !='0') {
	$append_query .="('$sale_ret','$model','$sqft',1),"; 
									$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$sale_ret'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
                      
                        
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
		//STOCK PART
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
								 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$model'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$sqft;
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$model','$sqft','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='$model' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out+'$sqft' ,qty_stock=qty_stock-'$sqft' where p_id='$model' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$model'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
									
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$model' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock-$sqft;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$model','','$sqft','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										}
											}
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
								}//STOCK PART
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$model'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
								
					}
							
				
				}
			
				
				//isactive part
				$i++;
				
		}
		 
	if($append_query !='') {
		$query .=rtrim($append_query,',');
		$conn->query($query);
	}
			//isactive part
				$newsele="select ti_purchase_return.invoice_id,ti_purchase_return_item.return_inv_id,ti_purchase_return_item.product_id,ti_purchase_return_item.ret_qty 
from ti_purchase_return left join ti_purchase_return_item 
				on ti_purchase_return.id=ti_purchase_return_item.return_inv_id where ti_purchase_return.invoice_id='$inv_num'";
				
				$consel=$conn->query($newsele);
				while($selsel=$consel->fetch()){
					$selinv=$selsel['invoice_id'];
					$selretqty=$selsel['ret_qty'];
					$selpro=$selsel['product_id'];
					$newsel1="select ti_purchse_items.id as sale_id ,ti_purchse_items.qty from ti_purchse_items where ti_purchse_items.product_id='$selpro' 
					and ti_purchse_items.inv_id='$inv_num'";
				
					
					$consel1=$conn->query($newsel1);
					while($selsel1=$consel1->fetch()){
						$saleidpro=$selsel1['sale_id'];
						$saleidqty=$selsel1['qty'];
						
						if($saleidqty==$selretqty){
							$updsale="update ti_purchse_items set IsActive=0 where id='$saleidpro'";
							$conupsa=$conn->query($updsale);
							
							}
						
						}
					}
					$sale1="SELECT count(id) as id FROM ti_purchse_items where inv_id='$inv_num' and IsActive=1";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$saler1=$conn->query($sale1);
			$saler1->setfetchmode(PDO::FETCH_ASSOC);
			
					$sale2=$saler1->fetch();
					$isact=$sale2['id'];
					if($isact==0)
					{
				$qe1e1="UPDATE `ti_purchase_invoice` SET `IsActive`=0  WHERE `invoice_id`='$inv_num'";
			$eqeq1=$conn->query($qe1e1);
		}
				
	$_SESSION['i']=1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	}
}

//PARTIAL RETURN
else{
	
			$q="UPDATE `ti_purchase_return` SET `ret_date`='$time',`ret_amt`=ret_amt+'$rate',`ret_cgst_amt`=ret_cgst_amt+'$nwcgst',
			`ret_sgst_amt`=ret_sgst_amt+'$nwsgst'  WHERE`invoice_id` ='$inv_num'";
			
			$stmt=$conn->query($q); 
			$sel="SELECT  `id` FROM `ti_purchase_return` WHERE `invoice_id`='$inv_num'";
			$del=$conn->query($sel);
			$del->setfetchmode(PDO::FETCH_ASSOC);
			$pel=$del->fetch();
			$sale_ret=$pel['id'];
		
		
			
			$q1="select ti_purchase_invoice.supplier_id from ti_purchase_invoice where ti_purchase_invoice.invoice_id='$inv_num' and ti_purchase_invoice.supplier_id>1";
			$stmt1=$conn->query($q1);$stmt1->setfetchmode(PDO::FETCH_ASSOC); $s11=$stmt1->fetch();
			$supplier_id=$s11['supplier_id'];
			$update11="UPDATE `ti_suppllier` set sup_balance=sup_balance-'".$rate."' where id='$supplier_id'";
			$up=$conn->query($update11);
			 $query1="INSERT INTO `ti_cash_book`(`payment_type`, `person_type`, `pay_mode`, `date`, `person_id`, `invoice_type`, `invoice_id`, `pay_amt`, `pay_reference`, `isActive`) 
VALUES(2,1,1,'$time','$supplier_id',4, '$sale_ret','$rate','',1)"; 

$r1=$conn->query($query1);
$a=$r1->setfetchmode(PDO::FETCH_ASSOC);
		if($sale_ret>0){	
	$q23="SELECT ti_purchase_return_item.return_inv_id as xnum FROM `ti_purchase_return_item` left join ti_purchase_return 
	on ti_purchase_return_item.return_inv_id=ti_purchase_return.id left join ti_purchase_invoice on ti_purchase_return.invoice_id=ti_purchase_invoice.invoice_id
			where  ti_purchase_invoice.invoice_id='$sale_ret'";
			$qc3=$conn->query($q23);
			$qc3->setfetchmode(PDO::FETCH_ASSOC);
			
					$rcc3=$qc3->fetch();
			$xnum=$rcc3['xnum'];
			$sale_inv1="UPDATE `ti_purchase_invoice` SET `amt`= `amt`-'$rate',`cgst_amt`=cgst_amt-'$nwcgst',`sgst_amt`=sgst_amt-'$nwsgst' WHERE invoice_id='$inv_num'";
						$saleinvs1=$conn->query($sale_inv1);
			if(isset($_POST['dispatch_qty']) && count($_POST['dispatch_qty'])>0) {
			$model=isset($_POST['prodname']) ? $_POST['prodname']:'';
			$sqft=isset($_POST['dispatch_qty']) ? $_POST['dispatch_qty']:'';
			for($i=0;$i<count($_POST['dispatch_qty']);$i++) {
				$model=$_POST['proid'][$i];$purid=$_POST['purid'][$i];
				$sqft=$_POST['dispatch_qty'][$i];
				
				if($sqft !=0 && $sqft !='' && $sqft !='0') {
					$sq="SELECT count(product_id) as nm1 FROM `ti_purchase_return_item` WHERE product_id='$model' and return_inv_id='$sale_ret'";
					$qs=$conn->query($sq);
					$qs->setfetchmode(PDO::FETCH_ASSOC);
					$qs1=$qs->fetch();
					$nm1=$qs1['nm1'];
					
					
					if($nm1>0){
					$update="UPDATE `ti_purchase_return_item` SET `ret_qty`=ret_qty+'$sqft' WHERE  `product_id`='$model' and return_inv_id='$sale_ret'";
					$up=$conn->query($update);
					
				} else {
					$query="INSERT INTO `ti_purchase_return_item`( `return_inv_id`, `product_id`, `ret_qty`, `IsActive`) VALUES
	('$sale_ret','$model','$sqft',1)";
					
					
	
	$conn->query($query);

			
		}
		
		$q1="SELECT date(`pur_date`) as date1 from ti_purchase_invoice  where invoice_id='$sale_ret'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
                      
                        
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
						    //stock part
						$qq="select ti_product.item_stock from ti_product  where ti_product.id='$model' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						
						$item_stock=$aq13['item_stock'];
								 $q12="SELECT count(id) as num FROM `ti_stock` where p_id='$model'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        $stock=$item_stock-$sqft;
                    if($num1==0){
						
						
						$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$model','$sqft','$stock',1)";
								$rz1=$conn->query($qz1);
						}
						else{
						
							
							$check1="select count(id) as count from ti_stock where p_id='$model' and transaction_date='$date1'";
							$ckcon=$conn->query($check1);
							$ckcon->setfetchmode(PDO::FETCH_ASSOC);
							$kcconn=$ckcon->fetch();
							$count=$kcconn['count'];
							if($count!=0){
								
								$up="update ti_stock set qty_out=qty_out+'$sqft' ,qty_stock=qty_stock-'$sqft' where p_id='$model' and transaction_date='$date1'";
								$pu=$conn->query($up);
									$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
								}
								else {
									
									$semd="select max(transaction_date) as maxdate , min(transaction_date) as mindate from ti_stock where p_id='$model'";
									$smd1=$conn->query($semd);
									$smd1->setfetchmode(PDO::FETCH_ASSOC);
									$tmd=$smd1->fetch();
									$maxdate=$tmd['maxdate'];
									$mindate=$tmd['mindate'];
									
									
									if($date1>$maxdate){
										
										$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
										$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
										
										}
										else if($date1<$mindate){
											
											$selto="select qty_in,qty_out,qty_stock from ti_stock where p_id='$model' and transaction_date='$mindate'";
											$conto=$conn->query($selto);
											$conto->setfetchmode(PDO::FETCH_ASSOC);
											$snto=$conto->fetch();
											$qty_in=$snto['qty_in'];
											$qty_out=$snto['qty_out'];
											$qty_stock=$snto['qty_stock'];
											$new_con=$qty_stock-$qty_in;
											$new_stock=$new_con+$qty_out;
											$this_stock=$new_stock-$sqft;
											$insert="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
											('$date1','$model','','$sqft','$this_stock',1)";
											$tm=$conn->query($insert);
											
										
											$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											
											
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										
										
										}
											}
											else if($date1>$mindate && $date1<$maxdate){
												$selimm="SELECT max(transaction_date) as maxtransdate FROM `ti_stock` WHERE p_id='$model' and transaction_date <'$date1'";
										$coim=$conn->query($selimm);
										$coim->setfetchmode(PDO::FETCH_ASSOC);
										$ssim=$coim->fetch();
										$maxtrans=$ssim['maxtransdate'];
												$selim2="select qty_stock from ti_stock where p_id='$model' and transaction_date='$maxtrans'";
										$coim2=$conn->query($selim2);
										$coim2->setfetchmode(PDO::FETCH_ASSOC);
										$ssim2=$coim2->fetch();
										$stockimm=$ssim2['qty_stock'];
										$ststock=$stockimm-$sqft;
										
										$indate="INSERT INTO `ti_stock`( `transaction_date`, `p_id`, `qty_in`, `qty_out`, `qty_stock`, `isActive`) VALUES
										('$date1','$model','','$sqft','$ststock',1)";
										$cndate=$conn->query($indate);
													$sel="select id from ti_stock where p_id='$model' and transaction_date>'$date1'";
											$selconn=$conn->query($sel);
											$selconn->setfetchmode(PDO::FETCH_ASSOC);
											while($tel=$selconn->fetch()){
												$tlid=$tel['id'];
											$upsel="update ti_stock set qty_stock=qty_stock-'$sqft' where id='$tlid' ";
										$selup=$conn->query($upsel);
										}
												
												}
									
									}
								}
								$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$model'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
								
					}
					}
						//isactive part
							 $newsele="select ti_purchase_return.invoice_id,ti_purchase_return_item.return_inv_id,ti_purchase_return_item.product_id,ti_purchase_return_item.ret_qty 
from ti_purchase_return left join ti_purchase_return_item 
				on ti_purchase_return.id=ti_purchase_return_item.return_inv_id where ti_purchase_return.invoice_id='$inv_num'";
				
			
				$consel=$conn->query($newsele);
				while($selsel=$consel->fetch()){
					$selinv=$selsel['invoice_id'];
					$selretqty=$selsel['ret_qty'];
					$selpro=$selsel['product_id'];
					$newsel1="select ti_purchse_items.id as sale_id ,ti_purchse_items.qty from ti_purchse_items where ti_purchse_items.product_id='$selpro' 
					and ti_purchse_items.inv_id='$inv_num'";
				
					
					$consel1=$conn->query($newsel1);
					while($selsel1=$consel1->fetch()){
						$saleidpro=$selsel1['sale_id'];
						$saleidqty=$selsel1['qty'];
						
						if($saleidqty==$selretqty){
							$updsale="update ti_purchse_items set IsActive=0 where id='$saleidpro'";
							$conupsa=$conn->query($updsale);
							
							}
						
						}
					}
					$sale1="SELECT count(id) as id FROM ti_purchse_items where inv_id='$inv_num' and IsActive=1";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$saler1=$conn->query($sale1);
			$saler1->setfetchmode(PDO::FETCH_ASSOC);
			
					$sale2=$saler1->fetch();
					$isact=$sale2['id'];
					if($isact==0)
					{
				$qe1e1="UPDATE `ti_purchase_invoice` SET `IsActive`=0  WHERE `invoice_id`='$inv_num'";
			$eqeq1=$conn->query($qe1e1);
		}  
							   
							   
					
					
					 //isactive part
				
					
				}}}
		

	}
	
	$params= array();
	$params[':date'] = $time;
	$params[':cid'] = $supplier_id;
	$params[':party_type'] = 2;
	$params[':purpose_code'] =2;
	$params[':invoice_id'] = $sale_ret;
	$params[':amt'] = 0;
	$params[':isactive'] = 1;
	
	$query_payments_in = "INSERT INTO `ti_payments_in`(`pay_date`,`from_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
	$stmt= $conn->prepare($query_payments_in);
	$stmt->execute($params);
	$params[':amt'] = $rate;
	$query_payments_out = "INSERT INTO `ti_payments_out`(`pay_date`,`to_id`,`party_type`,`purpose_code`,`invoice_id`,`amt`,`IsActive`) VALUES (:date,:cid,:party_type,:purpose_code,:invoice_id,:amt,:isactive)";
	$stmt= $conn->prepare($query_payments_out);
	$stmt->execute($params);
	
	$_SESSION['i']=1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	?>
	
