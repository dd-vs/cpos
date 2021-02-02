<?php
  include("../include/include.php");
   $city=isset($_GET['city']) ? $_GET['city']:'';
   $a=isset($_POST['a1']) ? $_POST['a1']:'';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="select master_cities.name,master_cities.id from master_cities left join master_states on master_states.id=master_cities.state_id where master_states.name='$a'";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($city==$v1['name']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['id'];?>"  <?php echo $sel; ?> ><?php echo $v1['name']; ?></option>               
	<?php } ?>
   
