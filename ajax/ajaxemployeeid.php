<?php
  include("../include/include.php");
   $city=isset($_GET['city']) ? $_GET['city']:'';
   $a=isset($_POST['a1']) ? $_POST['a1']:'';
   
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="SELECT  id FROM `ti_employee` WHERE `id`='$a' and ti_employee.IsActive=1";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	
	<?php while($v1=$val1->fetch()){ 
		echo $v1['id'];            
	<?php } ?>
   
