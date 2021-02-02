 <?php
 
	include("../include/include.php"); 
	$a4=isset($_POST['a4']) ? $_POST['a4']:'';
  $val=$conn->query("SELECT sup_balance FROM `ti_suppllier` where name='$a4'");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 
  
  while($v=$val->fetch())
  {
echo $v['sup_balance']; }
    ?>
