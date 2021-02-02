 <?php  include("../include/include.php");
 
   $country=isset($_GET['country']) ? $_GET['country']:'select';
  $val=$conn->query("select distinct name from master_countries");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 ?> 
 <option value="select"></option>
 <?php while($v=$val->fetch())
  {
  
     $sel=''; if($country==$v['name']) $sel=" selected='selected' "; ?>
    <option value="<?php echo $v['name'];?>"  <?php echo $sel; ?>><?php echo $v['name'];?></option>
  
    <?php }
    ?>

   
