 <?php
  include("../include/include.php");
  $val=$conn->query("SELECT distinct name FROM `ti_suppllier`");
  $val->setfetchmode(PDO::FETCH_ASSOC);?>
  <option value="">select</option>
  
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['name'];?>"><?php echo $v['name'];?></option>
  
    <?php }
    ?>
