	 <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Add New Product</div>
            <div class="row" style="padding:10px;"></div>
	  <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Product</span>
                            </span>
                            <input type="text" class="form-control" name="proname" id="Adm_txtPro111" value="" placeholder="Product Name" tabindex="20" required />
                        </div>
                    </div>
                </div>
                
                <div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="req">Category</span>
							</span>
							<select class="form-control" name="catname"  id="AdmtxtCategory" value=""  tabindex="21" required><option value="">select</option></select>
						</div>
					</div>
					<div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Unit</span>
                            </span>
                            <select class="form-control" name="unit" id="Adm_txtunit" value="" tabindex="22" required ></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">CGST</span>
                            </span>
                            <select class="form-control" name="tax1" id="Adm_txttax11" value="" tabindex="23" required ></select>
                              <select class="form-control" name="cgst" id="Adm_txttaxcg" value="" tabindex="4" style="display:none"  ><option  id="Adm_txttaxc"></option></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">SGST</span>
                            </span>
                            <select class="form-control" name="tax2" id="Adm_txttax21" value="" tabindex="24" required ></select>
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
							<input class="form-control" name="sku" id="Adm_txtsku" value=""  onblur="checkCodeStatus()"tabindex="25">
						</div>
					</div>
                    <div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span>HSN Code</span>
							</span>
						
								<input type="text" name="hsn"  id="Adm_txthsn" value="" class="form-control" list="person_list" onkeyup="check(this);" onblur="checkMailStatus()" tabindex="26">


							<input type="hidden" class="form-control" name="hsnid" id="1tag" value=""  tabindex="27">
	
						</div>
					</div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Buy Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="buyprice" id="Adm_txtsellprice" value="" placeholder="00.00" tabindex="28" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Sell Price</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="sellingprice" id="Adm_txtsellingprice1" value=""  placeholder="00.00" tabindex="29" />
                        </div>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>MRP</span>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="mrp" id="Adm_txtmrp1" value=""  placeholder="00.00" tabindex="30" />
                        </div>
                    </div>
              
                <div class="row">
                     <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Stock</span>
                            </span>
                            <input type="number" step="0.01" class="form-control"  name="stock" id="Adm_txtstock1" value="" tabindex="31" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Description</span>
                            </span>
                            <input type="text" class="form-control" name="description" id="Adm_txtProdis1" placeholder="Product Description" tabindex="32"/>
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
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button id="custadd" class="btn btn-primary" tabindex="33">Save</button></div>

<script>
$('#custadd').click(function() {
		$.post('../add/productsave.php',{proname:$('#Adm_txtPro111').val(),catname:$('#AdmtxtCategory').val(),unit:$('#Adm_txtunit').val(),tax1:$('#Adm_txttax11').val(),
			tax2:$('#Adm_txttax21').val(),sku:$('#Adm_txtsku').val(),hsn:$('#Adm_txthsn').val(),buyprice:$('#Adm_txtsellprice').val(),sellingprice:$('#Adm_txtsellingprice1').val(),
			mrp:$('#Adm_txtmrp1').val(),stock:$('#Adm_txtstock1').val(),description:$('#Adm_txtProdis1').val(),isactive:$('#isactive').val()},function(data) {
			alert('save succesfully');
			$('.closebtn').click();
		});
	});



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
					 document.getElementById("Adm_txttax11").style.display="none";
					 document.getElementById("Adm_txttaxsg").style.display="inline-block";
					document.getElementById("Adm_txttax21").style.display="none";
					
				
				var pid = $("#Adm_txthsn").val();
				if(pid=='')
				{
					document.getElementById("Adm_txttax11").style.display="inline-block";
					document.getElementById("Adm_txttax21").style.display="inline-block";
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
					document.getElementById("Adm_txttax11").style.display="none";
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
					document.getElementById("Adm_txttax21").style.display="none";
					$("#Adm_txttaxs").html(data);
					//alert(data);
					
					//~ sum();
				});}
              }
              else
              {
				  //alert(msg);
 document.getElementById("Adm_txttaxcg").style.display="none";
					 document.getElementById("Adm_txttax11").style.display="inline-block";
					 document.getElementById("Adm_txttaxsg").style.display="none";
					document.getElementById("Adm_txttax21").style.display="inline-block";
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
		$("#Adm_txttax11").html(data);
	});	
	$.ajax
	({
	url:"../ajax/taxajax1.php",
		method:"post",
	}).done(function(data) {
		$("#Adm_txttax21").html(data);
	});	
</script>
