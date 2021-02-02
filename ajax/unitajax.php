 <?php
  include("../include/include.php");
  $val=$conn->query("select distinct unit_name from master_unit");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 ?> <option value="">select</option>
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['unit_name'];?>"><?php echo $v['unit_name'];?></option>
  
    <?php }
    ?>
