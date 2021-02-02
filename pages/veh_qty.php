<?php
include("../include/include.php");

		$a4=isset($_POST['a4']) ? $_POST['a4']:'';

		$query="SELECT  `transport_qty1`, `transport_qty2` FROM `vehicle_details` 
				WHERE `vehicle_no`='$a4' ";
		$stmt=$conn->query($query); $stmt->setfetchmode(PDO::FETCH_ASSOC);?>
		 <option value="select">select</option>
		  <?php while($v=$stmt->fetch())
  {
  ?>
     
    <option value="<?php echo $v['transport_qty1'];?>"><?php echo $v['transport_qty1'];?></option>
    <option value="<?php echo $v['transport_qty2'];?>"><?php echo $v['transport_qty2'];?></option>
  
    <?php }
    ?>

		
 
