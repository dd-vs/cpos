<?php
  include("../include/include.php");
   $state=isset($_GET['state']) ? $_GET['state']:'select';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="select master_states.name from master_states left join master_countries on master_countries.id=master_states.country_id where master_countries.name='india'";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($state==$v1['name']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['name'];?>" <?php echo $sel; ?> ><?php echo $v1['name'];   ?></option>               
	<?php } ?>
   
