<?php 

	include("../include/include.php"); 
		check_session();
		html_head();
        unset($_SESSION['customermail']);
		$sql="SELECT AUTO_INCREMENT as eno
		FROM information_schema.tables
		WHERE table_name = 'ti_sale_invoice'";
		$s=$conn->query($sql); $res=$s->fetch();
		$query="select max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_type=0 and ti_sale_invoice.IsActive=1";
		$s1=$conn->query($query); $res1=$s1->fetch();
		$query1="select max(ti_sale_invoice.invoice_num)+1 as inv_no,max(ti_sale_invoice.invoice_id)+1 as inv_id from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.IsActive=1";
		$s12=$conn->query($query1); $rwhole=$s12->fetch();
		$query2="select max(ti_sale_invoice.invoice_num)+1 as inv_no,max(ti_sale_invoice.invoice_id)+1 as inv_id from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.IsActive=1";
		$s13=$conn->query($query2); $retail=$s13->fetch();
		$quu="select ti_product.name from ti_product";
		$s2=$conn->query($quu); $re=$s2->fetch();
		$ch="SELECT * FROM `master_tax` where tax_type=1";
        $rc=$conn->query($ch);
        $rc->setfetchmode(PDO::FETCH_ASSOC);
        $num=$rc->rowCount();
        $C0=array();
        
       for($j=0;$j<$num;$j++)
       {
		   $cc=$rc->fetch();
		   array_push($C0,$cc['tax_percent']);
		   $t=array($C0[$j]=>$cc['tax_percent']);
		//   echo $t[$cc['tax_percent']*100];
		   
			
	   }
			$ch1="SELECT * FROM `master_tax` where tax_type=2";
        $rc1=$conn->query($ch1);
        $rc1->setfetchmode(PDO::FETCH_ASSOC);
        $num1=$rc1->rowCount();
         $S0=array();
        
       for($j1=0;$j1<$num1;$j1++)
       {
		   $cc1=$rc1->fetch();
		   array_push($S0,$cc1['tax_percent']);
		   $t1=array($S0[$j1]=>$cc1['tax_percent']);
		//   echo $t[$cc['tax_percent']*100];
		   
			
	   }
	 //  $st="rtr";
navbar_user(); ?>	
  <div id="test">
      <div class="row"><div class="col-md-8"><h2 style="margin-top:0;">Sales Invoice</h2></div><div class="col-md-4">
                    <?php if(isset($_SESSION['inv_mail_status'])) { ?>
                    <div style="background: #FFEB3B; border: 2px solid #f0de39; padding: 5px 20px; color: #7d7c7c; border-radius: 5px; font-size: 1.2em;"><?php echo $_SESSION['inv_mail_status']; ?></div>
                    <?php } unset($_SESSION['inv_mail_status']); ?>
                </div></div>
  
            <div class="form-container" id="invoice">
                <button onclick="printInv().print();" class="no-screen">Print</button>
               <form  id="frmenquiry" name="frmenquiry" action="../add/sale_invoice.php" method="post">
                    <div class="invoice-head col-md-12">
                        <div class="col-md-6 right-border">
                            <div class="row">
                                <div class="col-md-4 print-left">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Date</span>
                                        </span>
                                        <input class="form-control" type="text" name="date"  id="AdmtxtDate" value="" required onblur="changeVal('AdmtxtDate','datePrint')" tabindex="1" />
                                        <div class="form-control print-only" id="datePrint"></div>
                                    </div>
                                </div>
                        
                                <div class="col-md-3 print-right">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill No </span>
                                        </span>
									    <input type="hidden" id="invoiceid" value="">
                                        <input type="number"   class="form-control  -txt"  id="retail" value="<?php  echo isset($retail['inv_no']) ? $retail['inv_no']:'1';?>" onchange="changeid();" >
                                        <input type="number"   class="form-control  -txt" id="whole" style="display:none" value="<?php  echo isset($retail['inv_no']) ? $retail['inv_no']:'1';?>" onchange="changeid();">
                                        <span class="input-group-addon">
                                         <span><i class="fa fa-play" id="btnsaleedit"  aria-hidden="true"></i></span>
                                        </span>
                                    </div>
                                    <div id="invNoPrint" class="no-screen"></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill Series</span>
                                        </span>
                                        <select id="selectsale" name="selectsale" onchange="saletype();" class="form-control col-md-3" >
                                            
                                            <option value="0">B to C</option>
                                              <option value="1">B to B</option>
                                          
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 no-print no-screen">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Off</span>
                                        </span>
                                        <input class="form-control" type="text" name="discount" id="dis" onblur="discCal(); changeVal('dis','disPrint')" value="0"> 
                                        
                                    </div>
                                </div>
                                <div class="no-screen" id="disPrint"></div>
                                
                                <div class="col-md-3 input-label no-print no-screen">
                                    <select id="select" class="form-control" name="select" onchange="discCal();">
                                        <option value="1">%</option>
                                        <option value="2">Flat</option>
                                    </select>
                                </div>
                            </div> 
                         
                          
                            <input id="setHidden" hidden name="hidden" value="10" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group no-print">
									<span class="input-group-addon">
                                            <span><i class="fa fa-plus-square" id="btnAddCust" aria-hidden="true"></i></span>
                                        </span>
                                        <span class="input-group-addon">
                                            <span>Customer</span>
                                        </span>
                                       <input type="text" name="customer" id="customer" class="form-control"   required onblur="changeVal('customer','customerPrint')" />
                                       <input type="hidden" name="cust_id" id="cust_id" value="1">
								        
                                      <span class="input-group-addon" id="toggelon">
                                            <span  style="display:none;" class="toggle-btn" id="customer-on"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
                                            <span class="toggle-btn" id="customer-off"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>
                                              
                                        </span>
                                     
                                    </div>
                                     
                                    <div class="form-control print-only" id="customerPrint"></div>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 right-border">
                            <div class="row">
                                 <! --vehicle number-->
                                <div class="col-md-12 no-print no-screen">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Vehicle num</span>
                                        </span>
                                        <input class="form-control" type="text" name="vehicle_num" id="vehicle" onblur="changeVal('vehicle','vehPrint')" value="0"> 
                                    </div>
                                </div>
                                <div class="no-screen" id="vehPrint"></div>
                                <div class="col-md-6 " id="collect_amt">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Cash</span>
                                        </span>
                                        <input class="form-control tableOut"  type="text" name="" id="collect" value="" onblur="sum4(); changeVal2('collect','collectPrint');" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)";/>
                                        <label class="form-control no-screen -txt" id="collectPrint"></label>
                                    </div>
                                 </div>
                                <div class="col-md-6 " id="bal_amt">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Balance</span>
                                        </span>
                                        <label class="form-control" id="c_diff"></label>
                                    </div>                               
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-4 -txt-">
										
										 <input type="hidden" id="cash-credit"  name="cash_credit" value="11">
                                    <span  id="cash" style="display:none;" class="b-type btn btn-primary" >Cash</span>
                                    <span  id="credit"  class="b-type btn btn-primary btn-credit"  >Credit</span>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button class="btn btn-primary" onclick="printInv().print(); pdfMake.createPdf(docSave).download('invoice'+$('#invNum').text()); clickfun();">Print</button>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button type="submit" class="btn btn-primary" onclick="printInv().print(); clickfun()">Save</button>
									<!-- CODE TO SAVE INVOICE WITH INVOICE NUMBER -->
									<!-- <button class="btn btn-primary" onclick="printInv().print(); pdfMake.createPdf(docSave).download('invoice'+$('#invNum').text()); clickfun();">Print</button> -->
                                </div>
                            </div>
							<div class="row">
								
							</div>
                        </div>
                         <div class="red -txt no-screen" id="total-amt" >
                               0.00
                            </div>
                        <div class="col-md-2">
							<div class="bal-notify green -txt-" id="bal_amt11"></div>
                            <div class="red -txt" id="total-bal" >
                               0.00
                            </div>
                            <div class="col-md-12" id="advDiv" style="display:none;"> 
									<div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Advance</span>
                                        </span>
										<input class="form-control " type="text" name="advance_amt" id="advance_amt"  value="0"  onblur="calcadv();">
										<input type="hidden" id="difference" name="difference" >
									</div>
								</div>
                        </div>
                    </div>
                    <div class="invoice-body col-md-12">
                        <div class="focusGuard" id="focusFirst" tabindex="2"></div>
                        <table class="table invoice-table">
							<tbody class="tbody">
                            <tr class="no-print">
                                <th rowspan="2" colspan="2" class="siNo">No</th>
                                <th rowspan="2" colspan="2" class="sItem">Item</th>
                                <th rowspan="2" colspan="2" class="sRate">Rate</th>
                                <th rowspan="2" colspan="2" class="sRate">HSN</th>
                              
                                <th rowspan="2" colspan="2" class="sQty">Qty</th>
                                <th rowspan="2" colspan="2" class="sUom">UoM</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                  <th rowspan="2" colspan="2" class="sDis no-screen">Discount</th>
                                <th rowspan="2" colspan="2" class="sAmt">Amount</th>
                                <th rowspan="2" colspan="2" class="sAdd no-print">&nbsp;</th>
                            </tr>
                            <tr class="no-print">
                                <th rowspan="1" class="cgstP">%</th>
                                <th rowspan="1" class="cgstA">Amt</th>
                                <th rowspan="1" class="sgstP">%</th>
                                <th rowspan="1" class="sgstA">Amt</th>
                            </tr>
                            <tr class="no-screen">
                                <th colspan="2" class="siNo">No</th>
                                <th colspan="2" class="sItem">Item</th>
                                <th colspan="2" class="sRate">Rate</th>
                                <th colspan="2" class="sRate no-print">HSN</th>
                                <th colspan="2" class="sQty">Qty</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                <th colspan="2" class="sAmt">Amount</th>
                            </tr>
                            <tr class="datainput no-print">
								<td class="S/Num -txt" colspan="2">&nbsp;</td>
								<td class="sCode" colspan="">
									<input type="text" tabindex="3" name="code" id="Adm_txtCode" value="" class="form-control no-print" />
									<input type="hidden" id="1dCode" value="">
								</td>
								<td class="table-item" colspan="">
									<input type="text" name="proname"    id="Adm_txtPro" value="" class="form-control" tabindex="4" required>
									<input type="hidden" id="1tag" value="">
								</td>
								<td colspan="2">
									<span id="spanid">
										<input type="text" class="form-control -txt"  name="buyprice" id="Adm_txtprice" value="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  onkeyup="sum();" tabindex="5">
									</span>
									<span id="grossItemRate" class="no-screen"></span>
								</td> 
							    <td colspan="2">
								<input type="text" class="form-control" id="hsn_code">
								</td>
								<td colspan="2" class="hasNotify">
									<input type="text"  name="qty" id="Adm_txtqty" value="" class="form-control  -txt" onkeyup="sum();"  tabindex="6">
								<div id="notifyPop">  </div>
								</td>
                                <td colspan="2">
                                    <span id="qty_unit" style="display: inline-block" ></span>
                                </td>
                           
								<td class="-txt" colspan="1">
									<span id="spantax">
										<span id="Adm_txttax" ></span>
									</span>
								</td>
									<input type="hidden"  name="amount" id="Adm_txtamt" value="" class="form-control" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  onkeyup="sum2()">
								<td class="-txt"  >
									<span   id="Adm_txttax16666"></span>
								</td>
								<td class="-txt" colspan="1">
									<span id="spantax1">
										<span id="Adm_txttax1" ></span>
									</span>
								</td>
								<td class="-txt" >
									<span   id="Adm_txttax17777"></span>
								</td>
									<td colspan="2" class="no-screen">
									<input type="text" name="discount"    id="Adm_txtDis" class="form-control -txt" tabindex="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  value=0  onkeyup="sum();">
								</td> 
								<td class="-txt" colspan="2">
									<span id="Adm_txtsum"></span>
								</td>
								<td class="-txt no-screen" colspan="2">
									<span id="grossSum"></span>
									<span id="itemGrossRate"></span>
								</td>
								<input type="hidden" id="Adm_txtmrp">
								<input type="hidden" id="Adm_txtbuyprice">
								 <input type="hidden" id="item_stock">
								<td class="green -txt-" colspan="2">
									<button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex="7"></button>
								</td>
                            </tr>
                        </tbody>
                            <div class="focusGuard" id="focusLast" tabindex="8"></div>
                          
                            <tr>
							<input type="hidden" id="taxcgst" name="totcgst" value="">
                            <input type="hidden" id="taxsgst" name="totsgst" value="">
                            <input type="hidden" id="amttotal" name="amttotal" value="">

								<td class="-txt" colspan="6">Total</td>
								<td colspan="2"></td>
								<td colspan="2" name="totqty" class="totqty -txt" id="totqty" value="0">0</td>
                                <td colspan="2"></td>
								<td  colspan="2"class="tottax  -txt" id="tottax" value="0">0.00</td>
								<td colspan="2"class="tottax1 -txt" id="tottax1" value="0">0.00</td>
								<td class="-txt" colspan="2"></td>
								<td colspan="2"name="totamt" class="totamt -txt no-screen" id="totamt"  colspan="2" value="0">0.00</td>
								<td colspan="2" class="grossTotAmt -txt" id="grossTotAmt"  colspan="2" value="0">0.00</td>
								
                            </tr>
                            <input type="hidden" id="amount1" name="amount1">
                            <input type="hidden" id="balance-amount" name="balance-amount">
                            <input type="hidden" id="grossamt" value="">
                        </table>
                        <?php 
                        for($i=0;$i<$num;$i++){?>
						<span class="no-screen">cgst</span><input type="hidden" id="ctax<?php echo $i; ?>" value="0"> 
							<input type="hidden" id="ctaxableamt<?php echo $i;?>" value="0">
						<span class="no-screen">cgstamt</span><input type="hidden" id="ctaxamt<?php echo $i;?>" value="0">
 							<?php }
                        
                       
                        for($j=0;$j<$num1;$j++){?>
							
							<span class="no-screen">sgst</span><input type="hidden" id="stax<?php echo $j; ?>" value="0"> 
							<input type="hidden" id="staxableamt<?php echo $j;?>" value="0">
							<span class="no-screen">sgstamt</span><input type="hidden" id="staxamt<?php echo $j;?>" value="0">
 							<?php }
                        
                        ?>
                   
                    </div>
                    <div class="no-screen" id="custaddress"></div>
                    <div class="no-screen" id="custphone"></div>
                    <div class="no-screen" id="custstate"></div>
                    <div class="no-screen" id="custstatecode"></div>
                    <div class="no-screen" id="custcity"></div>
                    <div  class="no-screen"id="custgstin"></div>
                   <input type="hidden" name="fraction" id="fraction">
                   <input type="hidden" name="amtpart" id="amtpart">
            </form>
            </div>
            </div>
    <div class="pop-up-overlay" id="editpopup">
        <div class="pop-up-head quick-cus-pop-head"><a href="javascript:void(0)" class="closebtn" id="close" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
        <div class="pop-up-body quick-cus-pop-body" id="modelbody">   
        </div>
    </div> 
            <!---------Invoice head  ---------->
            <?php $quer="SELECT `id`, `c_name`, `address_1`, `mobile`, `phone`, `mailid`, `website`, `cin`, `gstin` FROM `master_company` WHERE 1";
            $set=$conn->query($quer);
            $set->setfetchmode(PDO::FETCH_ASSOC);
            while($ss=$set->fetch()){
            ?>
            <div class="print-only" id="invoice-head">
                <p id="brand-name"><?php echo $ss['c_name'];?></p>
                <p class="address" id="address-line1"><?php echo $ss['address_1']; ?></p>
                <p class="contact"><span class="" > <?php echo $ss['website']; ?> </span> | <span class="" id="address-website" ><?php echo $ss['mailid']; ?></span> </p>
                <p class="contact no-print"> <span class="" id="address-phone">Ph : <?php echo $ss['phone']; ?> </span>|&nbsp; <span class=""> Mob: <?php echo $ss['mobile']; ?></span></p>
                <p class="print-left no-print">CIN :<?php echo $ss['cin']; ?> </p>
                <p class="print-right"><span class="" id="gst"><?php echo $ss['gstin'];?> </span> </p>
            </div>
            <?php }?>

            <div id="invNum" class="no-screen"></div>
            <!---------Invoice Table ---------->
            <table id="invPTable" class="no-screen" border=1>
                <tbody class="ptBody">
                    <tr>
                        <td>No</td>
                        <td>Item</td>
						<td>HSN</td>
                        <td>Qty</td>
                        <td>Rate</td>
						<td>%</td> 
                        <td>CGST</td>
						<td>%</td> 
                        <td>SGST</td>
                       <td>G.Amt</td>
                    </tr>
                </tbody>
                <tr>
                    <td> </td>
                    <td>Sub-Total</td>
                    <td id="pTotQty"></td>
					<td></td>
                    <td></td>
                    <td ></td> <td id="totCgstPrint"></td>
					<td ></td> <td id="totSgstPrint"></td>
                    <td id="nettAmtPrint"></td>
                </tr>
				 <tr>
                    <td> </td>
                    <td>Grand-Total</td>
                    <td></td>
					<td></td>
                    <td></td>
                    <td ></td><td></td>
					<td ></td><td></td>
                    <td id="roundtotPrint"></td>
                </tr>
            </table>


            <!---------Invoice Table ---------->
            <!---------Invoice head  ---------->
            <!---- Invoice Footer------->
            <div class="print-only" id="invoice-footer">
                <p class="footer">************** THANK YOU ***************</p>
            </div>
            <!---- Invoice Footer------->
    <?php
    html_close();
     ?>
      <script src="libs/pdfmake.min.js"></script>
        <script src="libs/vfs_fonts.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
	//~ $(document).ready(function() {
                      //~ //option A
                      //~ $("form").submit(function(e){
                              //~ alert('submit intercepted');
                              //~ e.preventDefault(e);
                      //~ });
              //~ });
	
	
	
	
      <?php  if(isset($_SESSION['did']) && $_SESSION['did'] !='') { ?>
  notify("danger","Deleted");
    <?php  unset($_SESSION['did']);  } ?>
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
    	$(document).ready(function() {
                      //option A
                      $("form").submit(function(e){
                              //alert('submit intercepted');
                              e.preventDefault(e);
                      });
              });
	
	
	function clickfun(){
							setTimeout(function(){   $('form').unbind('submit').submit();   }, 1000); 
				
							  	
							
						//~ var k="submit";
						//~ $('#formsave1').val(k);	
						//~ $('form').unbind('submit').submit(); 
								  
							 
  

  }
    function clickfun1(){
		
        			
		$('form').unbind('submit').submit(); 						  
							 
  

  }
    function changeid(){
    var selecttype=$("#selectsale").val();
      if(selecttype==1){
    id= $('#whole').val();

    //alert(myvar);
          $.ajax({
					url:"../get/post.php?p=getwholeid",
					method:"post",
					data:{ itemid:id }
				}).done(function(data) {
					//alert(data);
					$("#invoiceid").val(data);
				
				});
				
			}
			
		  if(selecttype==0){
				 id= $('#retail').val();

$.ajax({
					url:"../get/post.php?p=getretailid",
					method:"post",
					data:{ itemid:id }
				}).done(function(data) {
					//alert(data);
					$("#invoiceid").val(data);
				
				});
			}
			}
			
	 $("#btnsaleedit").click(function(ev){
		 

			//$.post('customeradd.php',{inv_no:$('#inv_no').text()},function(data) {
			  var selecttype=$("#selectsale").val();
		  if(selecttype==1){
			
				var myvar = $("#invoiceid").val();
				
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="invoiceedit.php?temp=" + myvar;
		  }
		   if(selecttype==0){
			
				var myvar = $("#invoiceid").val();
//alert(myvar);
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="invoiceedit.php?temp=" + myvar;
		  }
					//});
					});
	
	
	  function saletype()
	  {
		  var selecttype=$("#selectsale").val();
		  if(selecttype==1){
			  	//~ id= $('#whole').val();
			  //~ $.ajax({
					//~ url:"post.php?p=getwholeid",
					//~ method:"post",
					//~ data:{ itemid:id }
				//~ }).done(function(data) {
					//~ alert(data);
					//~ $("#invoiceid").val(data);
				
				//~ });
			  document.getElementById("whole").style.display="inline-block";
			  document.getElementById("retail").style.display="none";
			  $('#invNoPrint').text($('#whole').val());
			 //alert(selecttype);
			  
			  }
		  if(selecttype==0){
			   //~ id= $('#retail').val();

//~ $.ajax({
					//~ url:"post.php?p=getretailid",
					//~ method:"post",
					//~ data:{ itemid:id }
				//~ }).done(function(data) {
					//~ alert(data);
					//~ $("#invoiceid").val(data);
				
				//~ });
			  document.getElementById("retail").style.display="inline-block";
			  document.getElementById("whole").style.display="none";
			  $('#invNoPrint').text($('#retail').val());
			 //alert(selecttype);
			  
			  }
		   
		  }
	
	 $("#btnAddCust").click(function(ev){
			$.post('customeradd.php',{inv_no:$('#inv_no').text()},function(data) {
				document.getElementById("editpopup").style.height = "100%";
				$('#modelbody').html(data);
					});});
    function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
	var gm=0;
	//~ var jArray= <?php echo json_encode($C0); ?>;
//~ var d=$("Adm_txttax").val();
    //~ for(var i=0;i<"<?php echo $num; ?>";i++){
        //~ //alert(jArray[i]);
        //~ if(jArray[i]==0.00){
			//~ alert("0");
			//~ }
    //~ }
function calcadv(){

	var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
	}
		function discCal(){
			//~ if(document.getElementById('btn_additem').style.pointerEvents == 'auto'){
					
				//~ }
				//~ else
				//~ {
					//~ alert("item can't be added after discount" );
					//~ }
			var billAmt = parseFloat(document.getElementById('total-amt').innerText);
			//alert(billAmt);
			var disc = parseFloat(document.getElementById('dis').value);
			//alert(disc);
				function round(value, decimals) {
					return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				}
			var dType = parseFloat(document.getElementById('select').value);
			if (dType == "1"){
				
				document.getElementById('btn_additem').style.pointerEvents = 'none';
				
				if(disc<=100){
				var qm=parseFloat(billAmt) * parseFloat(disc);
				var w=qm/parseFloat(100);
				var diff=parseFloat(billAmt)-parseFloat(w);
				var n=round(diff,2);


				document.getElementById('amount1').value = w;
				document.getElementById('balance-amount').value = n;
	document.getElementById('difference').value=n;
				document.getElementById('total-bal').innerText = n;
				var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
			}
			else
			{
				alert("please enter valid percent");
				$("#dis").val('0');
			}
			}else if(dType == "2"){
				document.getElementById('btn_additem').style.pointerEvents = 'auto';
				var r=parseFloat(billAmt)-parseFloat(disc);
				var z=round(r,2);
				document.getElementById('amount1').value = disc;
				document.getElementById('balance-amount').value = z;
					document.getElementById('difference').value=z;
				document.getElementById('total-bal').innerText =z;
				var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
			}
			sum4();
		}

	document.getElementById('cash').style.pointerEvents = 'none';
        $(function() { // can replace the onload function with any other even like showing of a dialog

          $('#Adm_txtCode').focus();
            changeVal('retail','invNum');
          
        })
        $('#focusLast').on('focus', function() {
          // "last" focus guard got focus: set focus to the first field
         $('#Adm_txtCode').focus();
           
        });

        $('#focusFirst').on('focus', function() {
          // "first" focus guard got focus: set focus to the last field
         $('#btn_additem').focus();
          
        });
    
    function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
					 
				 }
    
     var picker = new Pikaday(
    {
        field: document.getElementById('AdmtxtDate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2025, 12, 31),
        yearRange: [2016,2025],
        format: 'DD/MM/YYYY',
    });
    document.getElementById("AdmtxtDate").value = moment(new Date()).format('DD/MM/YYYY');

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
	$(function () {         
		$("#Adm_txtCode").autocomplete({
		minLength:1,
			source: "../get/search.php?p=get12",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('1tag').value=i;
			}
		});
	});
    
$(function () {                 
$("#customer").autocomplete({
minLength:2,
source: "../get/search.php?q=getitem",
select: function (e, ui) {
var i=ui.item.id;
document.getElementById('cust_id').value=i;
}
});
});
	  $("#customer").blur(function(){
		  var a2=$("#cust_id").val();
		  $.ajax({
		url:"../get/customerbalance.php",
		method:"post",
		 data:{a4:a2}
		}).done(function(data){
				var res=data.split(",");
					

					 $("#bal_amt11").html(res[0]); 
					 $("#custaddress").html(res[2]);
					 $("#custphone").html(res[1]);
					 $("#custstate").html(res[3]);
					 $("#custstatecode").html(res[4]);
					 $("#custgstin").html(res[5]);
					 $("#custcity").html(res[6]);
		
		
		 if(document.getElementById('bal_amt11').innerText ==0){
			  document.getElementById("bal_amt11").style.display="none";
			  }
		});
		 
	  });
	  var tblRowCount = 0;
    
	  $("#btn_additem").click(function() {
		  		  		  document.getElementById("Adm_txtPro").required = false;
		  		  		  document.getElementById("Adm_txtCode").required = false;
		  		  		  var check=parseFloat($('#Adm_txtsum').text());
         
		if(check>0) {
			//|| parseFloat($('#1dCode').val())!='' && parseFloat($('#1dCode').val())>0
			if(parseFloat($('#1tag').val())!='' && parseFloat($('#1tag').val())>0  ){  
                tblRowCount++;
                    var html='<tr class="tr_row">';
                        html +='<td class="td_sl" colspan="2"></td>'; //SI No 
                        html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#Adm_txtCode').val()+'" name="code1[]" />'+$('#Adm_txtCode').val()+'</td>'; //CODE
                        html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#Adm_txtPro').val()+'" name="proname1[]" />'+$('#Adm_txtPro').val()+'</td>';	//PRODUCT
                        html +='<td colspan="" class="no-screen no-print"><input type="hidden" value="'+$('#1tag').val()+'" name="proid[]" />'+$('#1tag').val()+'</td>';	//PRODUCT
                        html +='<td class="-txt no-screen no-print" colspan="2"><input type="hidden" class="grossamt" value="'+$('#grossamt').val()+'" name="grossamt[]"/>'+$('#grossamt').val()+'</td>'; //GROSS AMT
						html +='<td class="-txt n-screen no-print" colspan="2">'+$('#grossItemRate').text()+'</td>'; //GROSS RATE						
                        html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtmrp" value="'+$('#Adm_txtmrp').val()+'" name="Adm_txtmrp[]"/>'+$('#Adm_txtmrp').val()+'</td>'; //MRP
                        html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtbuyprice" value="'+$('#Adm_txtbuyprice').val()+'" name="Adm_txtbuyprice[]"/>'+$('#Adm_txtbuyprice').val()+'</td>';
                        html +='<td class="no-screen no-print"><input type="hidden" class="totdiff" id="totdiff"></td>';
                        html +='<td colspan="2" class="no-screen -txt"><input type="hidden" class="Adm_txtsellingprice" value="'+$('#Adm_txtprice').val()+'" name="buyprice1[]"/>'+$('#Adm_txtprice').val()+'</td>';//SALE PRICE
                        html +='<td  colspan="2"><input type="hidden" value="'+$('#hsn_code').val()+'" name="buypri[]"/>'+$('#hsn_code').val()+'</td>';    //HSN
                        html +='<td colspan="2" class="-txt"><input type="hidden" class="qty" value="'+$('#Adm_txtqty').val()+'" name="qty1[]"/>'+$('#Adm_txtqty').val()+ '</td>';
                        html +='<td colspan = "2"> '+$('#qty_unit').val()+$('#qty_unit').text()+'</td>'; //QTY
                        html +='<td class="no-print"><input type="hidden" id="taxcgsttax"  class="cgst" value="'+$('#Adm_txttax').text()+'" name="cgst[]"/>'+$('#Adm_txttax').text()+'</td>';
                        html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax16666').text()+'" name="tax1[]"/>'+$('#Adm_txttax16666').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" class="tax" value="'+$('#Adm_txttax16666').text()+'" name="cgstamt[]"/>'+$('#Adm_txttax16666').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" id="taxsgsttax" class="sgst" value="'+$('#Adm_txttax1').text()+'" name="sgst[]"/>'+$('#Adm_txttax1').text()+'</td>';
                        html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax17777').text()+'" name="tax2[]"/>'+$('#Adm_txttax17777').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" class="tax1" value="'+$('#Adm_txttax17777').text()+'" name="sgstamt[]"/>'+$('#Adm_txttax17777').text()+'</td>';
                        html +='<td colspan="2" class="-txt no-screen"><input type="hidden" class="disprice" value="'+$('#Adm_txtDis').val()+'" name="disprice1[]"/>'+$('#Adm_txtDis').val()+'</td>'; //DISCOUNT
                        html +='<td colspan="2" class="no-screen -txt"><input type="hidden" class="sum" value="'+$('#Adm_txtsum').text()+'" name="added1[]"/>'+$('#Adm_txtsum').text()+'</td>'; //AMOUNT
						html +='<td colspan="2" class="-txt">'+$('#grossSum').text()+'</td>'; //GROSS AMOUNT
                        html +='<td class="red -txt- no-print"><i class="fa fa-times" aria-hidden="true" id = "'+tblRowCount+'" onclick="btnremove(this)"></i> </td>'; //REMOVE BUTTON
                        html +='</tr>';
                    $('.tbody').append(html);
                    
                
                
                
                
                //tax part
          var cgst=$("#Adm_txttax").text();
                var sgst=$("#Adm_txttax1").text();
                var gamt=$("#grossamt").val();
                var tax=$("#Adm_txttax16666").text();
				var tax1=$("#Adm_txttax17777").text();
                var amt=$("#Adm_txtsum").text();
                var gmtx=parseFloat(tax1)+parseFloat(tax);
                //alert(gmtx);
				var gm=parseFloat(amt)-parseFloat(gmtx);
               var rgm=round(gm,2);
            //  alert(rgm);
				var ctx=parseFloat(rgm)*parseFloat(cgst);
			var	ctaxamt=parseFloat(ctx)/parseFloat(100);
var rctaxamt=round(ctaxamt,2);


				var stx=parseFloat(rgm)*parseFloat(sgst);
				var staxamt=parseFloat(stx)/parseFloat(100);
				var rstaxamt=round(staxamt,2);
			//alert(rstaxamt);
				var sTax =  <?php echo json_encode($S0); ?>;
				var d=$("#Adm_txttax1").text();
				//alert(d);
				for(j = 0;j<"<?php echo $num1; ?>";j++){

					if (parseFloat(sTax[j]) === parseFloat(d)){
						//alert("ghfj");
						document.getElementById('stax'+j).value =sgst;
						document.getElementById('staxableamt'+j).value = parseFloat(document.getElementById('staxableamt'+j).value) + gamt;
						document.getElementById('staxamt'+j).value = parseFloat(document.getElementById('staxamt'+j).value) + parseFloat(tax1);
						break; 
					}

				}
				
				 var cTax =  <?php echo json_encode($C0); ?>;
	var f=$("#Adm_txttax").text();
				//alert(f);
         for(i = 0;i<"<?php echo $num; ?>";i++){
             if (parseFloat(cTax[i]) === parseFloat(f)){
				
                 document.getElementById('ctax'+i).value = cgst;
                 document.getElementById('ctaxableamt'+i).value = parseFloat(document.getElementById('ctaxableamt'+i).value) + gamt;
                 document.getElementById('ctaxamt'+i).value = parseFloat(document.getElementById('ctaxamt'+i).value) + parseFloat(tax);
                 break; 
             }
            
    }
                
          
                
                
//tax part

                        //------To add item to print table--------
                    var ptRow = '<tr class ="pt_row" id = "r'+tblRowCount+'" >';
                        ptRow +='<td class="td_sl"></td>';
                        ptRow +='<td>'+$('#Adm_txtPro').val()+'</td>';
						ptRow +='<td>'+$('#hsn_code').val()+'</td>';
						ptRow +='<td>'+$('#Adm_txtqty').val()+'</td>';
                        ptRow +='<td>'+$('#grossItemRate').text()+'</td>';
                        ptRow +='<td>'+$('#Adm_txttax').text().trim()+'</td>';
						ptRow +='<td>'+$('#Adm_txttax16666').text().trim()+'</td>';
                        ptRow +='<td>'+$('#Adm_txttax1').text().trim()+'</td>';
						ptRow +='<td>'+$('#Adm_txttax17777').text().trim()+'</td>';
                        ptRow +='<td>'+$('#grossSum').text()+'</td>';
                        ptRow +='</tr>'
                    $('.ptBody').append(ptRow);
			
    //}
		//}	
  
				slno();
				document.getElementById('Adm_txtCode').value = '';
				document.getElementById('Adm_txtPro').value = '';
				document.getElementById('hsn_code').value = '';
				document.getElementById('1tag').value = '';
				document.getElementById('1dCode').value = '';
				document.getElementById('Adm_txtDis').value = '0';
				document.getElementById('Adm_txtprice').value = '';
				document.getElementById('Adm_txttax').innerText = '';
				document.getElementById('Adm_txttax1').innerText = '';
				document.getElementById('Adm_txtqty').value = '';
				document.getElementById('Adm_txttax16666').innerText = '';
				document.getElementById('Adm_txttax17777').innerText = '';
				document.getElementById('Adm_txtsum').innerText = '';
				document.getElementById('qty_unit').innerText = '';
				document.getElementById('grossSum').innerText = '';
				
            
	var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
	
				function discCal(){
			var billAmt = parseFloat(document.getElementById('total-amt').innerText);
			//alert(billAmt);
			var disc = parseFloat(document.getElementById('dis').value);
			//alert(disc);
				function round(value, decimals) {
					return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				}
			var dType = parseFloat(document.getElementById('select').value);
			if (dType == "1"){
				document.getElementById('btn_additem').style.pointerEvents = 'none';
				if(disc<=100){
				var qm=parseFloat(billAmt) * parseFloat(disc);
				var w=qm/parseFloat(100);
				var diff=parseFloat(billAmt)-parseFloat(w);
				var n=round(diff,2);

document.getElementById('amount1').value = w;
				document.getElementById('balance-amount').value = n;
document.getElementById('difference').value=n;
				document.getElementById('total-bal').innerText = n;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			else
			{
				alert("please enter valid percent");
				$("#dis").val('0');
			}
			}else if(dType == "2"){
				document.getElementById('btn_additem').style.pointerEvents = 'auto';
				var r=parseFloat(billAmt)-parseFloat(disc);
				var z=round(r,2);
				document.getElementById('amount1').value = disc;
				document.getElementById('balance-amount').value = z;
				document.getElementById('difference').value=z;
				document.getElementById('total-bal').innerText =z;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			sum4();
		}


				
			}else {
				alert('Please select valid item');
				$('#Adm_txtPro').focus().val('');
				$('#Adm_txtCode').focus().val('');
			}
				
			}else {
				alert('Please select valid item');
				$('#Adm_txtPro').focus().val('');
				$('#Adm_txtCode').focus().val('');
			}
		}); 
	
		function btnremove(e) {
            //----remove from print table
            $("#r"+$(e).attr('id')+"").remove();
            //----remove from print table
			$(e).parent().parent().removeClass('tr_row');
			$(e).parent().parent().remove();
			var totamt=0;
			var tottax=0;
			var tottax1=0;
			var totqty=0;
			var gmtx=0;
			var gm=0;
			var ctx=0;
			var ctaxamt=0
			function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}
			var cgst=$(e).parent().parent().find('.cgst').val();
			var sgst=$(e).parent().parent().find('.sgst').val();
			var tax=$(e).parent().parent().find('.tax').val();
			var tax1=$(e).parent().parent().find('.tax1').val();
			var amt=$(e).parent().parent().find('.sum').val();
			var grosamt=$(e).parent().parent().find('.grossamt').val();
			$(".totamt").html(parseFloat(totamt).toFixed(2));
			$("#amttotal").val(parseFloat(totamt).toFixed(2));
			$("#total-amt").html(parseFloat(totamt).toFixed(2));
			$("#total-bal").html(parseFloat(totamt).toFixed(2));
			$("#balance-amount").val(parseFloat(totamt).toFixed(2));
			$(".tottax").html(parseFloat(tottax).toFixed(2));
			$("#taxcgst").val(parseFloat(tottax).toFixed(2));
			$(".tottax1").html(parseFloat(tottax1).toFixed(2));
			$("#taxsgst").val(parseFloat(tottax1).toFixed(2));
			$("#tottx1").val(parseFloat(tottax).toFixed(2));
			$(".totqty").html(parseFloat(totqty).toFixed(0));
			$("#grossTotAmt").html(0);
			$("#totCgstPrint").html(0);
			$("#totSgstPrint").html(0);
			$("#nettAmtPrint").html(0);
			slno();

				gmtx=parseFloat(tax1)+parseFloat(tax);

				gm=parseFloat(amt)-parseFloat(gmtx);
                rgm=round(gm,2);
               // alert(rgm);
				ctx=parseFloat(rgm)*parseFloat(cgst);
				ctaxamt=parseFloat(ctx)/parseFloat(100);
rctaxamt=round(ctaxamt,2);


				stx=parseFloat(rgm)*parseFloat(sgst);
				staxamt=parseFloat(stx)/parseFloat(100);
				rstaxamt=round(staxamt,2);
			//alert(rstaxamt);
				var sTax =  <?php echo json_encode($S0); ?>;
				var d=$(e).parent().parent().find('.sgst').val();
				//alert(d);
				for(j = 0;j<"<?php echo $num1; ?>";j++){

					if (parseFloat(sTax[j]) === parseFloat(d)){
						//alert("ghfj");
						document.getElementById('stax'+j).value =sgst;
						document.getElementById('staxableamt'+j).value = parseFloat(document.getElementById('staxableamt'+j).value) - grosamt;
						document.getElementById('staxamt'+j).value = parseFloat(document.getElementById('staxamt'+j).value) - tax1;
						break; 
					}

				}
				
				 var cTax =  <?php echo json_encode($C0); ?>;
       
	var f=$(e).parent().parent().find('.cgst').val();
				//alert(f);
         for(i = 0;i<"<?php echo $num; ?>";i++){
             if (parseFloat(cTax[i]) === parseFloat(f)){
				
                 document.getElementById('ctax'+i).value = cgst;
                 document.getElementById('ctaxableamt'+i).value = parseFloat(document.getElementById('ctaxableamt'+i).value) - grosamt;
                 document.getElementById('ctaxamt'+i).value = parseFloat(document.getElementById('ctaxamt'+i).value) - tax;
                 break; 
             }
            
    }
			

	var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
	

			function discCal(){
			var billAmt = parseFloat(document.getElementById('total-amt').innerText);
			//alert(billAmt);
			var disc = parseFloat(document.getElementById('dis').value);
			//alert(disc);
				function round(value, decimals) {
					return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				}
			var dType = parseFloat(document.getElementById('select').value);
			if (dType == "1"){
				document.getElementById('btn_additem').style.pointerEvents = 'none';
				if(disc<=100){
				var qm=parseFloat(billAmt) * parseFloat(disc);
				var w=qm/parseFloat(100);
				var diff=parseFloat(billAmt)-parseFloat(w);
				var n=round(diff,2);

document.getElementById('amount1').value = w;
				document.getElementById('balance-amount').value = n;
document.getElementById('difference').value=n;
				document.getElementById('total-bal').innerText = n;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			else
			{
				alert("please enter valid percent");
				$("#dis").val('0');
			}
			}else if(dType == "2"){
				document.getElementById('btn_additem').style.pointerEvents = 'auto';
				var r=parseFloat(billAmt)-parseFloat(disc);
				var z=round(r,2);
				document.getElementById('amount1').value = disc;
				document.getElementById('balance-amount').value = z;
				document.getElementById('difference').value=z;
				document.getElementById('total-bal').innerText =z;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			sum4();
		}

		}
		function slno() {
						
			var gm=0;		
			var i=1;
			var totamt=0;
			var tottax=0;
			var tottax1=0;
			var totqty=0;
			var amtblnc=0;
            var grosTot = 0;
            var totamtfraction=0;
          
			$('.tr_row').each(function() {
			  function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}
				$(this).find('.td_sl').html(i);
                var cgst=$(this).find('.cgst').val();
				var sgst=$(this).find('.sgst').val();
				var amt=$(this).find('.sum').val();
                var gamt=$(this).find('.grossamt').val();
				var qty=$(this).find('.qty').val();
				var mrp=$(this).find('.Adm_txtmrp').val();
				var byprice=$(this).find('.Adm_txtbuyprice').val();
				var sellprice=$(this).find('.Adm_txtsellingprice').val();
				var diffr=parseFloat(sellprice)-parseFloat(byprice);
				//alert(diffr);
				$("#totdiff").val(parseFloat(diffr).toFixed(2));
				document.getElementById('totdiff').value=diffr;
				totamt=parseFloat(totamt)+parseFloat(amt);
                grosTot = grosTot + parseFloat(gamt);
				var tax=$(this).find('.tax').val();
				var tax1=$(this).find('.tax1').val();
				tottax=parseFloat(tottax)+parseFloat(tax);
				tottax1=parseFloat(tottax1)+parseFloat(tax1);
				totqty=parseFloat(totqty)+parseFloat(qty);
                //tax cal
            
	totamtfraction = parseFloat(grosTot) + parseFloat(tottax) + parseFloat(tottax1);
	//alert(totamtfraction);
	
					var whole=Math.floor(totamtfraction);
					var fraction=parseFloat(totamtfraction)-parseFloat(whole);
					if(fraction==0){
						$("#fraction").val(0);
						$("#amtpart").val(parseFloat(totamtfraction).toFixed(2));
						}
				else	if(fraction>0.50){
						var dec=1-parseFloat(fraction);
	
	 amtblnc=parseFloat(totamtfraction)+parseFloat(dec);
	 
						$("#fraction").val(parseFloat(dec).toFixed(2));
						$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
						}
						else{
							
							amtblnc=parseFloat(totamtfraction)-parseFloat(fraction);
							$("#fraction").val(parseFloat(-fraction).toFixed(2));
							$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
							}
							
				$("#taxcgst").val(round(tottax,2).toFixed(2));
				$("#taxsgst").val(round(tottax1,2).toFixed(2));
				$(".totamt").html(round(totamtfraction,2).toFixed(2));
				$("#amttotal").val(round(totamt,2).toFixed(2));
				$("#total-amt").html(round(totamt,2).toFixed(2));
				$("#total-bal").html(round(totamt,2).toFixed(2));
				$("#balance-amount").val(round(totamt,2).toFixed(2));
				$(".tottax").html(round(tottax,2).toFixed(2));
				$(".tottax1").html(round(tottax1,2).toFixed(2));
                $("#totCgstPrint").html(round(tottax,2).toFixed(2));
                $("#totSgstPrint").html(round(tottax1,2).toFixed(2));
				$(".totqty").html(round(totqty,2).toFixed(2));
                $("#pTotQty").text(totqty);
                 $("#pTotAmt").text(round(grosTot,2).toFixed(2));
                 $("#nettAmtPrint1").text(round(totamtfraction,2).toFixed(2));
                 var roundtotPrint=parseFloat(totamtfraction)+parseFloat($('#fraction').val());
			    $("#roundtotPrint").text(round(roundtotPrint,2).toFixed(2));
				$("#nettAmtPrint").text(round(parseFloat(grosTot),2).toFixed(2));
                $("#roundoffPrint").text($('#fraction').val());
				$("#grossTotAmt").text(round(grosTot,2).toFixed(2));
                $("#totCgstPrint").text(parseFloat(tottax).toFixed(2));
                $("#totSgstPrint").text(parseFloat(tottax1).toFixed(2));
				i++;
				
			});

            var siJ = 1;
            $('.pt_row').each(function() {
                $(this).find('.td_sl').html(siJ);
                siJ++;
            });
			
		}
	
			
			
		function check(e) {
			if($(e).val().length<3) {} else {
				$('#person_list').html('');
					$.ajax({
					url:"../get/post.php?p=getitemlist",
					method:"post",
					data:{itemname:$(e).val().trim()}
				}).done(function(data) {
					$('#person_list').append(data.trim());
				});
			}
			}
		
		$(document).ready(function(){	
			$.ajax({
			url:"../ajax/customerajax.php",
			method:"post",
			}).done(function(data){
			$("#customer").html(data);
			});
			$("#Adm_txtPro").change(function() {
				var a=$("#Adm_txtPro").val();
				var a2=$("#code").val();
				var pid = $("#1tag").val();
				$.ajax({
					url:"../get/post.php?p=geteachitem",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res=data.split(",");
					var ttt=res[2];
					$("#Adm_txtprice").val((res[2]));
					$("#Adm_txttax").html(res[0]);
					$("#qty_unit").html(res[1]);
					$("#hsn_code").val(res[3]);
					$("#Adm_txtCode").val(res[4]);
					$("#Adm_txtmrp").val(res[5]);
					$("#Adm_txtbuyprice").val(res[6]);
					$("#item_stock").val(res[7]);
					//~ sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					$("#Adm_txttax1").html(data);
					//~ sum();
				});
			});
			$("#Adm_txtCode").change(function() {
				var a=$("#Adm_txtCode").val();
				var a2=$("#code").val();
				var pid = $("#1tag").val();
				$.ajax({
					url:"../get/post.php?p=geteachitem1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res=data.split(",");
					var ttt=res[2];
					$("#Adm_txtprice").val((res[2]));
					$("#Adm_txttax").html(res[0]);
					$("#qty_unit").html(res[1]);
					$("#hsn_code").val(res[3]);
					$("#Adm_txtPro").val(res[4]);
					$("#Adm_txtmrp").val(res[5]);
					$("#Adm_txtbuyprice").val(res[6]);
					$("#item_stock").val(res[7]);
					//~ sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res1=data.split(",");
					$("#Adm_txttax1").html(res1[0]);
					$("#Adm_txtPro").val(res1[1]);
					
					//~ sum();
				});
			});
		});
		     function sum() {				 
				    var item_stock=document.getElementById('item_stock').value;
					var qty = document.getElementById('Adm_txtqty').value;
					if(qty!=''){
						notifyPopup(item_stock);
					if(parseFloat(qty)<=parseFloat(item_stock) && parseFloat(qty)>=0 ){
				 
				var txtFirstNumberValue = document.getElementById('Adm_txtprice').value;
				var txttt = document.getElementById('Adm_txtDis').value;
				var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
				var result = parseFloat(txtFirstNumberValue).toFixed(2) * parseFloat(txtSecondNumberValue).toFixed(2);
				var resultdis=parseFloat(result)-parseFloat(txttt);
				if (!isNaN(resultdis)) {
					var re=parseFloat(resultdis).toFixed(2);
					
					function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}

						var nres=round(resultdis,2);
						//alert(resultdis);
				document.getElementById('Adm_txtamt').value = nres;
                	var totTax=parseFloat(document.getElementById('Adm_txttax').innerText)+parseFloat(document.getElementById('Adm_txttax1').innerText);
                	var totitemamt = document.getElementById('Adm_txtamt').value;
                	var a=parseFloat(totitemamt)*parseFloat(totTax);
                	var b=parseFloat(100)+parseFloat(totTax);
                	var c=parseFloat(a)/parseFloat(b);
                	var grossamt=parseFloat(totitemamt)-parseFloat(c);
					var grossItemRate = round(grossamt/txtSecondNumberValue,2);
					$('#grossItemRate').text(grossItemRate);
                	//alert(c);
                
                	
                	var rgrossamt=round(grossamt,2);
                	document.getElementById('grossamt').value=rgrossamt;
                		//salert(rgrossamt);
						//alert(typeof(rgrossamt));
                	var cgst=document.getElementById('Adm_txttax').innerText;
                	var sgst=document.getElementById('Adm_txttax1').innerText;
                	var d=parseFloat(grossamt)*parseFloat(cgst);
                	var totcgst=parseFloat(d) / parseFloat(100);
                	var e=parseFloat(grossamt)*parseFloat(sgst);
                	var totsgst=parseFloat(e) / parseFloat(100);
                	function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}

						var ncgst=round(totcgst,2);
						var nsgst=round(totsgst,2);
                	document.getElementById('Adm_txttax16666').innerText=ncgst;
                	document.getElementById('Adm_txttax17777').innerText=nsgst;
                	var amt=document.getElementById('Adm_txtamt').value;
						var sum = parseFloat(amt);
						document.getElementById('Adm_txtsum').innerText=sum.toFixed(2);
						var ctx=rgrossamt*cgst;
						var ctaxamt=ctx/100;
						
						var rctaxamt=round(ctaxamt,2);
}
				var grossRate = $('#grossamt').val();				
				$('#grossSum').text(grossRate);
			}
			else 
{
notifyPopup(item_stock);
document.getElementById('Adm_txtqty').value='';
}
		}
		
			}
		
					//~ if(parseFloat(txtyyumberValue) >0 && parseFloat(txtthird1NumberValue) >0 ) {
						
						//~ document.getElementById('Adm_txttax16666').innerText=n;
						//~ }else {
						//~ document.getElementById('Adm_txttax16666').innerText='0.00';
					//~ }
					
        function sum2(){
				var txtthirdNumberValue = document.getElementById('Adm_txtamt').value;
				var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
				var result1 = parseFloat(txtthirdNumberValue) / parseFloat(txtSecondNumberValue);
				document.getElementById('Adm_txtprice').value = result1;
                
			}
		 /*function sum3(){
				var txtthirdNumberValue = document.getElementById('Adm_txtamt').value;
				var txtyyumberValue=document.getElementById('Adm_txttax').innerText;
				var re = parseFloat(txtyyumberValue) * parseFloat(txtthirdNumberValue);
				var re1=re / 100;
				document.getElementById('Adm_txttax16666').innerText=re1;
                
			}*/
        function sum4(){
				var txt1NumberValue = document.getElementById('total-bal').innerText;
				var txt2Value=document.getElementById('collect').value
				var re = parseFloat(txt2Value) - parseFloat(txt1NumberValue);
				document.getElementById('c_diff').innerHTML=re.toFixed(2);
                
			}
		$("#toggelon").click(function(){
			if (document.getElementById("customer-off").style.display == "none")
			{
				document.getElementById('cash').style.pointerEvents = 'none';
			document.getElementById('credit').style.pointerEvents = 'none';
			$('#customer').attr('disabled',true);
			$('#cash').attr('disabled',true);
			$('#credit').attr('disabled',true);
			
			document.getElementById("customer-on").style.display="none";
			document.getElementById("customer-off").style.display="inline-block";
		}
		else
		{
			document.getElementById('cash').style.pointerEvents = 'auto';
				document.getElementById('credit').style.pointerEvents = 'auto';
			$('#customer').attr('disabled',false);
			$('#cash').attr('disabled',false);
			$('#credit').attr('disabled',false);
			//~ var val=11;
				//~ //alert("only cash");
			//~ document.getElementById("cash-credit").value=val;
			
			document.getElementById("customer-on").style.display="inline-block";
			document.getElementById("customer-off").style.display="none";
		}
		
	});
	$("#cash").click(function(){
		var val=11;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
				//alert("only cash");
			//document.getElementById("cash-credit").value="10";
			document.getElementById("cash").style.display="none";
			document.getElementById("credit").style.display="inline-block";
        $("#advDiv").show();
		
	});
	$("#credit").click(function(){
	var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			document.getElementById("credit").style.display="none";
			document.getElementById("cash").style.display="inline-block";
        $("#advDiv").hide();
		
	});
		 function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
					// document.getElementById("datelabel").innerHTML=value;
					 //alert(value);
					 
				 }
    
    function changeVal2(src, desti){
     
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
        
					 
				 }
				 
				//~ $("#date1").blur(function(){
					//~ alert($(this).val());
				//~ });
                function alertinput(){
                var div1 = document.getElementById("div1");
                    //~div1.setAttribute("align", "helloButton");
                    var align = div1.getAttribute("dataid");

                    alert(align); 
                }
                
            
	      
             
              
    // <!------  PDF Print -------------->
    var docSave = {};
     function printInv(){
                   
                     function parseTableHead(tabId) {
                        var tBody   =   new Array();
                        var tWidth  =   document.getElementById(tabId).rows[0].cells.length;
                            tBody[0] = new Array();
                                for(j = 0; j < tWidth; j++){ 
                                    tBody [0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10, };
                                }  
                         //console.log(JSON.stringify(tBody, null, 4));
                        return tBody;
                    }
                     function parseTableBody(tabId) {
                        var tHeight =   document.getElementById(tabId).rows.length;
                        var tBody   =   new Array();
                        for(i = 0, k = 1; k < tHeight -1; i++, k++){
                            var tWidth  =   document.getElementById(tabId).rows[i].cells.length;
                            tBody[i] = new Array();
                            for(j = 0; j < tWidth; j++){    //alert(document.getElementById(tabId).rows[k].cells[j].innerHTML);
															var x=document.getElementById(tabId).rows[k].cells[j].style.textAlign;
								switch (x)
									{
											case "right":
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'right' ,};
											break;
											case "left" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'left' ,};
											break;
											case "center" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'center' ,};
											break;
											default:
											 tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,};
										}
                                                             
															 } 
                          }
                        return tBody;
                    }
                    function parseTableFoot(tabId){
                        var tHeight =   document.getElementById(tabId).rows.length;
                        var tBody   =   new Array();
                        var k2      =   tHeight - 1;
                        var tWidth  =   document.getElementById(tabId).rows[k2].cells.length;
                        tBody[0] = new Array();
                        for(j = 0; j < tWidth; j++){     
                                                     
													 var x=document.getElementById(tabId).rows[k2].cells[j].style.textAlign;
														switch (x)
                                                        {
                                                                case "right":
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'right' ,};
                                                                break;
                                                                case "left" :
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'left' ,};
                                                                break;
                                                                case "center" :
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'center' ,};
                                                                break;
                                                                default:
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,};
                                                            }
                        


													 } 
                        //console.log(JSON.stringify(tBody, null, 4));
                        return tBody;
                     }

                  // pdfMake.createPdf({
                    var docDefinition = {
                        // a string or { width: number, height: number }
                           pageSize: {width: 585, height: 830},

                        // by default we use portrait, you can change it to landscape if you wish
                          pageOrientation: 'portrait',

                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                          pageMargins: [ 40,120, 40, 80 ],
                                 header: {
							  margin: [40, 30, 40, 35],
							  columns: [
								[
								{image:"data:image/png;base64,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VRS1Ou+++27uv/9+EokEl156qSbV9/T0EAQBmzZt4pOf/CQXXXSRVkIuXryYyy67jM9//vN87WtfA456UE2bNg0pJRdffDEPP/ww73jHO+ju7qa9vZ2LLrqIk046CQhFEXv27OGaa67h4osvRgjB7NmzOfPMM/niF79If38/APv27QNC/poQgn/5l3/hzDPP5JxzzkEIwZvf/GZ2795NNptFKaUn6cHBQcbGxsjlcqxevZo///M/Z9GiRVp0ceWVV3LDDTcwPDyM7/scOXKEW2/9OaVSBZBceeUbaWkOJ9auzmls3bqdkZEx4vEk3V09JJNJCvkKbW0dfPpTf8sHPvBBLrvsMr2969evp7Ozk9bWVvL5PF/96lc5/fTTWbRoER0dHbz61a/mP//zP3ULbdeuXYyMjDAxMcHo6Cif/exnueKKK1i4cCG2bdPU1MTFF1/M+9//fj7+8Y/ritJ73/teMpkMra2tzJs3j8985jN87Wtf47LLLiOdTtPa2sq73/1u7rvvPj1pfvjDH6a9vR0hBLNmzeLjH/84t912G/Pnz2fu3Ll0dXXxpje9ie985ztA6JmVTqeJx+MYhkF7ezvf/va3AXjyySe1Kjeysrj++usB+MpXvqL/bf78+bz5zW/mjjvu4BOf+ARLly5FCMHy5cv5wAc+wMTEBNVqlcHBQSDkmm3bto3PfOYznHXWWSxatAghRANIn8k111zDV7/6Vf3cfD5PPB5ncHCQf//3f+fcc8/lkksuQQjBsmXLKBaL+lhE5+vs2bPp7u5mzpw5tLS08P3vf59MJqPbkitWrNBA7Oabb8b3/Wf9KZVKCCFwXRchBN/61rfYv38/sViM973vfZx66qkawI+NjTF//nz+7u/+jgsuuECfAz/4wQ8A+OQnP8kFF1zA/fffz9y5c7n55ptpbm6mo6OD8847j//+7//miiuu4Bvf+AapVEpbykSihUjdGgQB69at43Of+xxve9vbOOussxBCMHPmTE499VT+z//5P3zkIx/B8zx+8pOf0NraihCC7u5u3vWud/Gzn/1MH690Ok1HRwf/9E//xK5duwDo7e3FcRy9CPzCF77AxRdfzMqVKxFCMGPGDE4++WTe//7385GPfITu7m59rEulEvV6neHhYUzTpFgssn//fn29P/HEE1xzzTVceOGFzJw5k2QyyaJFi7jooov4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dKZsOuMWRadO0avhAYEKFZdK1DGkhysCDKlIAJYy8JVqLDqOyZ7Xj54f8isjr8DjH5WUjecrhApe0CMBWBKkEsRQGCogEQTEEdjSQAgQpkQYCWxX4ngBo/kyw/k0WcMIRS32s++jbDbL4sWLtf/TkiVLNEk4spOIwqVPPvlk/u7v/o6VK1eyZs0avXI/+eSTWblypfbqGhoaYnR0lLGxMfr6+hgfHycWizFjxgyGh4cZGBigt7eXsbEx3cZsbm7mLW95C52dndo/K+LI/Mmf/AlvfetbOf3008lms7iuy4IFC/j7v/97ZsyYwZNPPsmaNWvI5/MsW7aMFStWMDQ0xPr16zly5IgmxMfjcVpbW/n4xz/OihUrePzxx3nooYe02nTFihWcccYZvOENbyCXy4Wt2pOXs2DBAtasXcP27dsZGhpi6dJFuiX7m9/8hr6+Pu0x193dzcqVK3n1q1/N297+FgAef/xxtmzZguu6Wi1Xq9XYvXu3bhGNjIxw8skna1AQtXOFELz//e9n6dKl3HbbbaxZswbXdTnvvPM466yzuOuuu+jt7dUt3cjWI6rotLS06NZUf38/iUSCs88+m1e/+tUaDIyMjOhzIeLtdXV10dLSwrZt2/A8jzlz5nDZZZfx9re/nTPPPFOTr9/1rnchpaSrq4s9e/bgui7z5s3j/PPP58QTT+S6667TC9hZs2ZpXlnErUsmkyxfvlyHnTc3N7N8+XLe9773cd555zE+Pk5raysrV67ks5/9LGeeeSb3338//f39WJbFwoULWbx4McuWLeORRx5h69atWkhhmibXXXcdN910E/fccw87d+6kWCyyePFibS3z1a9+lUKhwMTEBFu3btXnnJRSk+Ojtu3IyIgGGieccALz58+nXC7T1NSkbUHmzp2r484iA+nIHT9SUC9cuJCrr76ak08+mbvvvpve3l52795NW1sby5cv59xzz+X888/nzDPP1AAn4uqlUile//rXM2vWLB599FHWrVunq57z589n4cKFvP3tbyedTrN27VqdGtLU1MTChQs5//zzNS9u48aN3HnnnbS2tpLL5Zg/fz5CCJ588klWr17N3r17GRsbY/r06TQ3N+sW5RlnnMGGDRvYt28fHR0dLF26lKuuuopLLrlECxEWLVrEJz/5Sdra2vjVr37F4cOHQ0HO4sWcc845HDhwgDvu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", alignment: 'center',width: 150},
									
                                        {text: ''+document.getElementById("address-line1").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ''+document.getElementById("address-website").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ''+document.getElementById("address-phone").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ' ', fontSize: 7, alignment: 'center', margin: [ 10, 2, 10, 0]},
                                       ]
							
							  ]
	  
						  },
 
                           content: [
                                         {
											 columns: [
												{width: 80, text: 'INVOICE No', fontSize: 10, bold: true, alignment: 'left'},
												{width: 150, text: ': '+document.getElementById('invNum').innerHTML, fontSize: 10, alignment: 'left'},
												{width: 100, text: 'INVOICE', fontSize: 10, bold: true, alignment: 'left'},
												{width: 55, text: 'State', fontSize: 10, bold: true, alignment: 'left'},
												{width: 100, text: ': Kerala', fontSize: 10, alignment: 'left'}		
											],
                                 			margin: [0,5]
										},       
                                        {
											columns: [ 
												{width: 80, text: 'Date of issue',  fontSize: 10, bold: true, alignment: 'left'},
												{width: 110, text: ': '+document.getElementById('datePrint').innerHTML, fontSize: 10, alignment: 'left'},
												{width: 140, text: 'GSTIN : ', fontSize: 10, bold: true, alignment: 'left'},
												{width: 55, text: 'State Code',   fontSize: 10, bold: true, alignment: 'left'},	
												{width: 100, text: ': 32', fontSize: 10, alignment: 'left'}							
											],
                                 			margin: [0,5]
										},    
										{
											style: 'tableExample',
											table: {
														widths: [248,248],
														body: [
															['Given to ', 'Company'],
															[
																{
																	text: [
																			{width: 80, text: 'Name', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('customerPrint').innerHTML, fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: 'Address', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('custaddress').innerHTML, fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: '', fontSize: 10, bold: true},
																			{text: '\n', italics: true},
																			{width: 80, text: 'GSTIN', fontSize: 10, bold: true},	
																			{width: 150, text: ': '+document.getElementById('custgstin').innerHTML, fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: 'State', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('custstate').innerHTML, fontSize: 10},
																			{width: 80, text: '\nPhone', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('custphone').innerHTML, fontSize: 10}
																		]
																}, 
																{
																	text: [															
																			{width: 80, text: 'Name', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('brand-name').innerHTML, fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: 'Address', fontSize: 10, bold: true},
																			{width: 150, text: ': '+document.getElementById('address-line1').innerHTML, fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: '', fontSize: 10, bold: true},
																			{text: '\n', italics: true},
																			{width: 80, text: 'GSTIN', fontSize: 10, bold: true},																	
																			{width: 150, text: ': ', fontSize: 10},
																			{text: '\n', italics: true},
																			{width: 80, text: 'State', fontSize: 10, bold: true},
																			{width: 150, text: ': Kerala ', fontSize: 10}						
																		]
																}
															]
													]
												}
											},   							
                                        	{
												table: { 
                                            		widths: [ 15,150,48,35,30,20,33,20,33,40],
                                            		body: parseTableHead("invPTable") 
												}, 
												layout: '' 
											},										                                           						
                                        	{
												table: {
                                                	widths: [ 15,150,48,35,30,20,33,20,33,40],
													margin: [10,0,10,0],
                                                 	body: parseTableBody("invPTable") 
												}, 
												layout: '' 
											},                                       
                                        	{
												table: {
                                                	widths: [ 15,150,48,35,30,20,33,20,33,40],
												    body: parseTableFoot("invPTable") 
												}, 
												layout: '' 
											},                                        
                                        	{
												style: 'tableExample',
												table: {
														widths: [505],
														body: [
																[
																	{
																		text: 'Amount: '+inWords(round(parseInt($('#totamt').text()),0))+' Rupees only '
																	}
																],
															]
														}
											},																			
											{
												style: 'tableExample',
												table: {	
															heights: [100],
															widths: [162,130,195],
															body: [
																[
																	{
																		text:[
																				{text:'Terms & Conditions', alignment: 'left', fontSize: 9, bold: true},
																				{text:'', alignment: 'left', fontSize: 9},
																				{text:' ', alignment: 'left', fontSize: 9, bold: true},
																				{text:'', alignment: 'left', fontSize: 9},
																				{text:' ', alignment: 'left', fontSize: 9, bold: true},
																				{text:'', alignment: 'left', fontSize: 9},
																			]
																	},
																	{
																		text: '(Common seal)',alignment: 'center'
																	},
																	{
																		text:[
																			{text:'Certified that the particulars given above the true and correct', fontSize: 7},
																			{text: '\n', italics: true}, { text: 'FOR WINPRO', fontSize: 10,bold: true},
																			{text: '\n', italics: true},{width: 80, text: '', fontSize: 10, bold: true},
																			{text: '\n', italics: true},{ text: 'Authorised Signatory', fontSize: 10}
																		]
																	}
																]
															]
														}
											},						                                                                             											                                   
                                    ]                                  
                      }

//).print( function() { alert('your pdf is done'); });
docSave = jQuery.extend(true, {}, docDefinition);
 return pdfMake.createPdf(docDefinition);
                }     
    
    
//                function PrintDiv(divId)
//                {
//                    var printwindow = window.open('', 'PRINT', 'height=700px; width=1000px');
//                    printwindow.document.write('<html><head>');
//                    printwindow.document.write('<title>Invoice</title>');
//                    
//                    printwindow.document.write('<style>@font-face{ font-family:Roboto; src:url(fonts/Roboto-Regular.ttf);} *{font-family: Roboto,sans-serif;} @page{margin: 0; width: 21cm; height: 29cm;} .no-print{display: none;} button{display: none;} input{display: none;} .print-only{display: inline-block;} p{margin: 0; padding: 0;} .form-control{border: none; width: 2cm;} .print-area{margin: 1.5cm; display: block; position: relative; overflow: hidden;} .-txt{text-align: right;} .bal-notify{display: none;} .brand{display: block; text-align:center; font-size:24pt; font-weight: bold;} .address, .contact{text-align: center; font-size: 10pt} .invoice-table{border-collapse: collapse; border: 1px solid #000; margin-bottom: 3cm; margin-top:.25cm;} .invoice-table td, .invoice-table th{border: 1px solid #000;} .input-group-addon::after{content: " : ";} #total-amt{position: absolute; right: 0cm; bottom: 2.5cm; font-size: 16pt; font-weight: bold;} #disPrint::before{content: "Discount : "} #disPrint{position: absolute; right: 0; bottom: 2cm; font-size: 14pt;} #total-amt::before{content: "Bill Amount : ";} #total-bal::before{content: "Amount : ";}  #total-bal{position: absolute; right: 0; bottom: 1.5cm; font-size: 14pt;}  #collect_amt{position: absolute; right: 0; bottom: 1cm; font-size: 14pt;} #bal_amt{position: absolute; right: 0; bottom: 0.5cm; font-size: 14pt;} .footer{text-align: center;} .print-left, .print-right{display: inline-block;} .print-left{float: left;} .print-right{float: right} .row{width: 100%; clear: both; margin: none;} .b-type::before{content: "Bill Type : "} .table{width: 100%;}          .siNo{width: 5%;} .sQty{width: 8%;} .sRate{width: 10%;} .sAmt{width: 15%;} .tax{width: 8%;} table{}  </style>');
//                    
//                    printwindow.document.write('</head><body><div class="print-area">');
//                    printwindow.document.write(document.getElementById("invoice-head").innerHTML);
//                    printwindow.document.write(document.getElementById(divId).innerHTML);
//                    printwindow.document.write(document.getElementById("invoice-footer").innerHTML);
//                    printwindow.document.write('</div></body></html>');
//                    printwindow.document.close(); // necessary for IE >= 10
//                    printwindow.focus(); // necessary for IE >= 10*/
//                    printwindow.print();
//                    printwindow.close();
//                    return true;
//                }
           
function printBill(){
printInv();
}
    
    $(function(){$("#invNoPrint").text($("#retail").val())
                 changeVal('AdmtxtDate','datePrint');
                });
    // <!------  HTML Print -------------->
  
        // <!------  HTML Print -------------->
     function PrintDiv(divId)
                {   var kl = 2;
                    var printwindow = window.open('', 'PRINT', 'height=700px; width=1000px');
                    printwindow.document.write('<html><head>');
                    printwindow.document.write('<title>TAX INVOICE</title>');
    
                    printwindow.document.write('<style> @page{margin: 0; width: 21cm; height: 29cm;}\
.print-area{margin: 1.75cm 1.25cm 1.25cm 1.25cm; display: block; position: relative; overflow: hidden; border: 1px solid black;}  \
*{font-family: Roboto, sans-serif; font-size: 13px;}\
.no-print{display: none;}\
#brand-name{text-align: center; font-size:24pt; font-weight: bold; font-family:Forte, sans-serif;}\
.address, .contact{text-align: center;}\
.boldItalics{font-weight: bold; font-style: italic; padding-right: 2mm;}\
p{margin: 0; padding: 0;} \
#invoice-container{}\
.full-width{width: 18.1cm; border-collapse: collapse; clear: both;}\
.column-sperator td{border-collapse: collapse; border: 1px solid black;}\
.-txt{text-align: right;} .-txt-{text-align: center;} .txt-{text-align: left;}\
#invPTable{height: 15.5cm;}\
#invPTable th{border-collapse: collapse; border-bottom: 1px solid black; }\
#invPTable th, #invPTable td{border-collapse: collapse; border-right: 1px solid black;}\
    </style>');
                    printwindow.document.write('</head><body><div class="print-area">');
                    
                    printwindow.document.write('<div id="invoice-container">');

                    printwindow.document.write('<table class="full-width"><tr><td class="-txt-" style="border-collapse: collapse; border-bottom: 1px solid black;">');
                    printwindow.document.write('<div style="clear: both;"><span style="float: left; padding: 1mm 0 0 1mm;">'+$("#pGst").text()+'</span><span style="float: right; padding: 1mm 2mm 0 0;">'+$("#address-phone").text()+'</span></div>');
                    printwindow.document.write('<div class="full-width"></div>');
                    printwindow.document.write(document.getElementById("invoice-head").innerHTML);
                    printwindow.document.write('<span style=" text-align:center; padding: 0.1cm; font-weight: bold; font-size: 20px;">TAX INVOICE</span></td></tr></table>');
                    
                    printwindow.document.write('<table class="full-width">\
<tr>\
<td style="border-collapse: collapse; border-bottom: 1px solid black; border-right: 1px solid black;  padding: 0.1cm; width: 8.85cm;">To: '+$("#customerPrint").text()+ '</br> PHONE : '+$('#custphone').text()+' </br> '+$('#custaddress').text()+' </br> '+$('#custcity').text()+' &nbsp; &nbsp; '+$('#custstate').text()+' </br> GSTIN: '+$('#custgstin').text()+' &nbsp; &nbsp; STATE CODE :  '+$('#custstatecode').text()+'</td>\
<td style="border-collapse: collapse; border-bottom: 1px solid black; text-align:left; padding-top: 1mm; padding-bottom: 5mm; padding-left: 0.5cm;">\
<div style="width: 4cm; display: inline-block;">Date:  '+$("#AdmtxtDate").text() +' <br> Bill: '+$("#invNoPrint").text()+' </br>  Vehicle: '+$("#vehPrint").text()+'</div>\
<div style="width: 4cm; display: inline-block;">STATE CODE: '+$("#state_codePrint").text()+' </br>STATE: '+$("#statePrint").text() +'<br>&nbsp;</div>\
\
</td>\
</tr>\
</table>');
                    printwindow.document.write(document.getElementById('invPTableC').innerHTML);
                    printwindow.document.write('Amount in Words: <span style="font-style: italic; font-weight: bold;"> '+inWords(parseFloat($("#nettAmtPrint").text()))+' Rupees only </span>');
                    printwindow.document.write('<div style="width:100%;height:1.2cm;"></div>');
                    printwindow.document.write('<div style="padding-left: 1mm; text-align: center;"><span class="-txt-" style="font-size: 14px; text-decoration: underline;">DECLARATION</span></div>');
                    printwindow.document.write(' </div> We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.');
                    printwindow.document.write('<table class="full-width">\
<tr>\
<td style="border-collapse: collapse; border: 1px solid black; width: 50%;"> CUSTOMER <br><br> <br>Seal & Signature</td>\
<td style="border-collapse: collapse; border: 1px solid black;">For YUKTHA ENTERPRISES <br><br> <br> Authorised Signature</td>\
</tr>\
</table');
                 
                    
                    
                    
                    
                    
                    
                    printwindow.document.write(document.getElementById("invoice-footer").innerHTML);
                    printwindow.document.write('</div></div></body></html>');
                    printwindow.document.close(); // necessary for IE >= 10
                    printwindow.focus(); // necessary for IE >= 10*/
                    printwindow.print();
                    printwindow.close();
                    return true;
                }
    // <!------  HTML Print -------------->
       
           
           
            </script>
