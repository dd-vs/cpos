<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
	    //$in_id=isset($_POST['in_id']) ? $_POST['in_id']:'';

	    $date=isset($_POST['date']) ? $_POST['date']:'';
	    $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
	     $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'10';
	    $supplier=isset($_POST['customer']) ? $_POST['customer']:'';
	  
	    $hidden=isset($_POST['hidden']) ? $_POST['hidden']:'10';
$tottax=isset($_POST['tottax11']) ? $_POST['tottax11']:'';
$totamt=isset($_POST['totamt']) ? $_POST['totamt']:'';
$discount=isset($_POST['amount1']) ? $_POST['amount1']:'';
$selectsale=isset($_POST['selectsale']) ? $_POST['selectsale']:'';
if($selectsale==0){
		    $query="select *,max(ti_sale_invoice.invoice_num)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_type=0";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	}
else if($selectsale==1){
		    $query="select *,max(ti_sale_invoice.invoice_num)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_type=1";
$s1=$conn->query($query); $res1=$s1->fetch();
	    $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	}
//~ else if($selectsale==2){
		    //~ $query="select *,max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_type=2";
//~ $s1=$conn->query($query); $res1=$s1->fetch();
	    //~ $in_no=isset($res1['inv_no']) ? $res1['inv_no']:'1';
	//~ }

$time=$show_date;
	   //~ if($supplier==0)
	   //~ {
		   //~ $cash_credit='10';
		   //~ }
	//~ else{
	//~ $cash_credit=isset($_POST['cash_credit']) ? $_POST['cash_credit']:'';
//~ }
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
	//echo $lid;
	
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
			
			$query='INSERT INTO `ti_sale_item`( `invoice_id`, `product_id`, `qty`, `discount`,`sell_price`, `IsActive`) VALUES ';
			$append_query='';
			if(isset($_POST['proname1']) && count($_POST['proname1']) >0) {
				$i=0; $j=0;
				foreach($_POST['proname1'] as $row) {
$ip=$_POST['proname1'][$i];
$j=print_r($ip,true);
$iparr = preg_split ("/-/", $j); 
$sqft=$_POST['buyprice1'][$i];
$rate=$_POST['qty1'][$i]; 
//~ $tax=$_POST['tax1'][$i];
//~ $tax2=$_POST['tax2'][$i];
 $sum=$_POST['added1'][$i];
$dis=$_POST['disprice1'][$i];
$new=$sum/$rate;
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

  $querytax="INSERT INTO `ti_tax`( `inv_type`, `inv_id`,  `cgst_tax_percent`, `sgst_tax_percent`, `taxable_amt`, `ctax_amt`, `stax_amt`, `isActive`) VALUES 
('1','$lid','$cgst','$sgst','$grossamt','$tabletaxamt2','$tabletaxamt21','1')";
$tax=$conn->query($querytax);
$atax=$tax->setfetchmode(PDO::FETCH_ASSOC);
						$q="select ti_product.id,ti_product.item_stock from ti_product  where ti_product.name='$iparr[0]' ";

						$r12=$conn->query($q);
						$a12=$r12->setfetchmode(PDO::FETCH_ASSOC);
						$a13=$r12->fetch();
						$id=$a13['id'];
						//$item_stock=$a13['item_stock'];
                        $q1="SELECT date(`sale_date`) as date1 from ti_sale_invoice  where invoice_id='$lid'";
                        $r11=$conn->query($q1);
                        $r11->setfetchmode(PDO::FETCH_ASSOC);
                        while($s11=$r11->fetch()){
							$date1=$show_date;
							
							
							$qq="select ti_product.item_stock from ti_product  where ti_product.id='$id' ";
						$rq12=$conn->query($qq);
						$aq12=$rq12->setfetchmode(PDO::FETCH_ASSOC);
						$aq13=$rq12->fetch();
						//$qid=$aq13['id'];
						$item_stock=$aq13['item_stock'];
                        $q12="SELECT count(id) as num FROM `ti_stock` WHERE transaction_date='$date1' and p_id='$id'";
                        $r12=$conn->query($q12);
                        $r12->setfetchmode(PDO::FETCH_ASSOC);
                        $s12=$r12->fetch();
                        $num1=$s12['num'];
                        //~ echo $num1;
                        //~ exit;
                        $stock=$item_stock-$rate;
                        if($num1>0){
							$qq="select max(id) as ide from `ti_stock` WHERE transaction_date='$date1' and p_id='$id'";
							$co=$conn->query($qq);
							$co->setfetchmode(PDO::FETCH_ASSOC);
							$cp=$co->fetch();
							$ide=$cp['ide'];
							//echo $qq;
							$qz="UPDATE `ti_stock` SET `qty_stock`=`qty_stock`-'$rate',`qty_out`=`qty_out`+'$rate' WHERE `id`='$ide'";
							//echo $qz;
							
							  $rz=$conn->query($qz);
							}
							else
							{
								
								$qz1="INSERT INTO `ti_stock`( `transaction_date`, `p_id`,  `qty_out`, `qty_stock`, `isActive`) VALUES ('$date1','$id','$rate','$stock',1)";
								$rz1=$conn->query($qz1);
								
								}
					}
						$qu1="UPDATE `ti_product` SET `item_stock`='$stock' WHERE id='$id'";
						$r51=$conn->query($qu1);
						$a51=$r51->setfetchmode(PDO::FETCH_ASSOC);
						//~ $checkquery="select count(product_id) as count from ti_sale_item where invoice_id='$lid' and product_id='$id'";
						//~ $ckqu=$conn->query($checkquery);
						//~ $ckqu->setfetchmode(PDO::FETCH_ASSOC);
					//~ $kc=$ckqu->fetch();
					//~ $cont=$kc['count'];
					//~ if($cont>0){
						//~ $updte="update ti_sale_item set qty=qty+'$rate' where invoice_id='$lid' and product_id='$id'";
						//~ $dup=$conn->query($updte);
						
					//~ }else{
						//else
						$append_query .="('$lid','$id','$rate','$dis','$new',1),";
				//~ }
				
					//~ if(((int)$estatus==3) &&  ((int)$eitem_id) >0 ) {
						//~ //$updatequery="UPDATE enq_item_details set modify_status='$estatus' WHERE id='$eitem_id' "; $conn->query($updatequery);
					//~ }
					$i++;
				}
				
			
				if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
					//if alredy exiists
				}
			}
			

					
					$balance=isset($_POST['balance-amount']) ? $_POST['balance-amount']:'';
					$whole = floor($balance);      // 1
$fraction = $balance - $whole;
if($fraction>0.50){
	//echo $fraction;
	//~ $frac=explode('.',$fraction);
	//~ echo $frac;
	$dec=1-$fraction;
	
	$amtblnc=$balance+$dec;
				
$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';	
					$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					$amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
					
	//echo $amtblnc;
	$qu="UPDATE `ti_sale_invoice` set `amt`='$amtblnc',`roundOff`='$dec',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst' where invoice_id='$lid'";
			$r5=$conn->query($qu);
	}
	else
	{
		
		$amtblnc=$balance-$fraction;
					
$totsgst=isset($_POST['totsgst']) ? $_POST['totsgst']:'';	
					$totcgst=isset($_POST['totcgst']) ? $_POST['totcgst']:'';
					$amttotal=isset($_POST['amttotal']) ? $_POST['amttotal']:'';
					
		//echo $amtblnc;
		$qu="UPDATE `ti_sale_invoice` set `amt`='$amtblnc',`roundOff`=-'$fraction',`cgst_amt`= '$totcgst',`sgst_amt`= '$totsgst' where invoice_id='$lid'";
			$r5=$conn->query($qu);
		}
//exit;

			
			
			
			echo $cash_credit;
			echo $balance;
			if($cash_credit==11){
						$difference=isset($_POST['difference']) ? $_POST['difference']:'';
				  $qu="SELECT `id` FROM `ti_customer` WHERE `name`='$supplier' ";
	    $re=$conn->query($qu);
	$ae=$re->setfetchmode(PDO::FETCH_ASSOC);
	$ae2=$re->fetch();
	$ide11=isset($ae2['id']) ? $ae2['id']:'1';
	 
		$qqqqqq="UPDATE `ti_customer` SET `cus_balance`=cus_balance+'$difference' where id ='$ide11'";
		
		$qi=$conn->query($qqqqqq);
		echo $qqqqqq;
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
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
?>


