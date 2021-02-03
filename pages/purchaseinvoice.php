<?php 

include("../include/include.php"); 
check_session();
 html_head();
	$sql="select max(ti_purchase_invoice.invoice_id)+1 as eno from ti_purchase_invoice  ";
	$s=$conn->query($sql); $res=$s->fetch();
?>
<?php navbar_user(2); ?>       
            <h2 style="margin-top:0;">Purchase Invoice</h2>
            <div class="form-container" id="invoice">
               <form  id="frmenquiry" name="frmenquiry" action="../add/purchase_invoice.php" method="post">
                    <div class="invoice-head col-md-12">
                        <div class="col-md-6 right-border">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Date</span>
                                        </span>
                                        <input class="form-control" type="text" name="date" id="pur_date" value="" onblur="changeVal('pur_date','datePrint')" required tabindex=""/>
                                    </div>
                                    <div class="form-control print-only" id="datePrint"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill#</span>
                                        </span>
                                        <input class="form-control" type="text" name="in_no" id="p-inv-no" value="" onblur="changeVal('p-inv-no','inv-print')" required tabindex="1"/>
                                    </div>
                                    <div class="form-control print-only" id="inv-print"></div>
                                </div>
                                <div class="row no-screen">
                                        <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <span>Off</span>
                                            </span>
                                           <input class="form-control" type="text" name="discount" id="dis"  onblur=" discCal();" value="0"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 input-label no-screen">
                                        <select  id="select" name="select"  class="form-control" onchange="discCal();">
                                            <option value="1">%</option>
                                            <option value="2">Flat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill Type</span>
                                        </span>
                                        <select id="selecttax" name="selecttax" onblur="hideType();" class="form-control" >
                                            <option value="1">With Tax</option>
                                            <option value="2">Without Tax</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Supplier</span>
                                        </span>
                                      <input type="text" name="supplier" id="supplier" required class="form-control"   onblur="changeVal('supplier','supplierPrint')" tabindex="2">
                                      <input type="hidden" name="sup_id" id="sup_id" value="1">
                                       <?php
                                      /* $query="select id as k,name as v from ti_suppllier ";
									$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
									$k= $result['k'];
									foreach($result as $r) {
									$k=$r['k'];
									echo "<option data-code=\"".$r['k']."\" value=\"".$r['v']."\" />".$r['v']."</option>";
									//echo "<input type='text' name='code' id='code' data-id=\"".$r['k']."\" value=\"".$r['k']."\" /></option>";
			
									} */?>
                                       <span class="input-group-addon" id="toggelon">
                                            <span  class="toggle-btn" id="customer-on"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
                                            <span style="display:none;" class="toggle-btn" id="customer-off"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>
                                        </span>
                                    </div>
                                    <div class="form-control print-only" id="supplierPrint"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 right-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Invoice ID</span>
                                        </span>
<!--
                                       <label class="form-control" id="lblinvid" ><?php// echo  isset($res['eno']) ? $res['eno']:'1'; ?></label>
-->
						              <input type="number" name="in_id" id="in_id" class="form-control -txt" value="<?php echo isset($res['eno']) ? $res['eno']:'1'; ?>" >
						               <span class="input-group-addon">
                                           <span><i class="fa fa-play" id="btnsaleedit" style="" aria-hidden="true"></i></span>
                                        </span>
                                    </div>  
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Balance</span>
                                        </span>
                                        <span class="form-control" id="bal-amt"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!---replace---->
                            <div class="row">
                            <div class="col-md-4 -txt-">
                                  <input type="hidden" id="cash-credit"  name="cash_credit" value="11">
                                    <span  id="cash" style="display:none;" class="b-type btn btn-primary" >Cash</span>
                                    <span  id="credit"  class="b-type btn btn-primary btn-credit"  >Credit</span>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button class="no-screen btn btn-primary" onclick="PrintDiv('invoice')">Print</button>
                                </div>
                                <div class="col-md-4 -txt-">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            <!---replace---->
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12 input-group">
                                    <span class="input-group-addon">
                                        <span>Bill Amt</span>
                                    </span>
                                    <span class="form-control red -txt" id="total-amt">0.00</span>
                                </div>
                                <div class="col-md-12 input-group" id="advFeild" style="display: none;">
                                    <span class="input-group-addon">
                                        <span>Advance</span>
                                    </span>
                                    <input class="form-control" type="text" name="advance_amt" id="advance_amt"  value="0" onblur="calcadv();">
                                     <input type="hidden" id="difference" name="difference" >
                                     <input id="setHidden" hidden name="hidden" value="10" />
                                </div>
                            </div>
                            
                            
                               <div class="red -txt no-screen"  >
								   0.00
                            </div>
                               <div class="red -txt no-screen" id="total-bal" >
								   0.00
                            </div>
                        </div>
                    </div>
                    <div class="invoice-body col-md-12">
                        <div class="focusGuard" id="focusFirst" tabindex="3"></div>
                        <table class="table invoice-table">
							<tbody class="tbody">
                            <tr>
                                <th rowspan="2" colspan="2" class="siNo">No</th>
                                <th rowspan="2" colspan="2" class="sItem">Item &nbsp;  <i class="fa fa-plus-square" id="btnAddCust" aria-hidden="true"></i></th>
                                <th rowspan="2" colspan="2" class="sRate">Rate</th>
                                <th rowspan="2" colspan="2" class="sQty">Qty</th>
                                <th rowspan="2" colspan="2" class="sUom">UoM</th>
                                <th rowspan="2" colspan="2" class="sQty">CESS</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                <th rowspan="2" colspan="2" class="gAmt" style="display: none;" >G.Amount</th>
                                <th rowspan="2" colspan="2" class="pAmt">Amount</th>
                                <th rowspan="2" colspan="2" class="sAdd no-print">&nbsp;</th>
                            </tr>
                            <tr>
                                <th rowspan="1">%</th>
                                <th rowspan="1">Amt</th>
                                <th rowspan="1">%</th>
                                <th rowspan="1">Amt</th>
                            </tr>
                             <tr class="no-screen">
                                <th colspan="2" class="siNo">No</th>
                                <th colspan="2" class="sItem">Item</th>
                                <th colspan="2" class="sRate">Rate</th>
                                <th colspan="2" class="sRate">HSN</th>
                                <th colspan="2" class="sQty">Qty</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                <th colspan="2" class="sAmt">Amount</th>
                            </tr>
                            <tr class="datainput">
								<td class="S/Num -txt" colspan="2">&nbsp;</td>
								<td class="sCode" colspan="">
								    <input type="text" name="code" id="Adm_txtCode" value="" class="form-control no-print" tabindex="4">
									<input type="hidden" id="1dCode" value="">
								</td>
								<td class="table-item" colspan="">
									<input type="text" name="proname"  id="itemName" value="" class="form-control" required tabindex="5">
									<input type="hidden" id="1tag" value="">
								</td>
								<td colspan="2" class="no-screen">
									<span id="spanid1">
										<!--new rate -->
										<input type="hidden" class="form-control -txt"  name="rateinputnew" id="rateinputnew" value="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" onkeyup="amtCalc(); taxCalc();" tabindex="6">
									</span>
								</td> 
								<td colspan="2">
									<span id="spanid">
										<input type="number" class="form-control -txt"  name="buyprice" id="rate" value="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"   onkeyup="amtCalc(); taxCalc();" tabindex="6">
									</span>
								</td> 
								<td  colspan="2">
									<input type="text"  name="qty" id="Qty" value="" class="form-control form-control-resize -txt"  onclick=" amtCalc(); "  onkeyup="amtCalc(); taxCalc();" tabindex="7">
								</td>
                                <td colspan="2" class="-txt-">
                                    <span id="qty_unit"></span>
                                </td>
                                <td colspan="2" class="">
                                    <input type="text" name="cess" id="pCess" value="0.00" class="form-control -txt" onkeyup="amtCalc(); taxCalc();" tabindex="8" />
                                </td>
								<input type="hidden" id="hsn_code">
								<td class="-txt" colspan="1">
									<span id="spantax">
										<span id="cgstPercent"></span>
									</span>
								</td>
								<td class="-txt" colspan="1">
									<span   id="cgstAmt">0</span>
								</td>
								<td class="-txt" colspan="1">
									<span id="spantax1">
										<span id="sgstPercent"></span>
									</span>
								</td>
								<td class="-txt" colspan="1">
									<span   id="sgstAmt">0</span>
								</td>
									<input type="hidden" id="Adm_txtmrp">
								<input type="hidden" id="Adm_txtbuyprice">
									<input type="hidden"  name="amount" id="Adm_txtamt" value="" class="form-control" onkeyup="">
								<td colspan="2" class="-txt gAmt" style="display: none;">
									<input type="text"  name="added" id="grossAmt"  placeholder="0.00"  min="0" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" step="0.01"  class="form-control -txt " onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  onkeyup="rateCalc(); taxCalc();" tabindex="9">
								</td>
								<td colspan="2" class="-txt pAmt">
									<input type="text"  name="added" id="netAmt"  placeholder="0.00"  min="0"  class="form-control -txt " onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  onkeyup="rateCalc(); taxCalc();" tabindex="9">
								</td>
								<td class="green -txt-" colspan="2">
									<button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex="10"></button>
								</td>
                            </tr>
						</tbody>
                            <div class="focusGuard" id="focusLast" tabindex="12"></div>
                           <tr>
							    <input type="hidden" id="taxcgst" name="totcgst" value="">
                            <input type="hidden" id="taxsgst" name="totsgst" value="">
                            <input type="hidden" id="amttotal" name="amttotal" value="">
                              
                                <td class="-txt no-print" colspan="2"> </td>
								<td class="-txt" colspan="4">Total</td>
								<td colspan="2" name="totqty" class="totqty -txt" id="totqty" value="0">0</td>
                                <td colspan="2"></td>
                                <td colspan="2" id="totCess" class="-txt">0.00</td><input type="hidden" id="totcessamt" name="totcessamt" value="">
								<td colspan="2"class="tottax -txt" id="tottax" value="0">0.00<input type="hidden" id="tottx1" name="tottax11" value=""></td>
								<td colspan="2"class="tottax1 -txt" id="tottax1" value="0">0.00<input type="hidden" id="tottx11" name="tottax111" value=""></td>
                                <td colspan="2" id="grosstotal" style="display: none;" class="-txt"></td>
								<td colspan="2"name="totamt" class="totamt  -txt" id="totamt"  colspan="2" value="0">0.00</td>
                               <td colspan="2"></td>
                            </tr>
                            
                        </table>
                        <input type="hidden" id="amount" name="amount1">
                        <input type="hidden" id="balance-amount" name="balance-amount">
                         <input type="hidden" name="fraction" id="fraction">
                   <input type="hidden" name="amtpart" id="amtpart">            
                    </div>
                </form>
            </div>
            
            <!---page specific content end----->
                        <!---------Invoice head  ---------->
             
                        
<div class="pop-up-overlay" id="editpopup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body" id="modelbody">
      
           
    </div>
</div>
            <?php $quer="SELECT `id`, `c_name`, `address_1`, `mobile`, `phone`, `mailid`, `website`, `cin`, `gstin` FROM `master_company` WHERE 1";
            $set=$conn->query($quer);
            $set->setfetchmode(PDO::FETCH_ASSOC);
            while($ss=$set->fetch()){
            ?>
            <div class="print-only" id="invoice-head">
                <p class="brand"><?php echo $ss['c_name'];?></p>
                <p class="address"><?php echo $ss['address_1']; ?></p>
                <p class="contact"><span class="" id=""> <?php $ss['website']; ?> </span>| <span class="" id=""><?php $ss['mailid']; ?></span> </p>
                <p class="contact"> <span class="" id=""></span>Ph:<?php echo $ss['phone']; ?>  <span class="" id=""> Mob: <?php echo $ss['mobile']; ?></span> |</p>
                <p><span class="" id=""></span>CIN :<?php echo $ss['cin']; ?> </p>
                <p><span class="" id=""></span>GSTIN :<?php echo $ss['gstin'];?>  </p>
            </div>
            <?php }?>
            <!---------Invoice head  ---------->
            <!---- Invoice Footer------->
            <div class="print-only" id="invoice-footer">
                <p class="footer">************** THANK YOU ***************</p>
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
    
	 $("#btnsaleedit").click(function(ev){
		 

			//$.post('customeradd.php',{inv_no:$('#inv_no').text()},function(data) {
			
			
				var myvar = $("#in_id").val();
				
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="purchaseinvoiceedit.php?temp=" + myvar;
			//});
					});
	  
	  
	  function calcadv(){

	var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
	
	}
	   $("#btnAddCust").click(function(ev){

			$.post('productadd.php',{inv_id:$('#in_id').val()},function(data) {
				document.getElementById("editpopup").style.height = "100%";
				$('#modelbody').html(data);
					});});
					 function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
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


				document.getElementById('balance-amount').value = n;
				document.getElementById('amount').value = w;
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
				document.getElementById('balance-amount').value = z;
				document.getElementById('amount').value = disc;
				document.getElementById('total-bal').innerText =z;
				document.getElementById('difference').value=z;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			//sum4();
		}

	$(function() { // can replace the onload function with any other even like showing of a dialog

         $('#Adm_txtCode').focus();
           
          
        })
      
        $('#focusLast').on('focus', function() {
          // "last" focus guard got focus: set focus to the first field
         $('#Adm_txtCode').focus();
           
        });

        $('#focusFirst').on('focus', function() {
          // "first" focus guard got focus: set focus to the last field
         $('#btn_additem').focus();
          
        });
      
    var picker = new Pikaday(     
       {field: document.getElementById('pur_date'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY', }
                            );
        document.getElementById("pur_date").value = moment(new Date()).format('DD/MM/YYYY');
        function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
				 }
      
      function PrintDiv(divId)
                {
                    var printwindow = window.open('', 'PRINT', 'height=700px; width=1000px');
                    printwindow.document.write('<html><head>');
                    printwindow.document.write('<title>Invoice</title>');
                    printwindow.document.write('<style>@font-face{ font-family:Roboto; src:url(fonts/Roboto-Regular.ttf);} *{font-family: Roboto,sans-serif;} @page{margin: 0; width: 21cm; height: 29cm;} .no-print{display: none;} button{display: none;} input{display: none;} .print-only{display: inline-block;} p{margin: 0; padding: 0;} .form-control{border: none; width: 2cm;} .print-area{margin: 1.5cm; display: block; position: relative; overflow: hidden;} .-txt{text-align: right;} .bal-notify{display: none;} .brand{display: block; text-align:center; font-size:24pt; font-weight: bold;} .address, .contact{text-align: center; font-size: 10pt} .invoice-table{border-collapse: collapse; border: 1px solid #000; margin-bottom: 3cm; margin-top:.25cm;} .invoice-table td, .invoice-table th{border: 1px solid #000;} .input-group-addon::after{content: " : ";} #total-amt{position: absolute; right: 0cm; bottom: 2cm; font-size: 16pt; font-weight: bold;} #total-amt::before{content: "Amount : ";} #collect_amt{position: absolute; right: 0; bottom: 1.5cm; font-size: 14pt;} #bal_amt{position: absolute; right: 0; bottom: 1cm; font-size: 14pt;} .footer{text-align: center;} .print-left, .print-right{display: inline-block;} .print-left{float: left;} .print-right{float: right} .row{width: 100%; clear: both; margin: none;} .b-type::before{content: "Bill Type : "} .table{width: 100%;}          .siNo{width: 5%;} .sQty{width: 8%;} .sRate{width: 10%;} .sAmt{width: 15%;} .tax{width: 8%;}  </style>');
                    printwindow.document.write('</head><body><div class="print-area">');
                    printwindow.document.write(document.getElementById("invoice-head").innerHTML);
                    printwindow.document.write(document.getElementById(divId).innerHTML);
                    printwindow.document.write(document.getElementById("invoice-footer").innerHTML);
                    printwindow.document.write('</div></body></html>');
                    printwindow.document.close(); // necessary for IE >= 10
                    printwindow.focus(); // necessary for IE >= 10*/
                    printwindow.print();
                    printwindow.close();
                    return true;
                };
      
      //
      
      
      
     
      //
		$(function () {         
		$("#itemName").autocomplete({
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
		$("#supplier").autocomplete({
		minLength:2,
			source: "../get/search.php?p=get",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('sup_id').value=i;
			}
		});
	});
	 $("#supplier").blur(function(){
		  var a2=$("#supplier").val();
		//alert(a2);
		  $.ajax({
		url:"../get/supplierbalance.php",
		method:"post",
		 data:{a4:a2}
		}).done(function(data){
		$("#bal-amt").html(data);
		
		});
	});
	
	function check(e) {
			if($(e).val().length<4) {} else {
				$('#person_list').html('');
					$.ajax({
					url:"../get/post.php?p=getitemlist",
					method:"post",
					data:{itemname:$(e).val().trim()}
				}).done(function(data) {
					//alert(data);
					$('#person_list').append(data.trim());
				});
			}
			//alert($(e).val());
		}
	$("#toggelon").click(function(){
			if (document.getElementById("customer-off").style.display == "none")
			{
				$('#supplier').attr('disabled',true);
			$('#cash').attr('disabled',true);
			document.getElementById('cash').style.pointerEvents = 'none';
			document.getElementById('credit').style.pointerEvents = 'none';
			document.getElementById("customer-on").style.display="none";
			document.getElementById("customer-off").style.display="inline-block";
		}
		else
		{
		
				$('#supplier').attr('disabled',false);
			$('#cash').attr('disabled',false);
			var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			document.getElementById('cash').style.pointerEvents = 'auto';
			document.getElementById('credit').style.pointerEvents = 'auto';
			
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
            $("#advFeild").show();
		
	});
	$("#credit").click(function(){
	var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			document.getElementById("credit").style.display="none";
			document.getElementById("cash").style.display="inline-block";
            $("#advFeild").hide();
		
	});
		
$("#btn_additem").click(function() {
    document.getElementById("itemName").required = false;
    document.getElementById("Adm_txtCode").required = false;
    //~ var i=$('#1tag').val();
    //~ alert(i); || parseFloat($('#1dCode').val())!='' && parseFloat($('#1dCode').val())>0
	 if(parseFloat($('#netAmt').val())>0 || parseFloat($('#grossAmt').val())>0 ) {   
		    if(parseFloat($('#1tag').val())!='' && parseFloat($('#1tag').val())>0 ){   
			var html='<tr class="tr_row">';
				html +='<td class="td_sl" colspan="2"></td>';  //Sl:No
				html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#Adm_txtCode').val()+'" name="code1[]" />'+$('#Adm_txtCode').val()+'</td>';//code
				html +='<td colspan="" class="no-screen no-print"><input type="hidden" value="'+$('#1tag').val()+'" name="proid[]" />'+$('#1tag').val()+'</td>';	//PRODUCT
				html +='<td colspan="" class="no-print"><input type="hidden" value="'+$('#itemName').val()+'" name="proname1[]" />'+$('#itemName').val()+'</td>'; //Product Name	
                html +='<td class="no-screen no-print -txt" colspan="2"><input type="hidden" class="Adm_txtmrp" value="'+$('#Adm_txtmrp').val()+'" name="Adm_txtmrp[]"/>'+$('#Adm_txtmrp').val()+'</td>'; //MRP
                html +='<td class="no-screen no-print -txt" colspan="2"><input type="hidden" class="Adm_txtbuyprice" value="'+$('#Adm_txtbuyprice').val()+'" name="Adm_txtbuyprice[]"/>'+$('#rate').val()+'</td>'; //Purchase Price
				html +='<td colspan="2" class="-txt"><input type="hidden" value="'+$('#rate').val()+'" name="buyprice1[]"/>'+$('#rate').val()+'</td>';	
				html +='<td colspan="2" class="no-screen -txt"><input type="hidden" value="'+$('#rateinputnew').val()+'" name="buypricenew[]"/>'+$('#rateinputnew').val()+'</td>';//new input
				html +='<td class="form-control no-screen no-print txt-"><input type="hidden" value="'+$('#hsn_code').val()+'" name="buypri[]"/>'+$('#hsn_code').val()+'</td>';  //HSN Code
				html +='<td colspan="2" class="-txt"><input type="hidden" class="qty" value="'+$('#Qty').val()+'" name="qty1[]"/>'+$('#Qty').val()+'</td>'; //Quantity
                html +='<td colspan="2" class="-txt-">'+$('#qty_unit').val()+$('#qty_unit').text()+'</td>';  //Unit
                html +='<td colspan="2" class="pCes -txt">'+$('#pCess').val()+'<input type="hidden" name="cess1[]" class="cess" id="cess" value="'+$('#pCess').val()+'"></td>' //Cess
				html +='<td class="no-print -txt"><input type="hidden" id="taxcgsttax"  class="cgst" value="'+$('#cgstPercent').text()+'" name="cgst[]"/>'+$('#cgstPercent').text()+'</td>'; //CGST %
				html +='<td class="no-screen -txt" colspan="2"><input type="hidden" class="" value="'+$('#cgstAmt').text()+'" name="tax1[]"/>'+$('#cgstAmt').text()+'</td>'; //CGST Amt for print
                html +='<td class="no-print -txt"><input type="hidden" class="tax" value="'+$('#cgstAmt').text()+'" name="cgstamt[]"/>'+$('#cgstAmt').text()+'</td>'; //
				html +='<td class="no-print -txt"><input type="hidden" id="taxsgsttax" class="sgst" value="'+$('#sgstPercent').text()+'" name="sgst[]"/>'+$('#sgstPercent').text()+'</td>'; //SGST %
				html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#sgstAmt').text()+'" name="tax2[]"/>'+$('#sgstAmt').text()+'</td>'; //SGST Amt for Print
                html +='<td class="no-print -txt"><input type="hidden" class="tax1" value="'+$('#sgstAmt').text()+'" name="sgstamt[]"/>'+$('#sgstAmt').text()+'</td>'; //SGST Amt
                html +='<td colspan="2" class="gAmt -txt" style=""><input type="hidden" class="gSum" value="'+$('#grossAmt').val()+'" name="added1[]"/>'+$('#grossAmt').val()+'</td>'; // Gross Amt
				html +='<td colspan="2" class="pAmt -txt"><input type="hidden" class="nSum" value="'+$('#netAmt').val()+'" name="added1[]"/>'+$('#netAmt').val()+'</td>'; // Nett Amt
				html +='<td class="red -txt-"><i class="fa fa-times" aria-hidden="true" onclick="btnremove(this)"></i> </td>'; // Remove Button
				html +='</tr>';
				//alert(html);
				$('.tbody').append(html);
				//~ $('#sqft').val('');
				//~ $('#rate').val('');
				//~ $('#btn_additem').attr('disabled',true);
				slno();
				document.getElementById('1tag').value = '';
				document.getElementById('1dCode').value = '';
				document.getElementById('itemName').value = '';
//				document.getElementById('Adm_txtDis').value = '0';
				document.getElementById('Adm_txtCode').value = '';
				document.getElementById('rate').value = '';
				document.getElementById('cgstPercent').innerText = '';
				document.getElementById('sgstPercent').innerText = '';
				document.getElementById('Qty').value = '';
				document.getElementById('cgstAmt').innerText = '';
				document.getElementById('sgstAmt').innerText = '';
                document.getElementById('netAmt').value = '';
				document.getElementById('qty_unit').innerText = '';
                $("#grossAmt").val("");
                $("#pCess").val("0.00");
				var addv=parseFloat(document.getElementById('advance_amt').value);
	            var billamt=parseFloat(document.getElementById('total-bal').innerText);
	            var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
				//~ function discCal(){
			//~ var billAmt = parseFloat(document.getElementById('total-amt').innerText);
			//~ //alert(billAmt);
			//~ var disc = parseFloat(document.getElementById('dis').value);
			//~ //alert(disc);
				//~ function round(value, decimals) {
					//~ return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				//~ }
			//~ var dType = parseFloat(document.getElementById('select').value);
			//~ if (dType == "1"){
				//~ document.getElementById('btn_additem').style.pointerEvents = 'none';
				//~ if(disc<=100){
				//~ var qm=parseFloat(billAmt) * parseFloat(disc);
				//~ var w=qm/parseFloat(100);
				//~ var diff=parseFloat(billAmt)-parseFloat(w);
				//~ var n=round(diff,2);
                //~ document.getElementById('balance-amount').value = n;
                //~ document.getElementById('amount').value = w;
				//~ document.getElementById('total-bal').innerText = n;
				//~ document.getElementById('difference').value=n;
				//~ var addv=parseFloat(document.getElementById('advance_amt').value);
	//~ var billamt=parseFloat(document.getElementById('total-bal').innerText);
	//~ var difference=parseFloat(billamt)-parseFloat(addv);
	//~ //alert(difference);
	//~ document.getElementById('difference').value=difference;
			//~ }
			//~ else
			//~ {
				//~ alert("please enter valid percent");
				//~ $("#dis").val('0');
			//~ }
			//~ }else if(dType == "2"){
				//~ document.getElementById('btn_additem').style.pointerEvents = 'auto';
				//~ var r=parseFloat(billAmt)-parseFloat(disc);
				//~ var z=round(r,2);
				//~ document.getElementById('balance-amount').value = z;
				//~ document.getElementById('amount').value = disc;
				//~ document.getElementById('total-bal').innerText =z;
				//~ document.getElementById('difference').value=z;
					//~ var addv=parseFloat(document.getElementById('advance_amt').value);
	//~ var billamt=parseFloat(document.getElementById('total-bal').innerText);
	//~ var difference=parseFloat(billamt)-parseFloat(addv);
	//~ //alert(difference);
	//~ document.getElementById('difference').value=difference;
			//~ }
			//~ //sum4();
		//~ }
}else {
				alert('Please select valid item');
				$('#itemName').focus().val('');
			}
			}else {
				alert('Please select valid item');
				$('#itemName').focus().val('');
			}
    hideType();
		}); 
		
		function btnremove(e) {
			$(e).parent().parent().find('.estatus').val('3');
			$(e).parent().parent().removeClass('tr_row');
			$(e).parent().parent().remove();
			var totamt=0;
			var tottax=0;
			var tottax1=0;
			var totqty=0;
			$("#taxcgst").val(parseFloat(tottax).toFixed(2));
				$("#taxsgst").val(parseFloat(tottax1).toFixed(2));
				$("#amttotal").val(parseFloat(totamt).toFixed(2));
				$(".totamt").html(parseFloat(totamt).toFixed(2));
				$("#total-amt").html(parseFloat(totamt).toFixed(2));
				$("#total-bal").html(parseFloat(totamt).toFixed(2));
				$("#balance-amount").val(parseFloat(totamt).toFixed(2));
				$(".tottax").html(parseFloat(tottax).toFixed(2));
				$(".tottax1").html(parseFloat(tottax1).toFixed(2));
				$("#tottx1").val(parseFloat(tottax).toFixed(2));
				$(".totqty").html(parseFloat(totqty).toFixed(0));
			slno();
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


				document.getElementById('balance-amount').value = n;
				document.getElementById('amount').value = w;

				document.getElementById('total-bal').innerText = n;
				document.getElementById('difference').value=n;
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
				document.getElementById('balance-amount').value = z;
				document.getElementById('amount').value = disc;
				document.getElementById('total-bal').innerText =z;
				document.getElementById('difference').value=z;
					var addv=parseFloat(document.getElementById('advance_amt').value);
	var billamt=parseFloat(document.getElementById('total-bal').innerText);
	var difference=parseFloat(billamt)-parseFloat(addv);
	//alert(difference);
	document.getElementById('difference').value=difference;
			}
			//sum4();
		}

		}
	
		function slno() {
			var i=1;
			var totamt=0;
			var tottax=0;
			var tottax1=0;
			var totqty=0;
            var grossSum = 0;
            var cessSum = 0;
			$('.tr_row').each(function() {
				$(this).find('.td_sl').html(i);
				var gAmt=$(this).find('.gSum').val();
                var nAmt=$(this).find('.nSum').val();
				var qty=$(this).find('.qty').val();
			    totamt=parseFloat(totamt)+parseFloat(nAmt);
				var tax=$(this).find('.tax').val();
				var tax1=$(this).find('.tax1').val();
                tottax=parseFloat(tottax)+parseFloat(tax);
                tottax1=parseFloat(tottax1)+parseFloat(tax1);
                totqty=parseFloat(totqty)+parseFloat(qty);
                grossSum = grossSum +parseFloat(gAmt);
                cessSum = cessSum + parseFloat($(this).find('.pCes').html());
                i++;
                	var whole=Math.floor(totamt);
					var fraction=parseFloat(totamt)-parseFloat(whole);
					if(fraction==0){
						$("#fraction").val(0);
						$("#amtpart").val(parseFloat(totamt).toFixed(2));
						}
				else	if(fraction>0.50){
						var dec=1-parseFloat(fraction);
	
	 amtblnc=parseFloat(totamt)+parseFloat(dec);
	 
						$("#fraction").val(parseFloat(dec).toFixed(2));
						$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
						}
						else{
							
							amtblnc=parseFloat(totamt)-parseFloat(fraction);
							$("#fraction").val(parseFloat(-fraction).toFixed(2));
							$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
							}
                
                
                $("#taxcgst").val(parseFloat(tottax).toFixed(2));
                $("#taxsgst").val(parseFloat(tottax1).toFixed(2));
                $("#amttotal").val(parseFloat(totamt).toFixed(2));
                $(".totamt").html(parseFloat(totamt).toFixed(2));
                $("#total-amt").html(parseFloat(totamt).toFixed(2));
                $("#total-bal").html(parseFloat(totamt).toFixed(2));
                $("#balance-amount").val(parseFloat(totamt).toFixed(2));
                $(".tottax").html(parseFloat(tottax).toFixed(2));
                $(".tottax1").html(parseFloat(tottax1).toFixed(2));
                $(".totqty").html(parseFloat(totqty).toFixed(0));
                $("#grosstotal").html(grossSum);
                $("#totCess").html(cessSum);
                $("#totcessamt").val(cessSum);
			});
		}
					
	$.ajax({
		url:"../ajax/supplierajax.php",
		method:"post",
	}).done(function(data){
		$("#supplier").html(data);
	});

$.ajax
	({
		url:"../ajax/catajax.php",
		method:"post",
	}).done(function(data) {
		$("#AdmtxtCategory").html(data);
	});	
		$("#AdmtxtCategory").change(function() {
		
		//alert("kkl");
		var a=$("#AdmtxtCategory").val();
		$.ajax({
		  url:"productajax.php",
		  method:"post",
		  data:{a1:a}
		}).done(function(data) {
			$("#itemName").html(data);
			//var inp1 = $("#color").val();
		});
		});
	$("#itemName").change(function() {
			
			var a=$("#itemName").val();
			var a2=$("#code").val();
			var pid = $("#1tag").val();
			$.ajax({
				url:"../get/post.php?p=geteachitempur",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {

				var res=data.split(",");
				var ttt=res[2];
				$("#rate").val((res[2]));
				$("#cgstPercent").html(res[0]);
				$("#qty_unit").html(res[1]);
				$("#hsn_code").val(res[3]);
				$("#Adm_txtCode").val(res[4]);
				$("#Adm_txtmrp").val(res[5]);
				$("#Adm_txtbuyprice").val(res[6]);
				//sum();
			});
		$.ajax({
				url:"../get/post.php?p=geteachitemtax",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {
				$("#sgstPercent").html(data);
				//sum();
			});
			});	
			$("#Adm_txtCode").change(function() {
				var a=$("#Adm_txtCode").val();
				var a2=$("#code").val();
				var pid = $("#1tag").val();
				$.ajax({
				url:"../get/post.php?p=geteachitempur1",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {

				var res=data.split(",");
				var ttt=res[2];
				//alert(data);
				$("#rate").val((res[2]));
				$("#cgstPercent").html(res[0]);
				$("#qty_unit").html(res[1]);
				$("#hsn_code").val(res[3]);
				
				$("#Adm_txtmrp").val(res[4]);
				$("#Adm_txtbuyprice").val(res[5]);
					//sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res1=data.split(",");
					$("#sgstPercent").html(res1[0]);
					$("#itemName").val(res1[1]);
					//sum();
				});
			});
		

      
 
      
      
    //set display for default tax type on page load
    $(function() {
//         if($("#selecttax").val() == 1) {
//              $(".gAmt").hide();
//              $(".pAmt").show();
//          } else if($("#selecttax").val() == 2){
//              $(".pAmt").hide();
//              $(".gAmt").show();
//          } 
    });  
      //set display for selected tax type on change 
      function hideType(){
          if($("#selecttax").val() == 1) {
              $(".gAmt").hide();
              $(".pAmt").show();
          } else if($("#selecttax").val() == 2){
              $(".pAmt").hide();
              $(".gAmt").show();
          }
      };	
      // calculate rate when amount is enterd
      function rateCalc() {
		  	 var cgstPercent   =   parseFloat($("#cgstPercent").text());
        var sgstPercent   =   parseFloat($("#sgstPercent").text());
        var totTax        =   cgstPercent + sgstPercent;
                var cess          =   parseFloat($("#pCess").val());
                var netAmtCess    =   parseFloat($("#netAmt").val())-cess;
                var Qty           =   parseFloat($("#Qty").val());
                var grossAmt      =   parseFloat($("#grossAmt").val());
                if($("#selecttax").val() == 1) {
                    if(!isNaN(netAmtCess*Qty))
                    $("#rate").val(round(netAmtCess/Qty,2).toFixed(2));
                      $("#rateinputnew").val($("#rate").val().toFixed(2));//new rate calculation
                } else if($("#selecttax").val() == 2) {
                    if(!isNaN(grossAmt*Qty))
                    $("#rate").val(round(grossAmt/Qty,2));
                    var rate=$("#rate").val();
                    var result=parseFloat(rate)*parseFloat(totTax);
             var result1=parseFloat(rate)+parseFloat(result)/100;
              $("#rateinputnew").val(result1.toFixed(2));
                }
            };
      // calculate amount when rate and quantity eneterd
    function amtCalc() {
		 var cgstPercent   =   parseFloat($("#cgstPercent").text());
        var sgstPercent   =   parseFloat($("#sgstPercent").text());
        var totTax        =   cgstPercent + sgstPercent;
        var rate          =   parseFloat($("#rate").val());
        var Qty           =   parseFloat($("#Qty").val());
        var cess          =   parseFloat($("#pCess").val());
        if(!isNaN(rate*Qty)) {
		
            if($("#selecttax").val() == 1) {
            $("#netAmt").val(round((rate*Qty) + cess,2)); 
            $("#rateinputnew").val(rate);//new rate calculation
            } else if($("#selecttax").val() == 2){
            $("#grossAmt").val(round(rate*Qty,2).toFixed(2));
             var result=rate*totTax;
             var result1=rate+result/100;
              $("#rateinputnew").val(result1.toFixed(2));//new rate calculation
            }
        }    
    };
      //calculate tax
    function taxCalc() {
        var cgstPercent   =   parseFloat($("#cgstPercent").text());
        var sgstPercent   =   parseFloat($("#sgstPercent").text());
        var totTax        =   cgstPercent + sgstPercent;
        var cess          =   parseFloat($("#pCess").val());
        var netAmtCess        =   parseFloat($("#netAmt").val())-cess;
        if($("#selecttax").val() == 1) {
            var grossAmt = netAmtCess - (netAmtCess * totTax)/(100+totTax);
            $("#grossAmt").val(round(grossAmt,2).toFixed(2));
        }
        else if($("#selecttax").val() == 2) {
            var grossAmt = $("#grossAmt").val();
        }
        if(!isNaN(totTax*grossAmt)){
            $("#cgstAmt").text(round(grossAmt*cgstPercent*.01,2));
            $("#sgstAmt").text(round(grossAmt*sgstPercent*.01,2));
            if($("#selecttax").val() == 2){
                $("#netAmt").val(round(parseFloat(grossAmt) + parseFloat($("#cgstAmt").text()) + parseFloat($("#sgstAmt").text()) +cess,2).toFixed(2));
            }
        }
    };	

</script>
