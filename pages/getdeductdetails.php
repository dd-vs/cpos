 <?php 

	include("../include/include.php"); 
	
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
$update="SELECT `id`, `deduction_name`, `default_val`, `IsActive` FROM `master_deduction`WHERE  
master_deduction.id= '$proid'";
$x=$conn->query($update);
$x->setfetchmode(PDO::FETCH_ASSOC);

 while($r=$x->fetch()){
	
	?>
   <div class="popup-container">
  <div class="form-container">
        
           <div class="pop-up-title nomargin" style="">Edit Deduction</div>
            <div class="row" style="padding:10px;"></div>
           	<form  id="frmenquiry" name="frmenquiry" action="../update/mastereditdeduct.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req"> Item </span>
                            </span>
                           <input type="text" name="item_name"    id="item_name" value="<?php echo $r['deduction_name']; ?>" class="form-control" minlength="2" tabindex="1" required>
                        <input type="hidden" id="pro" name="proid" value="<?php echo $r['id']; ?>">
                        </div>
                    </div>
                </div>
              

                <div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="req">Type</span>
							</span>
							<select class="form-control" name="item_type"  id="item_type" value=""  tabindex="" required>
							<option value="2">Deduction</option></select>
						</div>
					</div>
					<div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Value</span>
                            </span>
                            <input type="number" name="item_value"    id="item_value" value="<?php echo $r['default_val']; ?>" class="form-control" minlength="" tabindex="" >
                        </div>
                    </div>
                </div>
               
          
             
               
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="13">Save</button></div>
            </form>
        </div>
      
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
