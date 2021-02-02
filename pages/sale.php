<?php 

	include("../include/include.php"); 
		check_session();
		html_head();
		$sql="SELECT AUTO_INCREMENT as eno
		FROM information_schema.tables
		WHERE table_name = 'ti_sale_invoice'";
		$s=$conn->query($sql); $res=$s->fetch();
		$query="select max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_type=0 and ti_sale_invoice.IsActive=1";
		$s1=$conn->query($query); $res1=$s1->fetch();
		$query1="select max(ti_sale_invoice.invoice_num)+1 as inv_no,max(ti_sale_invoice.invoice_id)+1 as inv_id from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and   ti_sale_invoice.sale_type=1 and ti_sale_invoice.IsActive=1";
		$s12=$conn->query($query1); $rwhole=$s12->fetch();
		$query2="select max(ti_sale_invoice.invoice_num)+1 as inv_no,max(ti_sale_invoice.invoice_id)+1 as inv_id from ti_sale_invoice where ti_sale_invoice.IsHidden=10 and   ti_sale_invoice.sale_type=0 and ti_sale_invoice.IsActive=1";
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
  <h2 style="margin-top:0;">Sales Invoice</h2>
            <div class="form-container" id="invoice">
                <button onclick="printInv().print();" class="screen">Print</button>
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
                                        <input type="number"   class="form-control  -txt" id="whole" style="display:none" value="<?php  echo isset($rwhole['inv_no']) ? $rwhole['inv_no']:'1';?>" onchange="changeid();">
                                        <span class="input-group-addon">
                                         <span><i class="fa fa-play" id="btnsaleedit" style="" aria-hidden="true"></i></span>
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
                                        <input class="form-control" type="text" name="discount" id="dis" onblur=" discCal(); changeVal('dis','disPrint')" value="0"> 
                                        
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
                                       <input type="text" name="customer" id="customer" class="form-control" disabled  required onblur="changeVal('customer','customerPrint')" />
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
										 <input type="hidden" id="cash-credit"  name="cash_credit" value="10">
                                    <span  id="cash"  class="b-type btn btn-primary" disabled>Cash</span>
                                    <span  id="credit" style="display:none;"  class="b-type btn btn-primary btn-credit" disabled >Credit</span>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button class="btn btn-primary" onclick="PrintDiv('invoice');">Print</button>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
                                  <th rowspan="2" colspan="2" class="sDis">Discount</th>
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
									<td colspan="2">
									<input type="text" name="discount"    id="Adm_txtDis" class="form-control -txt" tabindex="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  value=0  onkeyup="sum();">
								</td> 
								<td class="-txt" colspan="2">
									<span id="Adm_txtsum"></span>
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
								<td colspan="2"name="totamt" class="totamt -txt" id="totamt"  colspan="2" value="0">0.00</td>
								<td class="-txt no-print"></td>
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
             <?php $quer="SELECT * FROM `master_company` WHERE 1";
            $set=$conn->query($quer);
            $set->setfetchmode(PDO::FETCH_ASSOC);
            while($ss=$set->fetch()){
            ?>
            <div class="print-only" id="invoice-head">
                <p id="brand-name"><?php echo $ss['c_name'];?></p>
                <p class="address" id="address-line1"><?php echo $ss['address_1']; ?></p>
                <p class="contact"><span class="no-print" > <?php echo $ss['website']; ?> </span>  <span class="" id="address-website" ><?php echo $ss['mailid']; ?></span> </p>
                <p class="print-left no-print no-screen">CIN :<?php echo $ss['cin']; ?> </p>
            </div>
           <div class="print-only" id="invoice-head1">
            <p class="contact" style=""; > <span class="" id="address-phone">Phone : <?php echo $ss['phone']; ?> |  <?php echo $ss['mobile']; ?></span></p>
            <p id="pGst" class> GSTIN :<?php echo $ss['gstin'];?>  </p>
           <div id="salesManPrint"></div>
</div>
<div id="statePrint" class="no-screen"><?php echo $ss['state']; ?></div>
<div id="state_codePrint" class="no-screen"><?php echo $ss['state_code'];?></div>
  <?php }?>
            <div id="invNum" class="no-screen"></div>
            <!---------Invoice Table ---------->
<div id="invPTableC" class="no-screen">
    <table id="invPTable" class="full-width">
                <thead>
                    <tr style="height: 7mm;">
                        <th style="width: 8mm;">No</th>
                        <th style="width: 20mm;">Item</th>
                        <th style="width: 20mm;">Rate in (SAR)</th>
                        <th style="width: 20mm;">Qty</th>
                        <th style="width: 20mm">UoM</th>
                        <th style="width: 20mm;">Amount in (SAR)</th>
                    </tr>
                </thead>
                    
                <tbody class="ptBody">
                  
                    <tr style="height: 7mm;">
                        <td style="text-align: left;"></td>
                        <td class="-txt boldItalics"  style="text-align: right;">ROUNDING OFF</td>
                        <td style="text-align: left;"></td>
                        <td style="text-align: left;"></td>
                        <td style="text-align: left;"></td>
                        <td id="roundoffPrint" style="text-align: right;"></td>
                    </tr>
                 
                </tbody>
                
                <tr style="border-collapse: collapse; border-top: 1px solid black;">
                    
                    <td  style="border: none; text-align: left;" ></td>
                    <td id="pTotSgst" style="text-align: right;" >Grand Total</td>
                    <td  style="border: none; text-align: left;" ></td>
                    <td  style="border: none; text-align: left;" ></td>
                    <td  style="border: none; text-align: left;" ></td>
                    <td style="border-collapse: collapse; border: 1px solid black; text-align: right;" id="nettAmtPrint"></td>
                </tr>
            </table>
            <div id="amtInDigits"></div>
</div>
            


            <!---------Invoice Table ---------->
            <!---------Invoice head  ---------->
            <!---- Invoice Footer------->
            <div class="print-only" id="invoice-footer">
                <p class="footer"></p>
            </div>
            <!---- Invoice Footer------->
    <?php
    html_close();
     ?>

<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
 <?php  if(isset($_SESSION['did']) && $_SESSION['did'] !='') { ?>
  notify("danger","Deleted");
    <?php  unset($_SESSION['did']);  } ?>
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
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
        maxDate: new Date(2020, 12, 31),
        yearRange: [2016,2020],
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
                        html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="grossamt" value="'+$('#grossamt').val()+'" name="grossamt[]"/>'+$('#grossamt').val()+'</td>'; //GROSS
                        html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtmrp" value="'+$('#Adm_txtmrp').val()+'" name="Adm_txtmrp[]"/>'+$('#Adm_txtmrp').val()+'</td>'; //
                        html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtbuyprice" value="'+$('#Adm_txtbuyprice').val()+'" name="Adm_txtbuyprice[]"/>'+$('#Adm_txtbuyprice').val()+'</td>';
                        html+='<td class="no-screen no-print"><input type="hidden" class="totdiff" id="totdiff"></td>';
                        html +='<td colspan="2" class="-txt"><input type="hidden" class="Adm_txtsellingprice" value="'+$('#Adm_txtprice').val()+'" name="buyprice1[]"/>'+$('#Adm_txtprice').val()+'</td>';
                        html +='<td  colspan="2"><input type="hidden" value="'+$('#hsn_code').val()+'" name="buypri[]"/>'+$('#hsn_code').val()+'</td>';    //HSN
                        html +='<td colspan="2" class="-txt"><input type="hidden" class="qty" value="'+$('#Adm_txtqty').val()+'" name="qty1[]"/>'+$('#Adm_txtqty').val()+ '</td>';
                        html +='<td colspan = "2"> '+$('#qty_unit').val()+$('#qty_unit').text()+'</td>'; //QTY
                        html +='<td class="no-print"><input type="hidden" id="taxcgsttax"  class="cgst" value="'+$('#Adm_txttax').text()+'" name="cgst[]"/>'+$('#Adm_txttax').text()+'</td>';
                        html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax16666').text()+'" name="tax1[]"/>'+$('#Adm_txttax16666').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" class="tax" value="'+$('#Adm_txttax16666').text()+'" name="cgstamt[]"/>'+$('#Adm_txttax16666').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" id="taxsgsttax" class="sgst" value="'+$('#Adm_txttax1').text()+'" name="sgst[]"/>'+$('#Adm_txttax1').text()+'</td>';
                        html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax17777').text()+'" name="tax2[]"/>'+$('#Adm_txttax17777').text()+'</td>';
                        html +='<td class="no-print"><input type="hidden" class="tax1" value="'+$('#Adm_txttax17777').text()+'" name="sgstamt[]"/>'+$('#Adm_txttax17777').text()+'</td>';
                         html +='<td colspan="2" class="-txt"><input type="hidden" class="disprice" value="'+$('#Adm_txtDis').val()+'" name="disprice1[]"/>'+$('#Adm_txtDis').val()+'</td>'; //DISCOUNT
                        html +='<td colspan="2" class="-txt"><input type="hidden" class="sum" value="'+$('#Adm_txtsum').text()+'" name="added1[]"/>'+$('#Adm_txtsum').text()+'</td>'; //AMOUNT
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
                    var ptRow = '<tr style="height: 7mm;" class ="pt_row" id = "r'+tblRowCount+'" >';
                        ptRow +='<td class="td_sl"></td>';
                        ptRow +='<td>'+$('#Adm_txtPro').val()+'</td>';
                        ptRow +='<td>'+$('#Adm_txtprice').val()+'</td>';
                        ptRow +='<td>'+$('#hsn_code').val()+'</td>';
                        ptRow +='<td>'+$('#Adm_txttax').text()+'</td>';
                        ptRow +='<td>'+$('#Adm_txttax1').text()+'</td>';
                        ptRow +='<td>'+$('#Adm_txtqty').val()+'</td>';
                        ptRow +='<td>'+$('#qty_unit').text()+ '</td>';
                        ptRow +='<td>'+$('#grossamt').val()+'</td>';
                        ptRow +='</tr>'
                    $('.ptBody').prepend(ptRow);

			
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
                 var roundtotPrint=parseFloat(totamtfraction)+parseFloat($('#fraction').val());
			  $("#roundtotPrint").text(round(roundtotPrint,2).toFixed(2));
				$("#nettAmtPrint").text(round(roundtotPrint,2).toFixed(2));
                $("#roundoffPrint").text($('#fraction').val());
                //$("#totCgstPrint").text(parseFloat(tottax).toFixed(2));
               // $("#totSgstPrint").text(parseFloat(tottax1).toFixed(2));
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
                            for(j = 0; j < tWidth; j++){   
							var x=document.getElementById(tabId).rows[k].cells[j].style.textAlign;
								switch (x)
									{
											case "right":
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 10,alignment:'right' ,};
											break;
											case "left" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 10,alignment:'left' ,};
											break;
											case "center" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 10,alignment:'center' ,};
											break;
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

                    return pdfMake.createPdf({
                        // a string or { width: number, height: number }
                          pageSize: {width: 585, height: 830},

                        // by default we use portrait, you can change it to landscape if you wish
                          pageOrientation: 'portrait',

                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                          pageMargins: [ 43, 175, 22, 120 ],
                        //background layer
                         background:{  image: "data:image/jpeg;base64,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", width: 350,margin: [ 100, 180, 0, 0]},
                                   header:{
                                    margin: [40, 40, 40, 60],
                                    columns: [
                                               [
                                                {image:"data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjdDMTQzODY0QjU1RTExRTc5NDY2Q0FCQTk3RTg1REY0IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjdDMTQzODY1QjU1RTExRTc5NDY2Q0FCQTk3RTg1REY0Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6N0MxNDM4NjJCNTVFMTFFNzk0NjZDQUJBOTdFODVERjQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6N0MxNDM4NjNCNTVFMTFFNzk0NjZDQUJBOTdFODVERjQiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYG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",width: 500},
                                                { text: ''+document.getElementById("address-line1").innerHTML, fontSize: 10, alignment: 'center', margin: [ 10, 0]},
                                                {text: ''+document.getElementById("address-phone").innerHTML + ' |  email:  '+document.getElementById("address-website").innerHTML, fontSize: 10, alignment: 'center', margin: [ 0,0,0,3]},
                                                { canvas: [{ type: 'line', x1: 0, y1: 2, x2: 505, y2: 2, lineWidth: 1 }] },
                                                { columns: [
                                                    { width: '50%', text: ''+document.getElementById("AdmtxtDate").value, fontSize: 10, margin: [ 3,15,3,5] },

                                                    [{ width: '50%', text: 'Bill No: '+document.getElementById("invNum").innerHTML, fontSize: 10, alignment: 'right',margin: [ 3,15,3,5] },
                                                    { width: '50%', text: 'Shop No: '+document.getElementById("shop_num").value, fontSize: 10,alignment: 'right', margin: [ 3,5,3,5] }],
                                                  ],
                                                  // optional space between columns
                                                  columnGap: 10
                                                },
                                                { columns: [
                                                    { width: '50%', text: 'To: '+document.getElementById("customer").value, fontSize: 10, margin: [ 3,5,3,5] },
                           

                                                    { width: '50%', text: 'Salesman: '+document.getElementById("salesManPrint").innerHTML, fontSize: 10, alignment: 'right',margin: [ 3,5,3,5] }
                                                     
                                                  ],
                                                  // optional space between columns
                                                  columnGap: 10
                                                },
                                                
                                              
                                                ] 
                                            ]
                                        },
                              footer: {
                                    margin: 40,
                                columns: [
                                  'Customer Signature',
                                  {     columns: [
                                           [{text: 'For MODERN WORLD ISOLATORS', alignment: 'right'}] 
                                                ]
                                         }
                                ]
                              },
                           content: [   
                                     
                                        
                                       
                                        
                                        { canvas: [{ type: 'line', x1: 0, y1: 2, x2: 500, y2: 2, lineWidth: 0.5 }] },
                                        {table: { 
                                            widths: [ 30, '*', 40, 40, 40, 60, 10 ],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
										{ canvas: [{ type: 'line', x1: 0, y1: 2, x2: 500, y2: 2, lineWidth: 0.5,dash: {length: 2} }] },
                                        {table: {
                                                widths: [ 30, '*', 40, 40, 40, 60, 20 ],
                                                 body: parseTableBody("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: 0, y1: 2, x2: 500, y2: 2, lineWidth: 0.5,dash: {length: 2} }] },
                                        {table: {
                                                widths: [ 30, '*', 10, 40, 40, 100, 20],
                                                 body: parseTableFoot("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: 0, y1: 2, x2: 500, y2: 2, lineWidth: 0.5 }] },
                                        {text: 'Amount: '+inWords(parseInt($('#nettAmtPrint').text()))+' Saudi Riyal', fontSize: 10, alignment: 'left', margin: [0,10,0,10]},
                                        {text: '***** THANK YOU FOR YOUR BUSINESS  *****', fontSize: 10, alignment: 'center', margin: [0,40,0,20]}       
                               
                                    ]
                      });
                }   
    
<!------  PDF Print -------------->
    $(function(){$("#invNoPrint").text($("#retail").val())
                 changeVal('AdmtxtDate','datePrint');
                });
    <!------  HTML Print -------------->
  
        <!------  HTML Print -------------->
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
                    printwindow.document.write('Amount in Words: <span style="font-style: italic; font-weight: bold;">Rupees '+inWords(parseFloat($("#nettAmtPrint").text()))+' only </span>');
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
    <!------  HTML Print -------------->
       
           
           
            </script>
