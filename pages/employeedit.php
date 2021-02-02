

<?php 

include("../include/include.php"); 
check_session();
html_head();
navbar_user(11);
 $id=$_GET['temp'];
 $qq="select IsActive from ti_employee where id ='$id'";
 $ww=$conn->query($qq);
 $ww->setfetchmode(PDO::FETCH_ASSOC);
 $rr=$ww->fetch();
 if($rr['IsActive']==0){
	 
	 header('location:employee.php');
	 if(!isset($_GET['temp']) || $_GET['temp']=='' || $rr['IsActive']==0){
header('location:employee.php');
	 }
	
	 }


	$quu="select ti_employee.*,DATE_FORMAT(ti_employee.join_date,'%d/%m/%Y') as join_date,DATE_FORMAT(ti_employee.dob,'%d/%m/%Y') as dob,master_countries.name as country , master_states.name as state from ti_employee left join master_countries on 
	ti_employee.country=master_countries.id left join master_states on master_states.id=ti_employee.state where ti_employee.IsActive=1 and ti_employee.id='$id' ";
$s22=$conn->query($quu); $re1=$s22->setfetchmode(PDO::FETCH_ASSOC);//
while($wr=$s22->fetch())

{
 $country=isset($wr['country'])? $wr['country']:'select';
	 $state=isset($wr['state'])? $wr['state']:'select';
	 
?>
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-4">
        <h2 style="margin-top:0;">Edit Employee </h2>
    </div>
    
</div>
<form action="../add/employeeditsave.php" method="post">
    <div class="form-container form-container-shaded">
        <div class="col-md-6">
            <div class="container-left">
                <div class="row">
                    <h4>Basic Details</h4>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon req">Full Name</span>
                            <input type="text" class="form-control" name="name" id="emp_name" value="<?php echo $wr['name']; ?>" required />
                            <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $wr['id']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Designation</span>
                            <input type="text" class="form-control" name="designation" id="designation" value="<?php echo $wr['designation']; ?>" list="designation_list" onkeyup="check_des(this);"/>
                            <datalist id="designation_list"></datalist>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Join Date</span>
                            <input type="text" class="form-control" name="join_date" id="jDate" value="<?php echo $wr['join_date']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Passport</span>
                            <input type="text" class="form-control" name="passport" id="passport" value="<?php echo $wr['passport_num']; ?>" />
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Visa Details</span>
                            <input type="text" class="form-control" name="visa" id="visa" value="<?php echo $wr['visa_details']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Iqama details</span>
                            <input type="text" class="form-control" name="iqama" id="iqama"  value="<?php echo $wr['iqama']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Mobile</span>
                            <input type="text" class="form-control" name="mobile" id="mobile"  value="<?php echo $wr['mobile']; ?>"/>
                        </div>
                    </div>
                    <h4>Personal Details</h4>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Gender</span>
                            <select class="form-control" name="gender" id="gender">
                                <option value="1"> Male </option>
                                <option value="2">Female </option>
                                <option value="3">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">DOB</span>
                            <input type="text" class="form-control" id="empDob" name="dob"  required value="<?php echo $wr['dob']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Blood Group</span>
                            <select class="form-control" name="blood_group" id="blood_group">
                                <option value="A+"> A+ </option>
                                <option value="A-" > A- </option>
                                <option value="B+"> B+ </option>
                                <option value="B-" > B- </option>
                                <option value="AB+"> AB+ </option>
                                <option value="AB-" > AB- </option>
                                <option value="O+"> O+ </option>
                                <option value="O-" > O- </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Alternate Phone</span>
                            <input type="text" class="form-control" name="alternate_num" id="alternate_num" value="<?php echo $wr['alternate_phon']; ?>"/>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="container-right">
                <div class="row">
					  <h4>Address</h4>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">House Num</span>
                            <input type="text" class="form-control" name="house_num" id="house_num" value="<?php echo $wr['house_num']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Address</span>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $wr['address']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon "> State/Province </span>
                            <select class="form-control" name="state" id="state_name" name="" tabindex="7">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon req">Country</span>
                            <select class="form-control" name="country" id="country_name" name="" tabindex="7"> 
                            </select>
                        </div>
                    </div>
                    <h4>Salary Config</h4>
                    <table class="table invoice-table">
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
  
                        <tr  >
                            <td></td>
                             <td><select class="form-control" id="category" name="category1" onchange="change();">
                                    <option value="0">Select</option>
                                    <option vlaue="1">Allowance</option>
                                    <option vlaue="2">Deduction</option>
                                </select></td>
                            <td><select  name="item_name" id="item_name" class="form-control"  oninput="change();"></select>
                            
                           
                           
                            <td><input type="text" name="item_value" id="item_value" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  class="form-control" >
                              
                            <td class="green"><button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex=""></button></td>
                        </tr>
                                       <?php
	}
        $quu="select ti_emp_allow_mapping.id,ti_emp_allow_mapping.value as allowance_value,master_allowance.allowance_name
	from ti_employee right join ti_emp_allow_mapping on ti_employee.id=ti_emp_allow_mapping.emp_id
	 left join master_allowance on master_allowance.id=ti_emp_allow_mapping.allow_id 
	where ti_employee.IsActive=1 and ti_emp_allow_mapping.IsActive=1  and ti_employee.id='$id' "; 
	$s22=$conn->query($quu); $re1=$s22->setfetchmode(PDO::FETCH_ASSOC);
	$i=1;
while($wr=$s22->fetch())

{
	
	
	?>
             
<tr class="tr_row">
	<td class="no-screen"> <input type="hidden" name="estatus[]" class="estatus" value="1">
	<input type="hidden" id="all_id" name="all_id[]" value="<?php echo $wr['id'] ?>"></td>
	<td class="td_sl"><?php echo $i; ?></td>
<td><input type="hidden" id="category12" name="category12[]" value="Allowance">Allowance</td>
<td><input type="hidden" id="item_name12" name="item_name12[]" value="<?php echo $wr['allowance_name']; ?>"><?php echo $wr['allowance_name']; ?></td>
<td><input type="hidden" id="item_value12" name="item_value12[]" value="<?php echo $wr['allowance_value']; ?>"><?php echo $wr['allowance_value']; ?></td>
<td><i class="fa fa-times red" aria-hidden="true" id = "" onclick="btnremove(this)"></i></td>
</tr>

<?php $i++;} ?>
                                       <?php
	
        $quu1="select ti_emp_deduct_mapping.id as dedid,ti_emp_deduct_mapping.value as deduction_value,
	master_deduction.deduction_name from ti_employee  right join 
	ti_emp_deduct_mapping on ti_employee.id=ti_emp_deduct_mapping.emp_id 
	left join master_deduction on master_deduction.id=ti_emp_deduct_mapping.deduction_id
	 where ti_employee.IsActive=1 and ti_emp_deduct_mapping.IsActive=1  and ti_employee.id='$id' "; 
	$s221=$conn->query($quu1); $re11=$s221->setfetchmode(PDO::FETCH_ASSOC);
	$j=$i;
while($wr1=$s221->fetch())

{
	
	
	?>
             
<tr class="tr_row">
	<td class="no-screen"> <input type="hidden" name="estatus[]" class="estatus" value="1">
	<input type="hidden" id="ded_id" name="all_id[]" value="<?php echo $wr1['dedid'] ?>"></td>
	<td class="td_sl"><?php echo $j; ?></td>
<td><input type="hidden" id="category12" name="category12[]" value="Deduction">Deduction</td>
<td><input type="hidden" id="item_name12" name="item_name12[]" value="<?php echo $wr1['deduction_name']; ?>"><?php echo $wr1['deduction_name']; ?></td>
<td><input type="hidden" id="item_value12" name="item_value12[]" value="<?php echo $wr1['deduction_value']; ?>"><?php echo $wr1['deduction_value']; ?></td>
<td><i class="fa fa-times red" aria-hidden="true" id = "" onclick="btnremove(this)"></i></td>
</tr>

<?php $j++; } ?>
							<tbody class="tbody"></tbody>
							
           
                    </table>
                </div>
            </div>
        </div> 
        <div class="col-md-12 -txt-"><button class="btn btn-primary">SAVE</button> </div>
    </div>
</form>
 


<?php html_close(); ?>

<script>
	
	$.ajax({
		url:"../ajax/ajaxcountry.php?country=<?php echo $country; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#country_name").html(data);
		$("#country_name").change();
	
	});
	$("#country_name").change(function() {
		var a=$("#country_name").val();
	$.ajax({
		url:"../ajax/ajaxstate.php?state=<?php echo $state; ?>",
		method:"post",
		data:{a1:a}
	}).done(function(data){
		//alert(data);
		$("#state_name").html(data);
		
	});
});
	
	
	
	
	
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
	
			$.ajax({
			
		url:"../ajax/ajaxcountry.php",
		method:"post",
	}).done(function(data){
		
		$("#country").html(data);
	});
		
		$.ajax({
		  url:"../ajax/ajaxstate.php",
		  method:"post",
		  
		}).done(function(data) {
			$("#state").html(data);
			
		});
		$("#category").change(function() {
			//~ alert("cat");
			var cat=$("#category").val();
			//~ alert(cat);
	if(cat=="Allowance"){
		
		$.ajax({
			
		url:"../ajax/ajaxitem.php?p=allow",
		method:"post",
	}).done(function(data){
		
		$("#item_name").html(data);
	});
}
else if(cat=="Deduction"){
	
		$.ajax({
			
		url:"../ajax/ajaxitem.php?p=deduct",
		method:"post",
	}).done(function(data){
		
		$("#item_name").html(data);
	});
		}
});
function change(){
		var cat=$("#category").val();
	if(cat=="Allowance"){
		var pid=$("#item_name").val();
		$.ajax({
					url:"../get/post.php?p=getallowval",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					$("#item_value").val(data);
					
				});
		}
		else if(cat=="Deduction"){
			
			var pid=$("#item_name").val();
		$.ajax({
					url:"../get/post.php?p=getdeductval",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					$("#item_value").val(data);
					
				});
		}
		
}
	//button add function
	
	  $("#btn_additem").click(function() {
		  		  		 
            var html='<tr class="tr_row">';
                        html +='<td class="td_sl"></td>'; //SI No 
                        html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#category').val()+'" name="category1[]" />'+$('#category').val()+'</td>'; //ALLOWANCE/DEDUCTION
                        html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#item_name').val()+'" name="item_name1[]" />'+$('#item_name').val()+'</td>';	//ALLOWANCE NAME/ DEDUCTION NAME
                        html +='<td colspan="" class="item no-print"><input type="hidden" value="'+$('#item_value').val()+'" name="item_value1[]" />'+$('#item_value').val()+'</td>';	//VALUE
						html +='<input type="hidden" name="estatus[]" class="estatus" value="1">';
                        html +='<td class="red -txt- no-print"><i class="fa fa-times" aria-hidden="true" id = "" onclick="btnremove(this)"></i> </td>'; //REMOVE BUTTON
                        html +='</tr>';
                    $('.tbody').append(html);
                    
        
				slno();
				
				document.getElementById('item_name').value = '';
				document.getElementById('item_value').value = '';
				
				
         
		}); 
	
	function btnremove(e) {
			$(e).parent().parent().find('.estatus').val(0);
			
			var r=$(e).parent().parent().find('.estatus').val();
			//alert(r);
			$(e).parent().parent().removeClass('tr_row');
			$(e).parent().parent().hide();
			slno();
		}
			
		function slno() {
			var i=1;
			$('.tr_row').each(function() {
				$(this).find('.td_sl').html(i);
				$('.item').text($('#item_value').val().toFixed(2));
				i++;
			});
		}
	
			
	function check_des(e) {
	
		
			if($(e).val().length<1) {} else {
				$('#designation_list').html('');
					$.ajax({
					url:"../get/post.php?p=getdesig",
					method:"post",
					data:{itemname:$(e).val()}
				}).done(function(data) {
					
					$('#designation_list').append(data);
				});
				
			}
		
			} 
	
  var picker = new Pikaday(
    {
        field: document.getElementById('empDob'),
        firstDay: 1,
        minDate: new Date(1950,01,01),
        maxDate: new Date(2005, 12, 31),
        yearRange: [1950,2005],
        format: 'DD/MM/YYYY',
        defaultDate: new Date('01/01/1990'),
        setDefaultDate: false
    });
var picker = new Pikaday(
    {
        field: document.getElementById('jDate'),
        firstDay: 1,
        minDate: new Date(1980,01,01),
        maxDate: new Date(2018, 12, 31),
        yearRange: [1950,2018],
        format: 'DD/MM/YYYY',
        defaultDate: new Date('01/01/2000'),
        setDefaultDate: false
    });
</script>
