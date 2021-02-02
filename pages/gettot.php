<?php

  include("../include/include.php");
  if(isset($_GET['p']) && $_GET['p']=='getitem') {
	  $a=isset($_POST['a1']) ? $_POST['a1']:'';
  $query1="select sum(ti_emp_deduct_mapping.value) as de from ti_emp_deduct_mapping where ti_emp_deduct_mapping.emp_id='$a' and ti_emp_deduct_mapping.IsActive=1";
		$c1=$conn->query($query1);
		$c1->setfetchmode(PDO::FETCH_ASSOC);
		$s1=$c1->fetch();
		$dedct=$s1['de'];
		$query2="select sum(ti_emp_allow_mapping.value) as de from ti_emp_allow_mapping where ti_emp_allow_mapping.emp_id='$a' and ti_emp_allow_mapping.IsActive=1 ";
		$c2=$conn->query($query2);
		$c2->setfetchmode(PDO::FETCH_ASSOC);
		$s2=$c2->fetch();
		$allow=$s2['de'];
		$sum=$allow-$dedct;
		
		?>
				 <span class="input-group-addon">Total Allowance</span><input type="text" id="totallow" class="totallow form-control" name="totallow" value="<?php echo $allow;?>" >
		<span class="input-group-addon">Total Deduction</span><input type="text" id="totded" class="totded form-control" name="totded" value="<?php echo $dedct;?>" >
		<span class="input-group-addon">Nett Salary</span><input type="text" id="totamt" class="totamt form-control" name="totamt" value="<?php echo number_format($sum,2,'.','');?>" >
<!--
		<td id="tcalcal"><?php //echo $allow;?> </td>
		
<td id="tcalcded"><?php //echo $dedct;?> </td>
		 <td id="tcalc"><?php// echo $sum;?> </td>
-->

		
		<?php }
		?>
