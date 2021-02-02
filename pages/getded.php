<?php
  include("../include/include.php");
  if(isset($_GET['p']) && $_GET['p']=='getitem') {
	  
		$a=isset($_POST['a1']) ? $_POST['a1']:'';
		$query="SELECT master_deduction.id as deduct_id,ti_emp_deduct_mapping.value,master_deduction.deduction_name FROM `ti_emp_deduct_mapping` join master_deduction on 
		ti_emp_deduct_mapping.deduction_id=master_deduction.id where ti_emp_deduct_mapping.IsActive=1 and ti_emp_deduct_mapping.emp_id='$a'";
		$co=$conn->query($query);
		$co->setfetchmode(PDO::FETCH_ASSOC);
		$i=1;
		while($so=$co->fetch()){
	?>
			 
			 
			  
			<tr class="datainput">
			<td><?php echo $i; ?></td>
			<td class="no-screen"><input type="hidden" id="ded_id" name="ded_id[]" value="<?php echo $so['deduct_id']; ?>"></td>
			<td><input type="hidden" id="deduct_name" name="ded_name[]" value="<?php echo $so['deduction_name']; ?>"><?php echo $so['deduction_name']; ?></td>
			<td><input type="text" class="ded_value form-control" id="ded_value" name="valueded[]" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" onblur="sum();" value="<?php echo $so['value']; ?>"></td>
			</tr>            
		<?php $i++; } 
		
		
		}?>
