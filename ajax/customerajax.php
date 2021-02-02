 <?php
  //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
  $val=$conn->query("SELECT distinct name FROM `ti_customer`");
  $val->setfetchmode(PDO::FETCH_ASSOC);?>
  <option value="">Select a customer</option>
  
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['name'];?>"><?php echo $v['name'];?></option>
  
    <?php }
    ?>
