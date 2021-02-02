 <?php 
	include("../include/include.php"); 
	
		$proid=isset($_POST['proid']) ? $_POST['proid']:'';
$update="SELECT `id`, `uname`, `password`, `name`, `email`, `mobile`, `address`, `IsActive` FROM `ti_user` WHERE 
id= '$proid'";
$x=$conn->query($update);
$x->setfetchmode(PDO::FETCH_ASSOC);
 while($r=$x->fetch()){
	?>
   <div class="popup-container">
  <div class="form-container">
        
 
            <div class="pop-up-title nomargin" >Edit User</div>
            <div class="row" style="padding:10px;"></div>
            <form class="" id="" action="../update/userupdate.php" method="post"><input type="hidden" name="proid" id="proid" value="<?php echo $r['id']; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Name</span>
                            </span>
                            <input type="text" class="form-control" name="name"  id="AdmtxtName" value="<?php echo $r['name']; ?>" placeholder="Name" tabindex="1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Mobile</span>
                            </span>
                            <input type="text" class="form-control" name="mobile" id="Adm_txtMob" value="<?php echo $r['mobile']; ?>" placeholder="10 digit mobile number" tabindex="2"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Email</span>
                            </span>
                            <input type="email"  class="form-control" name="email" id="Adm_txtEmail" value="<?php echo $r['email']; ?>" placeholder="mail@mail.com" tabindex="3"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Address</span>
                            </span>
                            <textarea class="form-control" name="address" id="Adm_txtCatadd" value="address" placeholder="22/13B Some Street Some City" tabindex="4"><?php echo $r['address'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group    has-feedback"  id="success1" > <!-- has-success has-error-->
                            <span class="input-group-addon" >
                                <span class="req">User Name</span>
                            </span>
                            <input type="text"  class="form-control"  name="uname"  id="uname" value="<?php echo $r['uname']; ?>" placeholder="Enter a unique name" onblur="checkMailStatus()"size=18 maxlength=50 required  tabindex="5"/>
                            <span class="glyphicon    form-control-feedback"  id="error1"></span> <!-- glyphicon-ok glyphicon-remove  -->
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Password</span>
                            </span>
                            <input type="password" class="form-control u-pwd" id="password1" name="password" value=""  tabindex="6"/> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Confirm Password</span>
                            </span>
                            <input type="password" class="form-control u-pwd" id="confirm_password1" name="con_password" value=""  tabindex="7"/> 
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="pwdError1"  style="display:none">
                    <div class="info-error -txt-">Passwords Mis-match</div>
                </div>
                <div class="row no-screen" id="toggelon">
                    <div class="col-md-3 -txt"><label>Status</label></div>
                    <input type="hidden" name="isactive" id="isactive" value="1"> 
                        <?php if($r['IsActive']==1) { ?>
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div><?php }else {?>
                    <div class="txt- col-md-4"  id="customer-off"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                <?php } ?>
                    
                    <div class="col-md-6 red">** Red - Mandatory Info</div>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="8">Save</button></div>
            </form>
        </div>
      
        </div>
<?php } ?>
<script>
function checkMailStatus(){
      //alert("came");
var uname=$("#uname").val();// value in field email
$.ajax({
      type:'post',
              url:'../get/checkdata.php?q=get2',// put your real file name 
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
