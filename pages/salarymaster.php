

<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(13);
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'select master_allowance.*,master_allowance.default_val as all_val from master_allowance  WHERE master_allowance.allowance_name LIKE :keyword   ORDER BY master_allowance.allowance_name';
	
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
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql1 = 'select master_deduction.*,master_deduction.default_val as ded_val from  master_deduction WHERE master_deduction.deduction_name LIKE :keyword   ORDER BY master_deduction.deduction_name';
	
	/* Pagination Code starts */
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * 30;
	}
	$limit=" limit " . $start . "," . 30;
	$pagination_statement = $conn->prepare($sql1);
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
	
	$query = $sql1.$limit;
	$pdo_statement = $conn->prepare($query);
	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result1 = $pdo_statement->fetchAll();
?>
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-4">
        <h2 style="margin-top:0;">Salary Configuration <span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Add New Item</div></span></h2>
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
	<div class="col-md-6">
	 <table class="table default-table report-table">
        <tr>
            <th style="width:5%;">SI</th>
            <th style="">Item</th>
            <th style="width:15%;">Value</th>
            <th style="width:12%;">Type</th>
            <th style="width:20%;">Status</th>
        </tr>
        
         <?php $y=$start+1;
   
    foreach($result as $s1){ ?>
        <tr >
            <td class="-txt"><?php echo $y; ?></td>
            <td cclass="add-new-p" onclick="openPopupedit1(this,'<?php echo $s1['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idall" name="proid"  value="<?php echo $s1['id']; ?>"><?php echo $s1['allowance_name'];?></td>
            <td><?php echo $s1['all_val'].'SAR';?></td>
            <td>Allowance</td>
			<td>
                <?php if($s1['IsActive']==1) { ?>
                <a href='../status/allowactive.php?status=0&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
              <?php } 
            else {?>
                <a href='../status/allowactive.php?status=1&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
       <?php }?>
            </td>
        </tr>
        <?php $y++;} ?>
        </table>
	
	<?php echo $per_page_html; ?>
	</div>
	<div class="col-md-6">
	
	 <table class="table default-table report-table">
        <tr>
            <th style="width:5%;">SI</th>
            <th style="">Item</th>
            <th style="width:15%;">Value</th>
            <th style="width:12%;">Type</th>
            <th style="width:20%;">Status</th>
        </tr>
        
      <?php
        $x=$start+1;
   
    foreach($result1 as $s3){?>
         <tr >
            <td class="-txt"><?php  echo $x; ?></td>
            <td class="add-new-p" onclick="openPopupedit2(this,'<?php echo $s3['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idded" name="proid"  value="<?php echo $s3['id']; ?>"><?php echo $s3['deduction_name']; ?></td>
            <td><?php echo $s3['ded_val'].'SAR'; ?></td>
            <td>Deduction</td>
			<td>
                <?php if($s3['IsActive']==1) { ?>
                <a href='../status/deductactive.php?status=0&pid=<?php echo $s3['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s3['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
              <?php } 
            else {?>
                <a href='../status/deductactive.php?status=1&pid=<?php echo $s3['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s3['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
       <?php }?>
            </td>
        </tr>
         <?php $x++; }?>
    </table>
 
	
	</div>
   
</div>
</form>
 
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body">
        <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Add New Item</div>
            <div class="row" style="padding:10px;"></div>
           	<form  id="frmenquiry" name="frmenquiry" action="../add/mastersave.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req"> Item </span>
                            </span>
                           <input type="text" name="item_name"    id="item_name" value="" class="form-control" minlength="2" tabindex="1" required>
                        </div>
                    </div>
                </div>
              

                <div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="req">Type</span>
							</span>
							<select class="form-control" name="item_type"  id="item_type" value=""  tabindex="" required><option value="">select</option>
							<option value="1">Allowance</option><option value="2">Deduction</option></select>
						</div>
					</div>
					<div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Value</span>
                            </span>
                            <input type="number" name="item_value"    id="item_value" value="" class="form-control" minlength="" tabindex="" >
                        </div>
                    </div>
                </div>
               
          
             
               
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="13">Save</button></div>
            </form>
        </div>
    </div>
</div>

<div class="pop-up-overlay" id="editpopup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body" id="modelbody">
      
           
    </div>
</div>
<?php html_close(); ?>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
	//~ $(function () {  
	      //~ $("#Adm_txt").autocomplete({
		//~ minLength:2,
			//~ source: "../get/search.php?p=get1",
			//~ select: function (e, ui) {
				//~ var i=ui.item.id;
				//~ document.getElementById('1tag').value=i;
			//~ }
		//~ });});
	
function check(e) {
	
			if($(e).val().length<1) {} else {
				$('#person_list').html('');
					$.ajax({
					url:"../get/post.php?p=getitemlist",
					method:"post",
					data:{itemname:$(e).val().trim()}
				}).done(function(data) {
					$('#person_list').append(data.trim());
				});
				//var a=$("#person_list option[value='" + $('#Adm_txtPro').val() + "']").attr('data-id');
			//alert(a);
			}
			
			} 
		
	
	//~ $(function () {         
		//~ $("#Adm_txthsn").autocomplete({
		//~ minLength:2,
			//~ source: "search.php?p=gethsn",
			//~ select: function (e, ui) {
				//~ var i=ui.item.id;
				//~ document.getElementById('1tag').value=i;
			//~ }
		//~ });
	//~ });
				function checkMailStatus(){
      //alert("came");
var uname=$("#Adm_txthsn").val();// value in field email
$.ajax({
      type:'post',
              url:'../get/post.php?ch=check2',// put your real file name 
              data:{uname: uname},
              
              success:function(msg){
              //alert(msg); 
              if(msg==0)
              {
				 
				  //alert(msg);
              document.getElementById("Adm_txttaxcg").style.display="inline-block";
					 document.getElementById("Adm_txttax1").style.display="none";
					 document.getElementById("Adm_txttaxsg").style.display="inline-block";
					document.getElementById("Adm_txttax2").style.display="none";
					
				
				var pid = $("#Adm_txthsn").val();
				if(pid=='')
				{
					document.getElementById("Adm_txttax1").style.display="inline-block";
					document.getElementById("Adm_txttax2").style.display="inline-block";
					document.getElementById("Adm_txttaxcg").style.display="none";
					document.getElementById("Adm_txttaxsg").style.display="none";
					}
					else{
				$.ajax({
					url:"../get/post.php?h=getcgst",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {

					document.getElementById("Adm_txttaxcg").style.display="inline-block";
					document.getElementById("Adm_txttax1").style.display="none";
					$("#Adm_txttaxc").html(data);
				//alert(data);
					
					
					//~ sum();
				});
				$.ajax({
					url:"../get/post.php?g=getsgst",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					
				
					document.getElementById("Adm_txttaxsg").style.display="inline-block";
					document.getElementById("Adm_txttax2").style.display="none";
					$("#Adm_txttaxs").html(data);
					//alert(data);
					
					//~ sum();
				});}
              }
              else
              {
				  //alert(msg);
 document.getElementById("Adm_txttaxcg").style.display="none";
					 document.getElementById("Adm_txttax1").style.display="inline-block";
					 document.getElementById("Adm_txttaxsg").style.display="none";
					document.getElementById("Adm_txttax2").style.display="inline-block";
}
}
              
              
});
} 
	
		$.ajax
	({
		url:"../ajax/catajax.php",
		method:"post",
	}).done(function(data) {
		$("#AdmtxtCategory").html(data);
		
	});	
	$.ajax ({ 
		url:"../ajax/unitajax.php",
		method:"post",
	}).done(function(data){
		$("#Adm_txtunit").html(data);
	});		
		$.ajax
	({
		url:"../ajax/taxajax.php",
		method:"post",
	}).done(function(data) {
		$("#Adm_txttax1").html(data);
	});	
	$.ajax
	({
	url:"../ajax/taxajax1.php",
		method:"post",
	}).done(function(data) {
		$("#Adm_txttax2").html(data);
	});	
    
    function openPopup() {
        document.getElementById("popup").style.height = "100%";
    }
     function openPopupedit1(e,ide) {
      	$('#idall').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getallowdetails.php?d=test',{ proid:ide },function(data) {
			$('#modelbody').html(data);
			document.getElementById("editpopup").style.height = "100%";
		});
		
    }
     function openPopupedit2(e,ide) {
      	$('#idded').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getdeductdetails.php?d=test',{ proid:ide },function(data) {
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
	function checkCodeStatus(){
          //alert("came");
var uname=$("#Adm_txtsku").val();
if(uname!=''){// value in field email
$.ajax({
          type:'post',
                          url:'../get/checkdata.php?p=get1',// put your real file name 
                          data:{uname: uname},
                          
                          success:function(msg){
                      
                          if(msg!="1")
                          
                          {
							 
						alert(msg);   
                          document.getElementById("Adm_txtsku").value = '';
                          }
                          
                          
}
                          
                          
});}
}
</script>
