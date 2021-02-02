

<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(11);
?>
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-4">
        <h2 style="margin-top:0;">Add New Employee </h2>
    </div>
    
</div>
<form action="../add/employesave.php" method="post">
    <div class="form-container form-container-shaded">
        <div class="col-md-6">
            <div class="container-left">
                <div class="row">
                    <h4>Basic Details</h4>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon req">Full Name</span>
                            <input type="text" class="form-control" name="name" id="emp_name" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Designation</span>
                            <input type="text" class="form-control" name="designation" id="designation" list="designation_list" onkeyup="check_des(this);"/>
                            <datalist id="designation_list"></datalist>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Join Date</span>
                            <input type="text" class="form-control" name="join_date" id="jDate"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Passport</span>
                            <input type="text" class="form-control" name="passport" id="passport" />
                        </div>
                    </div>
                       <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Visa Details</span>
                            <input type="text" class="form-control" name="visa" id="visa" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Iqama details</span>
                            <input type="text" class="form-control" name="iqama" id="iqama" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Mobile</span>
                            <input type="text" class="form-control" name="mobile" id="mobile" />
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
                            <input type="text" class="form-control" id="empDob" name="dob"  required />
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
                            <input type="text" class="form-control" name="alternate_num" id="alternate_num" />
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
                            <input type="text" class="form-control" name="house_num" id="house_num" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">Address</span>
                            <input type="text" class="form-control" name="address" id="address" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon "> State/Province </span>
                            <select class="form-control" name="state" id="state" name="" tabindex="7">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon req">Country</span>
                            <select class="form-control" name="country" id="country" name="" tabindex="7"> 
                            </select>
                        </div>
                    </div>
                    <h4>Salary Config</h4>
                    <table class="table invoice-table">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">Type</th>
                            <th>Item</th>
                            <th style="width: 100px;">Value</th>
                            <th style="width: 50px;"></th>
                        </tr>
                 
                        <tr class="datainput" >
                            <td></td>
                             <td><select class="form-control" id="category" name="category" onchange="change();">
                                    <option value="0">Select</option>
                                    <option vlaue="1">Allowance</option>
                                    <option vlaue="2">Deduction</option>
                                </select></td>
                            <td><select  name="item_name" id="item_name" class="form-control"  oninput="change();"></select>
                            
                           
                           
                            <td><input type="text" name="item_value" id="item_value" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" class="form-control" >
                              
                            <td class="green -txt-"><button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex=""></button></td>
                        </tr>
                        <tbody class="tbody">

							</tbody>
                    </table>
                </div>
            </div>
        </div> 
        <div class="col-md-12 -txt-"><button class="btn btn-primary">SAVE</button> </div>
    </div>
</form>
 



<?php html_close(); ?>

<script>
	
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
	
			$.ajax({
			
		url:"../ajax/ajaxcountry.php",
		method:"post",
	}).done(function(data){
		
		$("#country").html(data);
	});
		$("#country").change(function() {
		
		//alert("kkl");
		var a=$("#country").val();
		$.ajax({
		  url:"../ajax/ajaxstate.php",
		  method:"post",
		  data:{a1:a}
		}).done(function(data) {
			$("#state").html(data);
			//var inp1 = $("#color").val();
		});
		});
		//~ $.ajax({
		  //~ url:"../ajax/ajaxstate.php",
		  //~ method:"post",
		  
		//~ }).done(function(data) {
			//~ $("#state").html(data);
			
		//~ });
		$("#category").change(function() {
			//alert(cat);
			var cat=$("#category").val();
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
                        html +='<td colspan="" class=" no-print"><input type="hidden" value="'+$('#item_value').val()+'" name="item_value1[]" />'+$('#item_value').val()+'</td>';	//VALUE
                       
                        html +='<td class="red -txt- no-print"><i class="fa fa-times" aria-hidden="true" id = "" onclick="btnremove(this)"></i> </td>'; //REMOVE BUTTON
                        html +='</tr>';
                    $('.tbody').append(html);
                    
        
				slno();
				
				document.getElementById('item_name').value = '';
				document.getElementById('item_value').value = '';
				
				
         
		}); 
	
	function btnremove(e) {
			
			$(e).parent().parent().removeClass('tr_row');
			$(e).parent().parent().remove();
			slno();
		}
			
		function slno() {
			var i=1;
			$('.tr_row').each(function() {
				$(this).find('.td_sl').html(i);
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
        setDefaultDate: true
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
        setDefaultDate: true
    });
</script>
