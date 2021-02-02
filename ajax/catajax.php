 <?php
  include("../include/include.php");
  $val=$conn->query("select distinct name from ti_category where IsActive=1 order by name ");
  $val->setfetchmode(PDO::FETCH_ASSOC);
  
 ?> 
 <option value="">select</option>
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['name'];?>"><?php echo $v['name'];?></option>
  
    <?php }
    ?>
