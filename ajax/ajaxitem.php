 
 <?php
  include("../include/include.php");
  
   if(isset($_GET['p']) && $_GET['p']=='allow') {
		$val=$conn->query("select distinct allowance_name from master_allowance where master_allowance.IsActive=1");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 ?> 
 <option value="select">select</option>
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['allowance_name'];?>"><?php echo $v['allowance_name'];?></option>
  
    <?php }
    
  }
 else if(isset($_GET['p']) && $_GET['p']=='deduct') {
		$val=$conn->query("select distinct deduction_name from master_deduction where master_deduction.IsActive=1");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 ?> 
 <option value="select">select</option>
 <?php while($v=$val->fetch())
  {
  ?>
     
    <option value="<?php echo $v['deduction_name'];?>"><?php echo $v['deduction_name'];?></option>
  
    <?php }
   
  }
  
