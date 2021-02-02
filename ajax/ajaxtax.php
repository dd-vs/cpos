<?php
  include("../include/include.php");
  if(isset($_GET['cgst']) && $_GET['cgst']!=''){
   $cgst=isset($_GET['cgst']) ? $_GET['cgst']:'0';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="select id as k,tax_percent as v from master_tax where tax_type=1";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($cgst==$v1['v']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['v'];?>" <?php echo $sel; ?> ><?php echo $v1['v'];   ?></option>               
	<?php }} 
   
 if(isset($_GET['sgst']) && $_GET['sgst']!=''){
   $sgst=isset($_GET['sgst']) ? $_GET['sgst']:'0';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="select id as k,tax_percent as v from master_tax where tax_type=2";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($sgst==$v1['v']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['v'];?>" <?php echo $sel; ?> ><?php echo $v1['v'];   ?></option>               
	<?php }} 
	
	
 if(isset($_GET['unit']) && $_GET['unit']!=''){
   $unit=isset($_GET['unit']) ? $_GET['unit']:'0';
	 $query="select id as k,unit_name as v from master_unit";
					 $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
					<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($unit==$v1['v']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['v'];?>" <?php echo $sel; ?> ><?php echo $v1['v'];   ?></option>               
	<?php }} 	
 if(isset($_GET['category']) && $_GET['category']!=''){
   $category=isset($_GET['category']) ? $_GET['category']:'0';
	 $query1="select id as k,name as v from ti_category";
					 $val2=$conn->query($query1);
  $val2->setfetchmode(PDO::FETCH_ASSOC);
  
 
  
  ?>
					<option value="">select</option>
	<?php while($v12=$val2->fetch()){ 
		echo $category;
		echo $v12['v'];
		$sel1=''; if($category==$v12['v']) { echo "dsgt" ;$sel1=" selected='selected' ";}  else {echo "else";}?>
		<option value="<?php echo $v12['v'];?>" <?php echo $sel1; ?> ><?php echo $v12['v'];   ?></option>               
	<?php }} 	
	
	
						
