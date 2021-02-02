 <?php 
 //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
	
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
		
$update="SELECT `id`, `vehicle_name`, `vehicle_no`, `transport_qty1`, `transport_qty2`, `IsActive` FROM `vehicle_details` WHERE 
id='$proid'";
$x=$conn->query($update);

$x->setfetchmode(PDO::FETCH_ASSOC);
while($r=$x->fetch()){

	?>
	
  <div class="popup-container">
  <div class="form-container">
        
                <div class="pop-up-title">Edit Vehicle</div>
                <form class="" id="" action="vehupdate.php" method="post"><input type="hidden" name="proid" id="proid" value="<?php echo $r['id']; ?>">
                <div class="row" style="padding:10px;"></div>
                <form  id="frmenquiry" name="frmenquiry" action="../update/vehupdate.php" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="req">Vehicle Number</span>
                                </span>
                                <input type="text" class="form-control" name="veh_no" id="veh_no" value="<?php echo $r['vehicle_no'];?>" placeholder="KL-XX-XX-XXXX" required />
                            </div>
                        </div>

    <!--                    <div class="col-md-9"><input type="text" class="form-control" name="catname" id="Adm_txtCat" placeholder="Enter Category Name" /></div>  -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span>Name</span>
                                </span>
                                <input type="text" class="form-control" name="veh_name" id="veh_name" value="<?php echo $r['vehicle_name'];?>" placeholder="Name"/>
                            </div>
                        </div>
    <!--                    <div class="col-md-9"><textarea class="form-control" name="catdescription" id="Adm_txtCatdis" placeholder="Enter Category Description"></textarea> </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="req">Half Qty</span>
                                </span>
                                <input type="number" class="form-control" name="qty1" id="qty1" value="<?php echo $r['transport_qty1'];?>" placeholder="100" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="req">Full Qty</span>
                                </span>
                                <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $r['transport_qty2'];?>" placeholder="50" required />
                            </div>
                        </div>
                    </div>
                   
                    <div class="row -txt-" style="margin-top: 20px;"><button class="btn btn-primary">Save</button></div>
                </form>
            </div>
        </div> 
  <?php }?>

<script>
function checkMailStatus(){
      //alert("came");
var uname=$("#uname").val();// value in field email
$.ajax({
      type:'post',
              url:'checkdata.php',// put your real file name 
              data:{uname: uname},
              
              success:function(msg){
              //alert(msg); 
              if(msg!='')
              {
              success1.className = "input-group has-error has-feedback"; 
                      error1.className = "glyphicon glyphicon-remove form-control-feedback" 
              }
              else
              {
success1.className = "input-group has-success has-feedback"; 
                      error1.className = "glyphicon glyphicon-ok form-control-feedback" 
}
}
              
              
});
}


    
$('#password1, #confirm_password1').on('keyup', function () {
var x = document.getElementById('pwdError1');
  if ($('#password1').val() == $('#confirm_password1').val()) {
    
      x.style.display = 'none';
  } else 
        x.style.display = 'inline-block';
});

document.onkeydown = function(evt) {
              evt = evt || window.event;

                      if (evt.keyCode == 27) {
                              closePopup();
                      }
                      if (evt.altKey && evt.keyCode == 107) {
                                      openPopup();
                      }
        };
  $("#toggelon").click(function(){
			if (document.getElementById("customer-off").style.display == "none")
			{
			
			var val=0;
				//alert("only cash");
			document.getElementById("isactive").value=val;
			
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
