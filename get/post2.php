<?php
  include("../include/include.php");

 if(isset($_GET['p']) && $_GET['p']=='geteachitemtax') {
		$itemid=isset($_POST['itemid']) ? $_POST['itemid']:'';

		$query="select master_tax.tax_percent from master_tax left join ti_product on ti_product.sgst=master_tax.id where ti_product.id='$itemid' ";
		$stmt=$conn->query($query); $result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['tax_percent'];
  }
?>
