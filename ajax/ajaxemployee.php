<?php
  include("../include/include.php");
   $emp_name=isset($_GET['emp_name']) ? $_GET['emp_name']:'';
   $a=isset($_POST['a1']) ? $_POST['a1']:'';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="SELECT  id,`name` FROM `ti_employee` WHERE `designation`='$a' and ti_employee.IsActive=1";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);?>
	<option value="">select</option>
	<?php while($v1=$val1->fetch()){ 
		$sel=''; if($emp_name==$v1['name']) $sel=" selected='selected' "; ?>
		<option value="<?php echo $v1['id'];?>"  <?php echo $sel; ?> ><?php echo $v1['name']; ?></option>               
	<?php } ?>
   
