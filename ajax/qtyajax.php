

<?php
  include("../include/include.php");
   $a=isset($_POST['a1']) ? $_POST['a1']:'';
   $a4=isset($_POST['a4']) ? $_POST['a4']:'';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   $q1="select ti_product.id from ti_product left join ti_category on ti_category.id=ti_product.cat_id where ti_product.name='$a' ";//and ti_product.code='$a4'
   $val2=$conn->query($q1);
    $val2->setfetchmode(PDO::FETCH_ASSOC);
    while($v2=$val2->fetch()){
		$a2=$v2['id'];
		
 $query="SELECT `unit_name` FROM `master_unit` left join ti_product on ti_product.unit_id=master_unit.id WHERE ti_product.id='$a2'";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	
	<?php while($v1=$val1->fetch()){ 
		
		echo $v1['unit_name'];           
		
		               
	 } }?>
   
