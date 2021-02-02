<?php include("../include/include.php");
  /*
   * sale*/
  if(isset($_GET['p']) && $_GET['p']=='getitemlist') {
		$itemname=isset($_POST['itemname']) ? $_POST['itemname']:'';

		$query="select id,hsn_code as k from hsn_code where hsn_code like '%$itemname%'";
		$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$datalist_option='';
		
		foreach($result as $r) {
			$datalist_option .="<option id=\"data_id\" data-id=\"".$r['id']."\" data-code=\"".$r['k']."\" value=\"".$r['k']."\" />";
		}
		echo $datalist_option;
  }
 else if(isset($_GET['p']) && $_GET['p']=='getsalesmanlist') {
		$itemname=isset($_POST['itemname']) ? $_POST['itemname']:'';

		$query="select distinct sales_man as k from ti_sale_invoice where sales_man like '%$itemname%'";
		$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$datalist_option='';
		
		foreach($result as $r) {
			$datalist_option .="<option id=\"data_id\" data-id=\"".$r['k']."\" data-code=\"".$r['k']."\" value=\"".$r['k']."\" />";
		}
		echo $datalist_option;
  }
 else if(isset($_GET['p']) && $_GET['p']=='getallowval') {
		

		$item=isset($_POST['itemid']) ? $_POST['itemid']:'';
  
  $sgst="SELECT  `default_val` FROM `master_allowance` WHERE `allowance_name`='$item'";
$sgst=$conn->query($sgst);
$sgst1=$sgst->fetch(PDO::FETCH_ASSOC);

echo $sgst1['default_val'];
  }
 else if(isset($_GET['p']) && $_GET['p']=='getdeductval') {
	

		$item=isset($_POST['itemid']) ? $_POST['itemid']:'';
  
  $sgst="SELECT  `default_val` FROM `master_deduction` WHERE `deduction_name`='$item'";
$sgst=$conn->query($sgst);
$sgst1=$sgst->fetch(PDO::FETCH_ASSOC);

echo $sgst1['default_val'];
  }
 else if(isset($_GET['p']) && $_GET['p']=='getemp') {
	

		$item=isset($_POST['itemid']) ? $_POST['itemid']:'';
  
  $sgst="SELECT  `id` FROM `ti_employee` WHERE `name`='$item'";
$sgst=$conn->query($sgst);
$sgst1=$sgst->fetch(PDO::FETCH_ASSOC);

echo $sgst1['id'];
  }
 else if(isset($_GET['p']) && $_GET['p']=='getdesig') {
		$itemname=isset($_POST['itemname']) ? $_POST['itemname']:'';

		$query="select distinct designation as k from ti_employee where designation like '%$itemname%'";
		$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$datalist_option='';
		
		foreach($result as $r) {
			$datalist_option .="<option id=\"data_id\" data-id=\"".$r['k']."\" data-code=\"".$r['k']."\" value=\"".$r['k']."\" />";
		}
		echo $datalist_option;
  }
  elseif(isset($_GET['ch']) && $_GET['ch']=='check2')
    {
$name=isset($_POST['uname']) ? $_POST['uname']:'';
$echeck="select count(hsn_code) as hsn_code from hsn_code where hsn_code='$name'";
  $r1=$conn->query($echeck);
$r1->setfetchmode(PDO::FETCH_ASSOC);
while($ss=$r1->fetch())
{
  
  if($ss['hsn_code']!=0)
    {
          echo "0";
    }
    else{
  echo 1;
    }
    }}
else if(isset($_GET['h']) && $_GET['h']=='getcgst'){
  $cgst=isset($_POST['itemid']) ? $_POST['itemid']:'';
  
  $cgst="SELECT master_tax.tax_percent from master_tax left join hsn_code on master_tax.id=hsn_code.cgst_id where hsn_code.hsn_code='$cgst' and master_tax.tax_type=1";
$cgst1=$conn->query($cgst);
$cgst11=$cgst1->fetch(PDO::FETCH_ASSOC);

echo $cgst11['tax_percent'];
}
  else if(isset($_GET['g']) && $_GET['g']=='getsgst'){
  $sgst=isset($_POST['itemid']) ? $_POST['itemid']:'';
  
  $sgst="SELECT master_tax.tax_percent from master_tax left join hsn_code on master_tax.id=hsn_code.sgst_id where hsn_code.hsn_code='$sgst' and master_tax.tax_type=2";
$sgst=$conn->query($sgst);
$sgst1=$sgst->fetch(PDO::FETCH_ASSOC);

echo $sgst1['tax_percent'];
}

   else if(isset($_GET['p']) && $_GET['p']=='geteachitem') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT p.*,hsn_code.hsn_code, mt.tax_percent,mu.unit_name,p.item_sell_price,p.item_code,p.item_stock from ti_product as p left join master_tax as mt 
				on mt.id=p.cgst left join master_unit as mu on mu.id=p.unit_id left join hsn_code on p.hsn_id=hsn_code.id 
				WHERE p.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'].','.$result['unit_name'].','.$result['item_sell_price'].','.$result['hsn_code'].','.$result['item_code'].','.$result['mrp'].','.$result['item_buy_price'].','.$result['item_stock'];
  }
  else if(isset($_GET['p']) && $_GET['p']=='geteachitem1') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT p.*,hsn_code.hsn_code, mt.tax_percent,mu.unit_name,p.item_sell_price,p.name,p.item_stock  from ti_product as p left join master_tax as mt 
				on mt.id=p.cgst left join master_unit as mu on mu.id=p.unit_id left join hsn_code on p.hsn_id=hsn_code.id 
				WHERE p.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'].','.$result['unit_name'].','.$result['item_sell_price'].','.$result['hsn_code'].','.$result['name'].','.$result['mrp'].','.$result['item_buy_price'].','.$result['item_stock'];
  }
  /* purchase*/
   else if(isset($_GET['p']) && $_GET['p']=='getitemlist') {
		$itemname=isset($_POST['itemname']) ? $_POST['itemname']:'';

		$query="select id,item_code as k,name as v from ti_product where name like '%$itemname%' IsActive=1";
		$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$datalist_option='';
		
		foreach($result as $r) {
			$datalist_option .="<option data-id=\"".$r['id']."\" data-code=\"".$r['k']."\" value=\"".$r['v'].'-'.$r['k']."\" />";
		}
		echo $datalist_option;
  }
   else if(isset($_GET['p']) && $_GET['p']=='geteachitempur') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT  p.*,hsn_code.hsn_code,mt.tax_percent,mu.unit_name,p.item_buy_price,p.item_code from ti_product as p 
				left join master_tax as mt on mt.id=p.cgst 
				left join master_unit as mu on mu.id=p.unit_id  left join hsn_code on p.hsn_id=hsn_code.id 
				WHERE p.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'].','.$result['unit_name'].','.$result['item_buy_price'].','.$result['hsn_code'].','.$result['item_code'].','.$result['mrp'].','.$result['item_sell_price'];
  }
   else if(isset($_GET['p']) && $_GET['p']=='geteachitempur1') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT  p.*,hsn_code.hsn_code,mt.tax_percent,mu.unit_name,p.item_buy_price,p.name from ti_product as p 
				left join master_tax as mt on mt.id=p.cgst 
				left join master_unit as mu on mu.id=p.unit_id  left join hsn_code on p.hsn_id=hsn_code.id 
				WHERE p.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'].','.$result['unit_name'].','.$result['item_buy_price'].','.$result['hsn_code'].','.$result['mrp'].','.$result['item_sell_price'];
  }
    else if(isset($_GET['p']) && $_GET['p']=='getcust'){
	  $a=isset($_POST['a1']) ? $_POST['a1']:'';
	  
	  $query="SELECT ti_customer.name as cust_name,ti_customer.id as cust_id,ti_customer.mobile,ti_customer.email,ti_customer.TIN,ti_customer.Address_l1,master_cities.name as city,master_states.name as state,master_states.tin_code,ti_sale_invoice.sale_date as date,amt as amount from ti_customer left join ti_sale_invoice on ti_customer.id=ti_sale_invoice.cust_id left join master_cities on master_cities.id=ti_customer.city_id left join master_states on master_states.id=master_cities.state_id where ti_sale_invoice.invoice_id='$a'";
		$result=$conn->query($query);
		$res=$result->fetch(PDO::FETCH_ASSOC);
		
			echo $res['cust_name'].','.$res['date'].','.$res['amount'].','.$res['cust_id'].','.$res['mobile'].','.$res['email'].','.$res['Address_l1'].','.$res['TIN'].','.$res['tin_code'].','.$res['state'].','.$res['city'];
		}	
		 else if(isset($_GET['r']) && $_GET['r']=='getsupplier'){
	  $b=isset($_POST['a1']) ? $_POST['a1']:'';
	  
	  $query="SELECT ti_suppllier.name,ti_suppllier.id as sup_id,ti_purchase_invoice.invoice_num,ti_purchase_invoice.pur_date as date,amt as amount from ti_suppllier left join ti_purchase_invoice on ti_suppllier.id=ti_purchase_invoice.supplier_id where ti_purchase_invoice.invoice_id='$b'";
		$result=$conn->query($query);
		$res=$result->fetch(PDO::FETCH_ASSOC);
		
			echo $res['name'].','.$res['date'].','.$res['amount'].','.$res['invoice_num'].','.$res['sup_id'];
		}	
		else if(isset($_GET['p']) && $_GET['p']=='geteachitemtax') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="select master_tax.tax_percent from master_tax left join ti_product on ti_product.sgst=master_tax.id where ti_product.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'];
  }
		else if(isset($_GET['p']) && $_GET['p']=='geteachitemtax1') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="select master_tax.tax_percent,ti_product.name from master_tax left join ti_product on ti_product.sgst=master_tax.id where ti_product.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'].','.$result['name'];
  }
		else if(isset($_GET['p']) && $_GET['p']=='getwholeid') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT invoice_id from ti_sale_invoice where invoice_num='$itemid' and sale_type=1 and IsActive=1 and IsHidden=10";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['invoice_id'];
  }
		else if(isset($_GET['p']) && $_GET['p']=='getretailid') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT invoice_id from ti_sale_invoice where invoice_num='$itemid' and sale_type=0 and IsActive=1 and IsHidden=10";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['invoice_id'];
  }
		else if(isset($_GET['p']) && $_GET['p']=='getwholeid1') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT invoice_id from ti_sale_invoice where invoice_num='$itemid' and sale_type=1 and IsActive=1 and IsHidden=11";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['invoice_id'];
  }
		else if(isset($_GET['p']) && $_GET['p']=='getretailid1') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="SELECT invoice_id from ti_sale_invoice where invoice_num='$itemid' and sale_type=0 and IsActive=1 and IsHidden=11";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['invoice_id'];
  }
		else if(isset($_GET['c']) && $_GET['c']=='custbal') {
		$itemid=isset($_POST['a4']) ? $_POST['a4']:'';

		$query="SELECT cus_balance from ti_customer where id='$itemid'";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['cus_balance'];
  }
		else if(isset($_GET['s']) && $_GET['s']=='sustbal') {
		$itemid=isset($_POST['a4']) ? $_POST['a4']:'';

		$query="SELECT sup_balance from ti_suppllier where id='$itemid'";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['sup_balance'];
  }
?>
   
