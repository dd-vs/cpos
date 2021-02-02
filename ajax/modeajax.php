<?php
  include("../include/include.php");
   $state=isset($_GET['state']) ? $_GET['state']:'0';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="SELECT `id`, `mode`, `IsActive` FROM `master_paymodes`";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($state==$v1['name']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['mode'];?>" <?php echo $sel; ?> ><?php echo $v1['mode'];   ?></option>               
	<?php } ?>
   
