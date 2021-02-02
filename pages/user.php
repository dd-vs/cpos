<?php 

include("../include/include.php");
	check_session(); 
html_head();
navbar_user(9);
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT * FROM ti_user WHERE name LIKE :keyword and id>1  ORDER BY id ';
	
	/* Pagination Code starts */
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * 30;
	}
	$limit=" limit " . $start . "," . 30;
	$pagination_statement = $conn->prepare($sql);
	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pagination_statement->execute();

	$row_count = $pagination_statement->rowCount();
	if(!empty($row_count)){
		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
		$page_count=ceil($row_count/30);
		if($page_count>1) {
			
			for($i=1;$i<=$page_count;$i++){
				
				if($i==$page){
					
					
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
				} else {
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
				}
			}
		}
		$per_page_html .= "</div>";
	}
	
	$query = $sql.$limit;
	$pdo_statement = $conn->prepare($query);
	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
?>
	
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-3">
        <h2 style="margin-top:0;">User <span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Add New Product</div></span></h2>
    </div>
    <div class="col-md-4 search-c">
        <form id="frm" action="" method="post">
            <div class="input-group">
<input type='text' class="form-control" name='search[keyword]' placeholder="Search" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit" name="searchpro">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
            </div>
       
    </div>
</div>
<div class="row" style="height:20px;"></div>
<div class="form-container">
    <table class="table default-table report-table">
        <tr>
            <th style="width:5%;"><i class="fa fa-user" aria-hidden="true"></i></th>
            <th style="35%">Name</th>
            <th style="width:14%;">Mobile</th>
            <th style="width:14%">User name</th>
            <th style="width:20%;">Email</th>
            <th style="width:12%;">Status</th>
        </tr>
          <?php $y=$start+1;
   
    foreach($result as $s1){ ?>
         <tr>  
            <td><?php echo $y; ?></td>
            <td class="add-new-p" onclick="openPopupedit(this,'<?php echo $s1['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idpro" name="proid"  value="<?php echo $s1['id']; ?>"><?php echo $s1['name']; ?></td>
            <td><?php echo $s1['mobile'];?></td>
            <td><?php echo $s1['uname'];?></td>
            <td ><?php echo $s1['email']; ?></td></div>
            <td>
                 <?php if($s1['IsActive']==1) { ?>
                <a href='../status/useractive.php?status=0&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
              <?php } 
            else {?>
                <a href='../status/useractive.php?status=1&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
       <?php }?>
            </td>
        </tr>
       <?php $y++; }?>
    </table>
         <?php echo $per_page_html; ?>
</div>
</form>
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head "><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body ">
        <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Add New User</div>
            <div class="row" style="padding:10px;"></div>
            <form class="" id="" action="../add/usersave.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Name</span>
                            </span>
                            <input type="text" class="form-control" name="name"  id="AdmtxtName" value="" placeholder="Name" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Mobile</span>
                            </span>
                            <input type="text" class="form-control" name="mobile" id="Adm_txtMob" value="" placeholder="10 digit mobile number"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Email</span>
                            </span>
                            <input type="email"  class="form-control" name="email" id="Adm_txtEmail" value="" placeholder="mail@mail.com" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Address</span>
                            </span>
                            <textarea class="form-control" name="address" id="Adm_txtCatadd" value="address" placeholder="22/13B Some Street Some City"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group    has-feedback"  id="success" > <!-- has-success has-error-->
                            <span class="input-group-addon" >
                                <span class="req">User Name</span>
                            </span>
                            <input type="text"  class="form-control"  name="uname"  id="uname11" value="" placeholder="Enter a unique name" onblur="checkMailStatus()"size=18 maxlength=50 required />
                            <span class="glyphicon    form-control-feedback"  id="error"></span> <!-- glyphicon-ok glyphicon-remove  -->
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Password</span>
                            </span>
                            <input type="password" class="form-control u-pwd" id="password" name="password" value="" required/> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Confirm Password</span>
                            </span>
                            <input type="password" class="form-control u-pwd" id="confirm_password" name="con_password" value="" required/> 
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="pwdError"  style="display:none">
                    <div class="info-error -txt-">Passwords Mis-match</div>
                </div>
                <div class="row no-screen" id="toggelon">
                    <div class="col-md-3 -txt"><label>Status</label></div>
                   <input type="hidden" name="isactive" id="isactive" value="1"> 
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div>
                    <div class="txt- col-md-4"  id="customer-off" style="display:none;"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                    <div class="col-md-6 req">** Blue - Mandatory Info</div>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary">Save</button></div>
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
<?php
html_close();
 ?>
<script>
		  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
		  <?php  if(isset($_SESSION['l']) && $_SESSION['l'] !='') { ?>
  notify("warning","Already Logged In ,Cannot be InActive");
    <?php  unset($_SESSION['l']);  } ?>
   	$.ajax({
		url:"../ajax/stateajax.php",
		method:"post",
	}).done(function(data){
		$("#state").html(data);
	});
	$("#state").change(function() {
		
		//alert("kkl");
		var a=$("#state").val();
		$.ajax({
		  url:"../ajax/ajaxcity.php",
		  method:"post",
		  data:{a1:a}
		}).done(function(data) {
			$("#cities").html(data);
			//var inp1 = $("#color").val();
		});
		});
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
	
    function openPopup() {
        document.getElementById("popup").style.height = "100%";
    }

    function openPopupedit(e,ide) {
        //document.getElementById("editpopup").style.height = "100%";
      	$('#idpro').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getuserdetails.php?d=test',{ proid:ide },function(data) {
			$('#modelbody').html(data);
			document.getElementById("editpopup").style.height = "100%";
		});
		
    }
function checkMailStatus(){
      //alert("came");
var uname=$("#uname11").val();// value in field email
$.ajax({
      type:'post',
              url:'../get/checkdata.php?q=get2',// put your real file name 
              data:{uname: uname},
              
              success:function(msg){
              //alert(msg); 
              if(msg!='')
              {
              success.className = "input-group has-error has-feedback"; 
                      error.className = "glyphicon glyphicon-remove form-control-feedback" 
              }
              else
              {
success.className = "input-group has-success has-feedback"; 
                      error.className = "glyphicon glyphicon-ok form-control-feedback" 
}
}
              
              
});
}
    
$('#password, #confirm_password').on('keyup', function () {
var x = document.getElementById('pwdError');
  if ($('#password').val() == $('#confirm_password').val()) {
    
      x.style.display = 'none';
  } else 
        x.style.display = 'inline-block';
});

    function closePopup() {
        document.getElementById("popup").style.height = "0%";
    }
    function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
    
    
    
     <?php  if(isset($_SESSION['ing']) && $_SESSION['ing'] !='') { ?>
				 notify("warning","Password or Username Incorrect");
		 <?php  unset($_SESSION['ing']); } ?>
</script>
