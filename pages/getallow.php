<?php
  include("../include/include.php");
  if(isset($_GET['p']) && $_GET['p']=='getitem') {
	  
		$a=isset($_POST['a1']) ? $_POST['a1']:'';
		$query="SELECT master_allowance.id as allow_id,ti_emp_allow_mapping.value,master_allowance.allowance_name FROM `ti_emp_allow_mapping` join master_allowance on 
		ti_emp_allow_mapping.allow_id=master_allowance.id where ti_emp_allow_mapping.IsActive=1 and ti_emp_allow_mapping.emp_id='$a'";
		$co=$conn->query($query);
		$co->setfetchmode(PDO::FETCH_ASSOC);
		$i=1;
		while($so=$co->fetch()){
	?>
			 
			 
			  
			<tr class="datainput">
			<td><?php echo $i; ?></td>
			<td class="no-screen"><input type="hidden" id="allow_id" name="allow_id[]" value="<?php echo $so['allow_id']; ?>"></td>
			<td><input type="hidden" id="allow_name" name="allow_name[]" value="<?php echo $so['allowance_name']; ?>"><?php echo $so['allowance_name']; ?></td>
			<td><input type="text" class="allow_value form-control" id="allow_value" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" name="valueallow[]"  value="<?php echo number_format($so['value'],2,'.',''); ?>"></td>
			</tr>            
		<?php $i++; } }?>
		
