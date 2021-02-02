 <?php  include("../include/include.php");
 
   $designation=isset($_GET['designation']) ? $_GET['designation']:'select';
  $val=$conn->query("select distinct designation from ti_employee");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 ?> 
 <option value="select">select</option>
 <?php while($v=$val->fetch())
  {
  
     $sel=''; if($designation==$v['designation']) $sel=" selected='selected' "; ?>
    <option value="<?php echo $v['designation'];?>"  <?php echo $sel; ?>><?php echo $v['designation'];?></option>
  
    <?php }
    ?>

   
