 <?php 
    include("../include/include.php"); 
    $proid=isset($_POST['proid']) ? $_POST['proid']:'';
    $update="select ti_product.*,ti_category.name as catname,master_unit.unit_name,hsn_code.hsn_code from ti_product left join ti_category on ti_product.cat_id=ti_category.id 
    left join  master_unit on ti_product.unit_id=master_unit.id left join hsn_code on hsn_code.id=ti_product.hsn_id WHERE ti_product.id= '$proid'";
    $x=$conn->query($update);
    $x->setfetchmode(PDO::FETCH_ASSOC);
    while($r=$x->fetch()){ 
	$unit=isset($r['unit_name']) ? $r['unit_name']:'';
	$category=isset($r['catname']) ? $r['catname']:'';
	

	 ?>
  <div class="popup-container">
            <div class="pop-up-title nomargin" >Edit Product</div>
            <div class="row" style="padding:10px;"></div>
	<form  id="frmenquiry" name="frmenquiry" action="../update/productupdate.php" method="post"><input type="hidden" name="proid" id="proid" value="<?php echo $r['id']; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Product</span>
                            </span>
                            <input type="text" class="form-control" name="proname" id="Adm_txtPro" value="<?php echo $r['name'];  ?>" placeholder="Product Name" tabindex="1" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="req">Category</span>
							</span>
							<select class="form-control" name="catname"  id="AdmtxtCategory54" required tabindex="2">  </select>
						</div>
					</div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Unit</span>
                            </span>
                            <select class="form-control" name="unit" id="Adm_txtunit55" required tabindex="3" >
                            <?php    ?>
                            </select>
                        </div>
                    </div>
                </div>
        <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">CGST</span>
                            </span>
                            <?php 
                                $cgst="select master_tax.tax_percent as cgst from master_tax left join ti_product on master_tax.id=ti_product.cgst WHERE ti_product.id= '".$r['id']."'";
	                           $cg=$conn->query($cgst);
                                $cg->setfetchmode(PDO::FETCH_ASSOC);
                                 while($rcg=$cg->fetch()){
                                     $cgst= $rcg['cgst'];}
                                    ?>
                              <select class="form-control" name="tax1" id="edit_cgst" value=""  tabindex="4" style="display:none"> <option value="<?php echo $cgst;?>"><?php echo $cgst;?></option> </select>
                            <select class="form-control" name="tax1" id="Adm_txttax56" value=""  tabindex="4">  </select>
                              <select class="form-control" name="cgst" id="Adm_txttaxcgt" value="" tabindex="4" style="display:none"  ><option  id="Adm_txttaxc1"></option></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">SGST</span>
                            </span>
                            <?php $sgst="select master_tax.tax_percent as sgst from master_tax left join ti_product on master_tax.id=ti_product.sgst WHERE ti_product.id= '".$r['id']."'";
                            $sg=$conn->query($sgst);
                            $sg->setfetchmode(PDO::FETCH_ASSOC);
                            while($rsg=$sg->fetch()){
                            $sgst= $rsg['sgst'];}
                            ?>
                             <select class="form-control" name="tax2" id="edit_sgst" value="" tabindex="5" style="display:none" > <option value="<?php echo $sgst;?>"><?php echo $sgst;?></option> </select>
                            <select class="form-control" name="tax2" id="Adm_txttax5" value=""  tabindex="5"></select>
                             <select class="form-control" name="sgst" id="Adm_txttaxsgt" value="" tabindex="5" style="display:none" > <option  id="Adm_txttaxs1"></option></select>
                        </div>
                    </div>
                </div>
      
            <div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span>Short Code</span>
							</span>
							<input class="form-control" name="sku" id="Adm_txtsku" value="<?php echo $r['item_code']; ?>" tabindex="6">
						</div>
					</div>
					<div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Buy Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="buyprice" id="Adm_txtprice" value="<?php echo $r['item_buy_price']; ?>" placeholder="00.00" tabindex="8"/>
                        </div>
                    </div>
                      <div class="row">
            <div class="col-md-6 ">
						<div class="input-group">
							<span class="input-group-addon">
								<span>HSN Code</span>
							</span>
							<input class="form-control" name="hsn" id="Adm_txthsn1" value="<?php echo $r['hsn_code'];?>"  list="person_list" onkeyup="check(this); checkMailStatus();" onblur="checkMailStatus();" tabindex="7">
							<datalist id="person_list">


				</datalist>
            
						</div>
					</div>
    
          <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>MRP</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="mrp" id="Adm_txtmrp" value="<?php echo $r['mrp']; ?>"  placeholder="00.00" tabindex="10" />
                        </div>
                    </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Sell Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="sellingprice" id="Adm_txtsellingprice" value="<?php echo $r['item_sell_price']; ?>"  placeholder="00.00" tabindex="9"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Stock</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="stock" id="Adm_txtstock" value="<?php echo $r['item_stock']; ?>" tabindex="11"/>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    
                    
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Description</span>
                            </span>
                            <input type="text" class="form-control" name="description" id="Adm_txtProdis" value="<?php echo $r['item_desc']; ?>" placeholder="Product Description" tabindex="12"/>
                        </div>
                    </div>
                </div>
                    
                	

<script>
	
	
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
		
	</script>
             
                <div class="row no-screen" id="toggelon">
                    <div class="-txt col-md-2"><label>Status</label></div>
                    <input type="hidden" name="isactive" id="isactive" value="1"> 
                        <?php if($r['IsActive']==1) { ?>
                    <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div><?php }else {?>
                    <div class="txt- col-md-4"  id="customer-off"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                <?php } ?>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="12">Save</button></div>
            </form>
        </div>
<?php }?>
<script>
	
	var name=$("#Adm_txthsn1").val();
	if(name!=''){
		
	 document.getElementById("Adm_txttax56").style.display="none";	
	 document.getElementById("Adm_txttax5").style.display="none";
	 document.getElementById("edit_cgst").style.display="inline-block";
	 document.getElementById("edit_sgst").style.display="inline-block";
	}
	function checkMailStatus(){
      //alert("came");
var uname=$("#Adm_txthsn1").val();// value in field email
//alert(uname);
$.ajax({
      type:'post',
              url:'../get/post.php?ch=check2',// put your real file name 
              data:{uname: uname},
              
              success:function(msg){
              //alert(msg); 
              if(msg==0)
              {
				 
				 // alert(msg);
				  document.getElementById("Adm_txttaxcgt").style.display="inline-block";
					 document.getElementById("Adm_txttax56").style.display="none";
					 document.getElementById("Adm_txttaxsgt").style.display="inline-block";
					document.getElementById("Adm_txttax5").style.display="none";
					 document.getElementById("edit_cgst").style.display="none";
	 document.getElementById("edit_sgst").style.display="none";
					
				
				var pid = $("#Adm_txthsn1").val();
				//alert(pid);
				if(pid=='')
				{
					document.getElementById("Adm_txttax56").style.display="inline-block";
					document.getElementById("Adm_txttax5").style.display="inline-block";
					document.getElementById("Adm_txttaxcgt").style.display="none";
					document.getElementById("Adm_txttaxsgt").style.display="none";
					}
					else
					{
						
				$.ajax({
					url:"../get/post.php?h=getcgst",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {

					document.getElementById("Adm_txttaxcgt").style.display="inline-block";
					document.getElementById("Adm_txttax56").style.display="none";
					$("#Adm_txttaxc1").html(data);
				//alert(data);
					
					
					//~ sum();
				});
				$.ajax({
					url:"../get/post.php?g=getsgst",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					
				
					document.getElementById("Adm_txttaxsgt").style.display="inline-block";
					document.getElementById("Adm_txttax5").style.display="none";
					$("#Adm_txttaxs1").html(data);
					//alert(data);
					
					//~ sum();
				});}
			  }
				  else
              {
				  //alert(msg);
 document.getElementById("Adm_txttaxcgt").style.display="none";
					 document.getElementById("Adm_txttax56").style.display="inline-block";
					 document.getElementById("Adm_txttaxsgt").style.display="none";
					document.getElementById("Adm_txttax5").style.display="inline-block";
					 document.getElementById("edit_cgst").style.display="none";
	 document.getElementById("edit_sgst").style.display="none";
}}});}
	
	
	
	$(function () {         
		$("#Adm_txtPro").autocomplete({
		minLength:2,
			source: "../get/search.php?p=get1",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('1tag').value=i;
			}
		});
	});
	$.ajax({
		url:"../ajax/ajaxtax.php?cgst=<?php echo $cgst; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#Adm_txttax56").html(data);
		
	});
	$.ajax({
		url:"../ajax/ajaxtax.php?sgst=<?php echo $sgst; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#Adm_txttax5").html(data);
		
	});
	$.ajax({
		url:"../ajax/ajaxtax.php?unit=<?php echo $unit; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#Adm_txtunit55").html(data);
		
	});
	
	$.ajax({
		url:"../ajax/ajaxtax.php?category=<?php echo $category; ?>",
		method:"post",
	}).done(function(data){
		//alert(data);
		$("#AdmtxtCategory54").html(data);
		
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
</script>
