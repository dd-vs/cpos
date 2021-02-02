 <?php
  include("../include/include.php");
  $val=$conn->query("SELECT distinct tax_percent FROM `master_tax` where tax_type=2 ");
  $val->setfetchmode(PDO::FETCH_ASSOC);?>
  	<option value="">select</option>
 
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['tax_percent'];?>"><?php echo $v['tax_percent'];?></option>
  
    <?php }
    ?>
