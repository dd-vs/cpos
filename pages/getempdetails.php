 <?php 

	include("../include/include.php"); 
	
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
$update="SELECT ti_salary_issue.id as issueid,DATE_FORMAT(ti_salary_issue.issue_date,'%d/%m/%Y') as issue_date, DATE_FORMAT(ti_salary_issue.salary_month,'%m/%Y') as salary_month 
,ti_salary_issue.`tot_allow` , ti_salary_issue.`tot_deduct`,ti_salary_issue.`net_salary`,ti_salary_issue.`remarks`,
ti_employee.name as emp_name,ti_employee.designation FROM ti_salary_issue left join ti_employee on ti_employee.id=ti_salary_issue.emp_id where ti_salary_issue.id= '$proid'";
$x=$conn->query($update);
$x->setfetchmode(PDO::FETCH_ASSOC);

 while($r=$x->fetch()){
	 $date=$r['issue_date'];
	
	$designation=isset($r['designation']) ? $r['designation']:'';
	$emp_name=isset($r['emp_name']) ? $r['emp_name']:'';
	  
	?>
   <div class="popup-container">
  <div class="form-container">
        
            <div class="pop-up-title nomargin" style="">Edit Salary Issue</div>
            <div class="row" style="padding:10px;"></div>
           	<form  id="frmenquiry" name="frmenquiry" action="../add/salary_issue_edit.php" method="post">
				<input type="hidden" name="issueid" value="<?php echo $r['issueid']; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Issue Date</span>
                            </span>
                            <input class="form-control" type="text" id="issueDate" value="<?php echo $date;?>" name="issueDate">
                            <input class="form-control" type="hidden" name="salary_month"  value="<?php echo $r['salary_month'];?>"  id="salary_month">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Designation</span>
                            </span>
                            <select    id="designation1" name="designation" value="" class="form-control" tabindex="1" required>
                               
                             </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Name</span>
                            </span>
                           <select    id="emp_name1" name="emp_name" value="" class="form-control" tabindex="1" onchange="check(this);"   required>
                             
                             </select>
                             <input type="hidden" id="emp_id1" name="emp_id" value="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="">Remarks</span>
                            </span>
                           <input type="text"   id="remarks" name="remarks" value="<?php echo $r['remarks']; ?>" class="form-control" tabindex="1"  >
                            
                        </div>
                    </div>
                </div>
                
               	<div class="col-md-6">
					
					<title>Allowance</title>
                 <table class="table invoice-table">
                        <tr>
                            <th>No</th>
                            
                            <th>Item</th>
                            
                            <th style="width: 200px;">Value</th>
                          
                        </tr>
                        <?php
				$salary="SELECT master_allowance.id as allowance_id,ti_salary_allow_mapping.id as sal_a_id,master_allowance.allowance_name,  ti_salary_allow_mapping.value FROM `ti_salary_allow_mapping` left join ti_salary_issue on ti_salary_issue.id=ti_salary_allow_mapping.sal_id left join master_allowance on ti_salary_allow_mapping.allow_id=master_allowance.id where ti_salary_allow_mapping.sal_id='$proid'";
$sal=$conn->query($salary);
$sal->setfetchmode(PDO::FETCH_ASSOC);
 $i=1;
 while($sal1=$sal->fetch()){
	
	 ?>
	 <tr  class="datainput">
	 <td><?php echo $i; ?><input type="hidden" id="sal_a_id" name="sal_a_id[]" value=<?php echo $sal1['sal_a_id']; ?></td>
	 <td class="no-screen"><input type="hidden" id="allow_id" name="all_id1[]" value="<?php echo $sal1['allowance_id']; ?>"></td>
	 <td><input type="hidden" class="allow_name form-control" id="allow_name" name="all_name1[]"  
	 value="<?php echo $sal1['allowance_name']; ?>"><?php echo $sal1['allowance_name']; ?></td>
	<td><input type="text" class="allow_value form-control" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" id="allow_value" name="valallow1[]"  value="<?php echo $sal1['value']; ?>"></td></tr>
	
                        
                       <?php $i++; }?>
                        </table>
                       
                        </div>
                      
                        <div class="col-md-6">
							<title>Deduction</title>
                 <table class="table invoice-table">
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                         
                            <th style="width: 200px;">Value</th>
                           </tr>
                           <?php
				
				$salary1="SELECT master_deduction.id as deduction_id,ti_salary_deduct_mapping.id as sal_d_id,master_deduction.deduction_name,  ti_salary_deduct_mapping.value FROM `ti_salary_deduct_mapping` left join ti_salary_issue on ti_salary_issue.id=ti_salary_deduct_mapping.sal_id left join master_deduction on ti_salary_deduct_mapping.deduct_id=master_deduction.id where ti_salary_deduct_mapping.sal_id='$proid'";
$sal12=$conn->query($salary1);
$sal12->setfetchmode(PDO::FETCH_ASSOC);
 $j=1;
 while($sal2=$sal12->fetch()){
	
	 ?>
	 <tr class="datainput">
			<td><?php echo $j; ?><input type="hidden" id="sal_d_id" name="sal_d_id[]" value=<?php echo $sal2['sal_d_id']; ?></td>
			<td class="no-screen"><input type="hidden" id="ded_id" name="ded_id1[]" value="<?php echo $sal2['deduction_id']; ?>"></td>
			<td><?php echo $sal2['deduction_name']; ?></td>
			<td><input type="text" class="ded_value form-control" id="ded_value" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" name="valueded1[]" onblur="sum();" value="<?php echo $sal2['value']; ?>"></td></tr>
	
                        
                       <?php $j++; }?>

                           
                         
                      
                        
                      
                        </table>
                        </div>
                        <?php
                        $salaryamt="SELECT * FROM `ti_salary_issue` WHERE id='$proid'";
$salaryamt1=$conn->query($salaryamt);
$salaryamt1->setfetchmode(PDO::FETCH_ASSOC);
 $j=1;
 while($salaryamt2=$salaryamt1->fetch()){?>
                        <div class="col-md-12 input-group" id="tamt">
						<span class="input-group-addon">Total Allowance</span><input type="text" id="totallow" class="totallow form-control" name="totallow" value="<?php echo $salaryamt2['tot_allow'];?>" >
		<span class="input-group-addon">Total Deduction</span><input type="text" id="totded" class="totded form-control" name="totded" value="<?php echo $salaryamt2['tot_deduct'];?>" >
		<span class="input-group-addon">Nett Salary</span><input type="text" id="totamt" class="totamt form-control" name="totamt" value="<?php echo $salaryamt2['net_salary'];?>" >	
                        </div>
                       <?php }?>
                     <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="13">UPDATE</button></div>
                </div>
              

               
            </form>
        </div>
    </div>
</div>
<div class="pop-up-overlay" id="editpopup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body" id="modelbody">
      
           
        </div>
    </div>
</div>
<?php } ?>
<script>
$.ajax({
			
		url:"../ajax/ajaxdesignation.php?designation=<?php echo $designation; ?>",
		method:"post",
	}).done(function(data){
		
		$("#designation1").html(data);
		$("#designation1").change();
	});
	$("#designation1").change(function() {
		
		//alert("kkl");
		var a=$("#designation1").val();
		//~ alert(a);
		$.ajax({
		  url:"../ajax/ajaxemployee.php?emp_name=<?php echo $emp_name; ?>",
		  method:"post",
		  data:{a1:a}
		}).done(function(data) {
			//alert(data);
			$("#emp_name1").html(data);
			
			//var inp1 = $("#color").val();
		});
		});	
	$("#emp_name1").blur(function() {
		
	
		var a=$("#emp_name1").val();
		//~ alert(a);
		$.ajax({
		  url:"../get/post.php?p=getemp",
		  method:"post",
		  data:{itemid:a}
		}).done(function(data) {
			
			
			//$("#emp_id").val(parseInt(data));
			$("#emp_id1").val($("#emp_name1").val());
		});
		});	


</script>
