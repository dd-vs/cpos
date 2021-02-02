<?php 

include("../include/include.php");
	check_session();
html_head();
navbar_user(7);
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT * FROM ti_customer WHERE name LIKE :keyword and  id>1  ORDER BY id ';
	
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
        <h2 style="margin-top:0;">Customer<span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Add New Product</div></span></h2>
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
            <th style="width:5%;"><i class="fa fa-user" aria-hidden="true"></th>
            <th style="31%">Name</th>
            <th style="width:28%;">Address</th>
            <th style="width:16%;">Mobile</th>
            <th style="width:8%">Balance</th>
            <th style="width:12%;">Status</th>
        </tr>
        <?php $y=$start+1;
   
    foreach($result as $s1){ ?>
         <tr>  
            <td><?php echo $y; ?></td>
            <td class="add-new-p" onclick="openPopupedit(this,'<?php echo $s1['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idpro" name="proid"  value="<?php echo $s1['id']; ?>"><?php echo $s1['name']; ?></td>
            <td><?php echo $s1['Address_l1'];?></td>
            <td><?php echo $s1['mobile'];?></td>
            <td class="-txt red"><?php echo $s1['cus_balance']; ?></td></div>
            <td>
                 <?php if($s1['IsActive']==1) { ?>
                <a href='../status/customeractivate.php?status=0&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
              <?php } 
            else {?>
                <a href='../status/customeractivate.php?status=1&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
       <?php }?>
            </td>
        </tr>
       <?php $y++; }?>
    </table>
     <?php echo $per_page_html; ?>
</div>
</form>
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body">
        <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Add New Customer</div>
            <div class="row" style="padding:10px;"></div>
            <form class="" id="" action="../add/custumersave.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Name</span>
                            </span>
                            <input type="text" class="form-control" name="name"  id="AdmtxtName" value=""  placeholder="Customer Name" minlength="2"  required tabindex="1"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Mobile</span>
                            </span>
                            <input type="text" class="form-control" name="mobile" id="Adm_txtMob" value=""  placeholder="Enter 10 digit mobile number" required tabindex="2"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Email</span>
                            </span>
                            <input type="email" class="form-control" name="email" id="Adm_txtEmail" value=""  placeholder="mail@mail.com" tabindex="3"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>PAN</span>
                            </span>
                            <input type="text" class="form-control" name="pan" id="Adm_txtpan" value="" placeholder="PANE00000" tabindex="4"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>GSTIN</span>
                            </span>
                            <input type="text" class="form-control" name="tin" id="Adm_txttin" value="" placeholder="" tabindex="5" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Opening Balance</span>
                            </span>
                            <input type="number" class="form-control" name="balance"  id="Admtxtbal" value=""  placeholder="Balance" required tabindex="6" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>State</span>
                            </span>
                            <select class="form-control" name="state" id="state" name="" tabindex="7"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>City</span>
                            </span>
                            <select class="form-control" name="cities" id="cities" value="" tabindex="8"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Address</span>
                            </span>
                            <textarea class="form-control" name="address" id="Adm_txtCatadd" value="" placeholder="Customer address" tabindex="9"></textarea>
                        </div>
                    </div>
                </div>
                
                 
                <div class="row no-screen" id="toggelon">
                    <div class="col-md-6">
                        <div class="col-md-6 -txt"><label>Status</label></div>
                      <input type="hidden" name="isactive" id="isactive" value="1"> 
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div>
                    <div class="txt- col-md-4"  id="customer-off" style="display:none;"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                    </div>
                    <div class="col-md-6 red">** Red - Mandatory Info</div>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="10">Save</button></div>
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
      	$('#idpro').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getcustdetails.php?d=test',{ proid:ide },function(data) {
			$('#modelbody').html(data);
			document.getElementById("editpopup").style.height = "100%";
		});
		
    }

    function closePopup() {
        document.getElementById("popup").style.height = "0%";
    }
    function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
</script>
