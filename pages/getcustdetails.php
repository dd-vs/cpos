 <?php 
	include("../include/include.php"); 
	
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
$update="SELECT ti_customer.*,ti_customer.Address_l1 as address,master_states.name as state,master_cities.name as city FROM `ti_customer` 
left join master_cities on ti_customer.city_id=master_cities.id left join master_states on master_states.id=master_cities.state_id WHERE 
ti_customer.id= '$proid'";
$x=$conn->query($update);
$x->setfetchmode(PDO::FETCH_ASSOC);
$state=0;$city=0;
 while($r=$x->fetch()){
	 $state=isset($r['state'])? $r['state']:0;
	 $city=isset($r['city'])? $r['city']:0;
	?>
   <div class="popup-container">
  <div class="form-container">
        
            <div class="pop-up-title nomargin" >Edit Customer</div>
            <div class="row" style="padding:10px;"></div>
            <form class="" id="" action="../update/customerupdate.php" method="post"><input type="hidden" name="proid" id="proid" value="<?php echo $r['id']; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Name</span>
                            </span>
                            <input type="text" class="form-control" name="name"  id="AdmtxtName" value="<?php echo $r['name'];?>"  placeholder="Customer Name" required tabindex="11"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Mobile</span>
                            </span>
                            <input type="text" class="form-control" name="mobile" id="Adm_txtMob" value="<?php echo $r['mobile'];?>"  placeholder="10 Digit mobile number" required tabindex="12"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Email</span>
                            </span>
                            <input type="email" class="form-control" name="email" id="Adm_txtEmail" value="<?php echo $r['email'];?>"  placeholder="mail@mail.com" tabindex="13"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>PAN</span>
                            </span>
                            <input type="text" class="form-control" name="pan" id="Adm_txtpan" value="<?php echo $r['PAN'];?>" placeholder="PANE00000" tabindex="14" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>GSTIN</span>
                            </span>
                            <input type="text" class="form-control" name="tin" id="Adm_txttin" value="<?php echo $r['TIN'];?>" placeholder="" tabindex="15"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Opening Balance</span>
                            </span>
                            <input type="number" class="form-control" name="balance"  id="Admtxtbal" value="<?php echo $r['cus_balance']; ?>"  placeholder="Balance" required tabindex="16"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>State</span>
                            </span>
                            <select class="form-control" name="state11" id="state11" name="" tabindex="17">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>City</span>
                            </span>
                            <select class="form-control" name="cities11" id="cities11" value="" tabindex="18" >
								
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Address</span>
                            </span>
                            <textarea class="form-control" name="address" id="Adm_txtCatadd" value="" placeholder="Customer address" tabindex="19"><?php echo $r['address'];?></textarea>
                        </div>
                    </div>
                </div>
                
                
                <div class="row no-screen" id="toggelon">
                    <div class="col-md-6">
                        <div class="col-md-6 -txt"><label>Status</label></div>
                      <input type="hidden" name="isactive" id="isactive" value="1"> 
                        <?php if($r['IsActive']==1) { ?>
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div><?php }else {?>
                    <div class="txt- col-md-4"  id="customer-off"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                <?php } ?>
                    </div>
                    <div class="col-md-6 red">** Red - Mandatory Info</div>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="20">Save</button></div>
            </form>
      
        </div>
        </div>
<?php } ?>
<script>
		
		$.ajax({
		url:"../ajax/stateajax.php?state=<?php echo $state; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#state11").html(data);
		$("#state11").change();
	});
	
		/*$(document).on('change', '#state11', function() {
				alert('inside');
		});*/
	
		$("#state11").change(function() {
		
			var a=$("#state11").val();
			$.ajax({
			  url:"../ajax/ajaxcity.php?city=<?php echo $city; ?>",
			  method:"post",
			  data:{a1:a}
			}).done(function(data) {
				$("#cities11").html(data);
				//var inp1 = $("#color").val();
			});
		});
		
 $("#toggelon").click(function(){
			if (document.getElementById("customer-off").style.display== "inline-block")
			{
			
			//~ var val=0;
				//~ //alert("only cash");
			//~ document.getElementById("isactive").value=val;
			
			document.getElementById("customer-on").style.display="none";
			document.getElementById("customer-off").style.display="inline-block";
		}
		else
		{
			
			var val=1;
				//alert("only cash");
			document.getElementById("isactive").value=val;
			document.getElementById("customer-on").style.display="inline-block";
			document.getElementById("customer-off").style.display="none";
		}
	});
	

</script>
