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
                                    <button class="btn btn-primary" onclick="printInv().print(); pdfMake.createPdf(docSave).download('invoice'+$('#invNum').text());">Print</button>
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
                          pageMargins: [ 40,125, 40, 80 ],
                                 header: {
							  margin: [40, 30, 40, 35],
							  columns: [
								[
								{image:"data:image/jpeg;base64,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", alignment: 'center',width: 120, margin: [ 0, 12]},
									
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
												{width: 50, text: 'GSTIN : ', fontSize: 10, bold: true, alignment: 'left'},
												{width: 100, text: ''+document.getElementById('gst').innerHTML, fontSize: 10, alignment: 'left'},
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
																			{width: 150, text: ': '+document.getElementById('gst').innerHTML, fontSize: 10},
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
																			{text: '\n', italics: true}, { text: 'FOR '+document.getElementById('brand-name').innerHTML, fontSize: 10,bold: true},
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
