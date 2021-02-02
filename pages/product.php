<?php 
include("../include/include.php"); 
	check_session();
html_head();
navbar_user(6);
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT ti_product.*,ti_category.name as cat,master_unit.unit_name FROM ti_product left join ti_category on ti_product.cat_id=ti_category.id left join master_unit on master_unit.id=ti_product.unit_id WHERE ti_product.name LIKE :keyword  ORDER BY ti_product.name ';
	
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
        <h2 style="margin-top:0;">Products <span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Add New Product</div></span></h2>
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
            <th style="width:5%;">SI</th>
            <th style="30%">Product</th>
            <th style="width:35%;">Category</th>
            <th style="width:8%;">P. Rate</th>
            <th style="width:8%;">S. Rate</th>
            <th style="width:10%;">Stock</th>
            <th style="width:12%;">Status</th>
        </tr>
        
            <?php
          $y=$start+1;
   
    foreach($result as $a1){ 
		
	 ?>
        <tr >
            <td class="-txt"><?php echo $y; ?></td>
            <td class="add-new-p" onclick="openPopupedit(this,'<?php echo $a1['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idpro" name="proid"  value="<?php echo $a1['id']; ?>"><?php echo $a1['name']; ?></td>
            <td><?php echo $a1['cat']; ?></td>
            <td><?php echo $a1['item_buy_price']; ?></td>
            <td><?php echo $a1['item_sell_price']; ?></td>
            <td><?php echo $a1['item_stock'].$a1['unit_name']; ?></td>
			<td>
				<?php if($a1['IsActive']==1){?>
                        <a href='../status/activatepro.php?status=0&pid=<?php echo $a1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $a1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
                <?php } 
                        else {?>
                            <a href='../status/activatepro.php?status=1&pid=<?php echo $a1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $a1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
                <?php }?>
            </td>
         </tr>
      <?php $y++; }  ?>   
    </table>
   <?php echo $per_page_html; ?>
</div>
</form>
 
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body">
        <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Add New Product</div>
            <div class="row" style="padding:10px;"></div>
           	<form  id="frmenquiry" name="frmenquiry" action="../add/productsave.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Product</span>
                            </span>
                           <input type="text" name="proname"    id="Adm_txt" value="" class="form-control" minlength="2" tabindex="1" required>
									<input type="hidden" id="1tag" value="">
                        </div>
                    </div>
                </div>
              

                <div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="req">Category</span>
							</span>
							<select class="form-control" name="catname"  id="AdmtxtCategory" value=""  tabindex="2" required><option value="">select</option></select>
						</div>
					</div>
					<div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Unit</span>
                            </span>
                            <select class="form-control" name="unit" id="Adm_txtunit" value="" tabindex="3" required ></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">CGST</span>
                            </span>
                          <select class="form-control" name="tax1" id="Adm_txttax1" value="" tabindex="4"  ></select> 
                            <select class="form-control" name="cgst" id="Adm_txttaxcg" value="" tabindex="4" style="display:none"  ><option  id="Adm_txttaxc"></option></select>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">SGST</span>
                            </span>
                            <select class="form-control" name="tax2" id="Adm_txttax2" value="" tabindex="5"  ></select>  
                            <select class="form-control" name="sgst" id="Adm_txttaxsg" value="" tabindex="5" style="display:none" > <option  id="Adm_txttaxs"></option></select>
                        </div>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span>Short Code</span>
							</span>
							<input class="form-control" name="sku" id="Adm_txtsku" value=""  onblur="checkCodeStatus()"tabindex="6">
						</div>
					</div>
                    <div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span>HSN Code</span>
							</span>
						
								<input class="form-control" name="hsn" id="Adm_txthsn" value=""  list="person_list" onkeyup="check(this); checkMailStatus();" onblur="checkMailStatus();" tabindex="7">
							<datalist id="person_list">

							<input type="text" class="form-control" name="hsnid" id="1tag" value=""  tabindex="8">

						</div>
					</div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Buy Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="buyprice" id="Adm_txtprice" value="" placeholder="00.00" tabindex="9" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Sell Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="sellingprice" id="Adm_txtsellingprice" value=""  placeholder="00.00" tabindex="10" />
                        </div>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>MRP</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="mrp" id="Adm_txtmrp" value=""  placeholder="00.00" tabindex="10" />
                        </div>
                    </div>
              
                <div class="row">
                     <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Stock</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="stock" id="Adm_txtstock" value="" tabindex="11" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Description</span>
                            </span>
                            <input type="text" class="form-control" name="description" id="Adm_txtProdis" placeholder="Product Description" tabindex="12"/>
                        </div>
                    </div>
                    
                </div>
                    
                </div>
             
                <div class="row no-screen" id="toggelon">
                    <div class="-txt col-md-2"><label>Status</label></div>
                    <input type="hidden" name="isactive" id="isactive" value="1"> 
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div>
                    <div class="txt- col-md-4"  id="customer-off" style="display:none;"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
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
     function openPopupedit(e,ide) {
      	$('#idpro').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getdetails.php?d=test',{ proid:ide },function(data) {
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
