<?php 


	include("../include/include.php"); 
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
	  $cat=isset($_POST['catname']) ? $_POST['catname']:'';
	   $cat=test($cat);
	$proname=isset($_POST['proname']) ? $_POST['proname']:'';
	 $proname=test($proname);
	$description=isset($_POST['description']) ? $_POST['description']:'';
	$sku= isset($_POST['sku']) ? $_POST['sku']:'';
	$sku=test($sku);
	$stock=isset($_POST['stock']) ? $_POST['stock']:'';
	$buyprice=isset($_POST['buyprice']) ? $_POST['buyprice']:'';
	$hsn=isset($_POST['hsn']) ? $_POST['hsn']:'';
			$hsn=test($hsn);
	$sellingprice=isset($_POST['sellingprice']) ? $_POST['sellingprice']:'';
	$mrp=isset($_POST['mrp']) ? $_POST['mrp']:'';
	$unit=isset($_POST['unit']) ? $_POST['unit']:'';
	$tax1=isset($_POST['tax1']) ? $_POST['tax1']:'';$isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
		$tax2=isset($_POST['tax2']) ? $_POST['tax2']:'';
		$cgst1=isset($_POST['cgst']) ? $_POST['cgst']:'';$sgst1=isset($_POST['sgst']) ? $_POST['sgst']:'';
		$supplier=isset($_POST['supname']) ? $_POST['supname']:'';
	
		
		
		 $qq="SELECT id FROM `ti_suppllier` where name='$supplier' and isActive=1";
	$tq=$conn->query($qq);
	$b=$tq->setfetchmode(PDO::FETCH_ASSOC);
	$cgq=$tq->fetch();
	$sup=$cgq['id'];

	
		$echeck="select count(hsn_code) as hsn_code from hsn_code where hsn_code='$hsn'";
	
  $r1=$conn->query($echeck);
			$r1->setfetchmode(PDO::FETCH_ASSOC);
			while($ss=$r1->fetch())
			{
				
		if($ss['hsn_code']==0)
   {
      $q="SELECT id FROM `master_tax` where tax_percent='$tax1' and tax_type=1";
	$t=$conn->query($q);
	$b=$t->setfetchmode(PDO::FETCH_ASSOC);
	$cg=$t->fetch();
	$cgst=$cg['id'];

	$q1="SELECT id FROM `master_tax` where tax_percent='$tax2' and tax_type=2";
	$t1=$conn->query($q1);
	$b1=$t1->setfetchmode(PDO::FETCH_ASSOC);
	$sg=$t1->fetch();
	$sgst=$sg['id'];

   }
   else if($cgst1=='' && $sgst1==''){
	  

	   	$q="SELECT id FROM `master_tax` where tax_percent='$tax1' and tax_type=1";
	$t=$conn->query($q);
	$b=$t->setfetchmode(PDO::FETCH_ASSOC);
	$cg=$t->fetch();
	$cgst=$cg['id'];
	

	$q1="SELECT id FROM `master_tax` where tax_percent='$tax2' and tax_type=2";
	$t1=$conn->query($q1);
	$b1=$t1->setfetchmode(PDO::FETCH_ASSOC);
	$sg=$t1->fetch();
	$sgst=$sg['id'];
	
}
else{
	

	 $q2="SELECT id FROM `master_tax` where tax_percent='$cgst1' and tax_type=1";
	$t2=$conn->query($q2);
	$b2=$t2->setfetchmode(PDO::FETCH_ASSOC);
	$cg2=$t2->fetch();
	$cgst=$cg2['id'];
	
	$q12="SELECT id FROM `master_tax` where tax_percent='$sgst1' and tax_type=2";
	$t12=$conn->query($q12);
	$b12=$t12->setfetchmode(PDO::FETCH_ASSOC);
	$sg2=$t12->fetch();
	$sgst=$sg2['id'];

	   }
	}
 $catt="select id from ti_category where name='$cat'";
 $c=$conn->query($catt);
 $c->setfetchmode(PDO::FETCH_ASSOC);
 $c2=$c->fetch();
 $catid=$c2['id'];
 $cattt="select id from master_unit where unit_name='$unit'";
 $c=$conn->query($cattt);
 $c->setfetchmode(PDO::FETCH_ASSOC);
 $c2=$c->fetch();
 $unitid=$c2['id'];
$qqh1="select count(id) as nu from  hsn_code where hsn_code='$hsn'";
	$t4h1=$conn->query($qqh1);
	$t4h1->setfetchmode(PDO::FETCH_ASSOC);
	$t44=$t4h1->fetch();
	$nu=$t44['nu'];
	if($hsn!='')
	{
	if($nu==0)
	{
	
	$qqh="INSERT INTO `hsn_code`( `hsn_code`,`cgst_id`,`sgst_id`) VALUES('$hsn','$cgst','$sgst')";
	$t4h=$conn->query($qqh);
	
	$q4="select id from hsn_code where hsn_code='$hsn'";
	$t4=$conn->query($q4);
	$b4=$t4->setfetchmode(PDO::FETCH_ASSOC);
	$h=$t4->fetch();
	$hsnno=$h['id'];
}
else
{
	$q4="select id from hsn_code where hsn_code='$hsn'";
	$t4=$conn->query($q4);
	$b4=$t4->setfetchmode(PDO::FETCH_ASSOC);
	$h=$t4->fetch();
	$hsnno=$h['id'];
	
	}
}


$update=" UPDATE `ti_product`SET `cat_id`='$catid',`name`='$proname',`item_desc`='$description',`item_code`='$sku',
`item_buy_price`='$buyprice',`item_sell_price`='$sellingprice',`mrp`='$mrp',
`unit_id`='$unitid',`cgst`='$cgst',`sgst`='$sgst',`hsn_id`='$hsnno' WHERE id= '$proid'";
$x=$conn->query($update);//,`IsActive`='$isactive' `item_stock`='$stock',
$x->setfetchmode(PDO::FETCH_ASSOC);

$_SESSION['i']=1;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
