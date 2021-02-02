<?php 


	include("../include/include.php"); 
	$cat=isset($_POST['catname']) ? $_POST['catname']:'';
	$cat=test($cat);
	$hsn=isset($_POST['hsn']) ? $_POST['hsn']:'';
	$proname=isset($_POST['proname']) ? $_POST['proname']:'';
	 $proname=test($proname);
	$description=isset($_POST['description']) ? $_POST['description']:'';
	$description=test($description);
	$sku= isset($_POST['sku']) ? $_POST['sku']:'';
	$sku=test($sku);
	$stock=isset($_POST['stock']) ? $_POST['stock']:'0';
	$buyprice=isset($_POST['buyprice']) ? $_POST['buyprice']:'0';
	$sellingprice=isset($_POST['sellingprice']) ? $_POST['sellingprice']:'0';
	$mrp=isset($_POST['mrp']) ? $_POST['mrp']:'0';
	$supplier=isset($_POST['supplier']) ? $_POST['supplier']:'';
	
	
	$unit=isset($_POST['unit']) ? $_POST['unit']:'';
	$tax1=isset($_POST['tax1']) ? $_POST['tax1']:'';$isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	$tax2=isset($_POST['tax2']) ? $_POST['tax2']:'';$cgst=isset($_POST['cgst']) ? $_POST['cgst']:'';$sgst=isset($_POST['sgst']) ? $_POST['sgst']:'';
	
	
	 
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
	$cgst1=$cg['id'];
	
	$q1="SELECT id FROM `master_tax` where tax_percent='$tax2' and tax_type=2";
	$t1=$conn->query($q1);
	$b1=$t1->setfetchmode(PDO::FETCH_ASSOC);
	$sg=$t1->fetch();
	$sgst1=$sg['id'];
   }
   else{
	 $q="SELECT id FROM `master_tax` where tax_percent='$cgst' and tax_type=1";
	$t=$conn->query($q);
	$b=$t->setfetchmode(PDO::FETCH_ASSOC);
	$cg=$t->fetch();
	$cgst1=$cg['id'];
	$q1="SELECT id FROM `master_tax` where tax_percent='$sgst' and tax_type=2";
	$t1=$conn->query($q1);
	$b1=$t1->setfetchmode(PDO::FETCH_ASSOC);
	$sg=$t1->fetch();
	$sgst1=$sg['id'];
	   }
	}
	
	$q2="select id from ti_category where name='$cat'";
	$t2=$conn->query($q2);
	$b2=$t2->setfetchmode(PDO::FETCH_ASSOC);
	$c=$t2->fetch();
	$cate=$c['id'];
	$q3="select id from master_unit where unit_name='$unit'";
	$t3=$conn->query($q3);
	$b3=$t3->setfetchmode(PDO::FETCH_ASSOC);
	$u=$t3->fetch();
	$unite=$u['id'];
	$qqh1="select count(id) as nu from  hsn_code where hsn_code='$hsn'";
	$t4h1=$conn->query($qqh1);
	$t4h1->setfetchmode(PDO::FETCH_ASSOC);
	$t44=$t4h1->fetch();
	$nu=$t44['nu'];
	if($hsn!='')
	{
	if($nu==0)
	{
	
	$qqh="INSERT INTO `hsn_code`( `hsn_code`,`cgst_id`,`sgst_id`) VALUES('$hsn','$cgst1','$sgst1')";
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
	
	}}
	$query="INSERT INTO `ti_product`( `cat_id`, `name`, `item_desc`, `item_code`, `item_stock`, `item_buy_price`, `item_sell_price`,`mrp`, `unit_id`, `cgst`, `sgst`,`hsn_id`, `IsActive`)
	values('$cate','$proname','$description','$sku','$stock','$buyprice','$sellingprice','$mrp',
	'$unite','$cgst1','$sgst1','$hsnno','$isactive')";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>

