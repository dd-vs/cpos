<?php 

include("../include/include.php"); 
 $id=$_GET['temp'];
 $check="select count(invoice_id) as num from ti_purchase_invoice where invoice_id='$id'";
 $ck=$conn->query($check);
 $ck->setfetchmode(PDO::FETCH_ASSOC);
 $ch=$ck->fetch();
 if($ch['num']<=0){
	 header("location:purchaseinvoice.php");
	 }
	 $qq="select IsActive from ti_purchase_invoice where invoice_id ='$id'";
 $ww=$conn->query($qq);
 $ww->setfetchmode(PDO::FETCH_ASSOC);
 $rr=$ww->fetch();
 if($rr['IsActive']==0){
	 
	 header('location:purchaseinvoice.php');
	 if(!isset($_GET['temp']) || $_GET['temp']=='' || $rr['IsActive']==0){
header('location:purchaseinvoice.php');
	 }
	
	 }
		check_session();
 html_head();

 
	$sql="select max(ti_purchase_invoice.invoice_id)+1 as eno from ti_purchase_invoice";
	$s=$conn->query($sql); $res=$s->fetch();
?>
<?php navbar_user(2);
$quu="select ti_purchase_invoice.*, ti_suppllier.name as supname ,date(ti_purchase_invoice.pur_date) as date from ti_purchase_invoice left join ti_suppllier on ti_purchase_invoice.supplier_id =ti_suppllier.id where ti_purchase_invoice.invoice_id ='$id' and ti_purchase_invoice.IsActive=1";
$s22=$conn->query($quu); $re1=$s22->setfetchmode(PDO::FETCH_ASSOC);
while($wr=$s22->fetch())
{
	$ssdate=$wr['date'];
$show_date = DateTime::createFromFormat('Y-m-d', $ssdate)->format('d/m/Y');
?>

          <h2 style="margin-top:0;">Purchase Invoice Edit</h2>
            <div class="form-container" id="invoice">
               <form  id="frmenquiry" name="frmenquiry" action="../add/pur_report_save.php" method="post">
                    <div class="invoice-head col-md-12">
                        <div class="col-md-6 right-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Date</span>
                                        </span>
                                       <label class="form-control" type="text" name="date"  id="" value=><?php echo $show_date; ?> </label>
                                    </div>
                                    <div class="form-control print-only" id="datePrint"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill#</span>
                                        </span>
                                        <input class="form-control" type="text" name="in_no" id="p-inv-no" disabled value="<?php echo $wr['invoice_num'];?>" onblur="changeVal('p-inv-no','inv-print')" required tabindex="3"/>
                                    </div>
                                    <div class="form-control print-only" id="inv-print"></div>
                                </div>
                                
                                <div class="row no-screen">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <span>Off</span>
                                            </span>
                                           <input class="form-control" type="text" name="discount" id="dis"  onblur=" discCal();" value="<?php echo $wr['discount'];?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 input-label no-screen">
                                        <select  id="select" name="select"  class="form-control" onchange="discCal();">
                                           
                                            <option value="2">Flat</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                             <input class="form-control no-screen" type="text" name="advance_amt" id="advance_amt"  value="0" onblur="calcadv();">
                             <input type="hidden" id="difference" name="difference" >
                             <input id="setHidden" hidden name="hidden" value="10" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Supplier</span>
                                        </span>
                                      <input type="text" name="supplier" id="supplier" required  class="form-control" value="<?php echo $wr['supname'];?>"  onblur="changeVal('supplier','supplierPrint')">
                                      <input type="hidden" name="sup_id" id="sup_id" value="<?php echo $wr['supplier_id'];?>">
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
						              <input type="number" name="invid" id="in_id" class="form-control -txt" value="<?php echo $wr['invoice_id'];?>" >
						              <span class="input-group-addon">
                                         <span><i class="fa fa-play" id="btnsaleedit" style="" aria-hidden="true"></i></span>
                                        </span>
                                    </div>
                                </div>
<!--
                                   <span><i class="fa fa-angle-double-right" id="btnsaleedit" style="font-size:24px" aria-hidden="true"></i></span>
-->
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
									<input type="hidden" id="cash_credit" name="cash_credit" value="<?php echo $wr['cash_credit'];?>">
                                  <?php if($wr['cash_credit']==10){?>
                                    <span  id="cash" class="b-type btn btn-primary"  >Cash</span><?php } else {?>
                                    <span  id="credit"  class="b-type btn btn-primary btn-credit"  >Credit</span>
                                    
                                    <?php }?>
                                </div>
                                <?php }?>
                                <div class="col-md-4 -txt-">
                                    <button class="no-screen btn btn-primary" onclick="PrintDiv('invoice')">Print</button>
                                </div>
                                 
                                <div class="col-md-4 -txt-">
                                    <button class="btn btn-primary" name="submit">Save</button>
                                </div>
                            </div>
                            <!---replace---->
                        </div>
                        <div class="col-md-2">
                          
                           <div class="red -txt no-screen" id="total-amt" >
								   0.00
                            </div>
                               <div class="red -txt " id="total-bal" >
								    <div class="col-md-4 -txt-">
									</div>
								</div>
								    <button type="submit" class="btn btn-danger"   onClick="javascript: return confirm('Please confirm deletion');" name="delete">Delete</button>

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
                                <th rowspan="2" colspan="2" class="sQty">UoM</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
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
										<input type="text" name="code" id="Adm_txtCode" value="" class="form-control no-print" tabindex="5">
									<input type="hidden" id="1dCode" value="">
								</td>
								<td class="table-item" colspan="">
									<input type="text" name="proname"  id="Adm_txtPro" value="" class="form-control"  tabindex="6">
									<input type="hidden" id="1tag" value="">
									 
								</td>
								<td colspan="2">
									<span id="spanid">
										<input type="number" class="form-control -txt"  name="buyprice" id="Adm_txtprice" value="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  onkeyup="sum();" tabindex="7">
									</span>
								</td> 

								<td  colspan="2">
									<input type="number"  name="qty" id="Adm_txtqty" value="" class="form-control form-control-resize -txt" onkeyup="sum(); sum3();" tabindex="8">
								</td>
                                <td colspan="2"><span id="qty_unit"></span></td>
								<input type="hidden" id="hsn_code">
								<td class="-txt" colspan="1">
									<span id="spantax">
										<span id="Adm_txttax"  ></span>
									</span>
								</td>
								<td class="-txt" colspan="1">
									<span   id="Adm_txttax16666">0</span>
								</td>
								<td class="-txt" colspan="1">
									<span id="spantax1">
										<span id="Adm_txttax1" ></span>
									</span>
								</td>
								<td class="-txt" colspan="1">
									<span   id="Adm_txttax17777">0</span>
								</td>
									<input type="hidden" id="Adm_txtmrp">
								<input type="hidden" id="Adm_txtbuyprice">
									<input type="hidden"  name="amount" id="Adm_txtamt" value="" class="form-control" onkeyup="sum2(); sum3()">
								<td colspan="2" class="-txt">
									<input type="text"  name="added" id="Adm_txtsum"  placeholder="0.00"  min="0" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" step="0.01"  class="form-control -txt" onkeyup="sum2(); sum3();" tabindex="9">
								</td>
								<td class="green -txt-" colspan="2">
									<button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex="10"></button>
								</td>
                            </tr>
						</tbody>
						<div class="focusGuard" id="focusLast" tabindex="12"></div>
                            <?php
				$query="SELECT ti_purchse_items.cgst_percent as cgst,ti_purchse_items.sgst_percent as sgst,ti_purchase_invoice.*,ti_product.name , ti_purchse_items.id as purchaseid,ti_product.item_code,ti_product.id as pro,ti_purchse_items.buy_price as rate,ti_purchse_items.*,master_unit.unit_name FROM `ti_purchse_items` left join ti_purchase_invoice on ti_purchse_items.inv_id=ti_purchase_invoice.invoice_id left join ti_product on ti_product.id=ti_purchse_items.product_id  left join master_unit on master_unit.id=ti_product.unit_id
				WHERE ti_purchase_invoice.invoice_id='$id'and ti_purchse_items.isActive=1";
				$val1=$conn->query($query);
				$val1->setfetchmode(PDO::FETCH_ASSOC);
				

				$i=1; while($v1=$val1->fetch()){
			
				$amount=$v1['rate']*$v1['qty'];
$tax1=$v1['cgst'];
$rate=$v1['rate'];
  $tax2=$v1['sgst'];
  $tottax=$tax1+$tax2;
  $a=$amount*$tottax;
  $b=100+$tottax;
  $b1=$a/$b;
  $grossamt=$amount-$b1;

  $c1=$grossamt*$tax1;
  $c2=$grossamt*$tax2;
  $cgst=$c1/100;
  $sgst=$c2/100;
  $cgst1=round($cgst,2);
      $sgst1=round($sgst,2);
			  
			  ?>
			 <tr class="datainput tr_row1">
				
			
			 
                 <input type="hidden" class="cgstnew" id="Adm_txttax16666" value="<?php echo $cgst1;?>">
			  <input type="hidden" class="sgstnew" name="nwsgst" id="Adm_txttax17777" value="<?php echo $sgst1;?>">
			  <input type="hidden" class="cgst_cal" name="nwcgst" id="newcgst" value="">
			  <input type="hidden" name="nwsgst" id="newsgst" value="">
				<td class="td_sl1 S/Num -txt" colspan="2"><?php echo $i; ?></td>
				<td class="no-screen"> <input type="hidden" name="estatus[]" class="estatus" value="1"></td>
				<td class="sCode no-screen" colspan="">
				<input type="hidden" tabindex="3" name="purchaseid[]" id="" value="<?php echo $v1['purchaseid'];?>" class="form-control no-print" />
									<input type="text" tabindex="3" name="code" id="Adm_txtCode" value="<?php echo $v1['item_code'];?>" class="form-control no-print" />
									<input type="hidden" tabindex="3" name="id[]" id="" value="<?php echo $v1['pro'];?>" class="form-control no-print" />
								</td>
				<td class="table-item" colspan="2"><input type="text" name="saleproid[]"  class="form-control prodid" id="proid" value="<?php echo $v1['name']; ?>" value="<?php echo $v1['pro']; ?>"></td>
				<td class="-txt" colspan="2"><input type="text" name="salerate[]" id="rate"  class="form-control rate1" value="<?php echo $v1['rate']; ?>"></td>
				<td class="-txt" colspan="2"><input type="text" name="saleqty[]" id="qty"  class="form-control qty" value="<?php echo $v1['qty']; ?>"></td>
                 <td colspan="2"><?php echo $v1['unit_name']; ?></td>
<!--oninput="sums(this);"-->
                 <td class="-txt" colspan="1"><input type="hidden" name="salecgst[]" id="cgst"  class="cgst" value="<?php echo $v1['cgst']; ?>" ><?php echo $v1['cgst']; ?> </td>
                 <td class="cgst1" colspan="1" style="text-align:right"><?php echo $cgst1; ?></td>
				<td class="-txt" colspan="1"><input type="hidden" name="salesgst[]" id="sgst"  class="sgst" value="<?php echo $v1['sgst']; ?>"><?php echo $v1['sgst']; ?>
				<input type="hidden" id="Adm_txtamt1" class="Adm_txtamt"></td>
				<td class="sgst1" colspan="1" style="text-align:right"><?php echo $sgst1; ?></td>
				<td class="sum2" colspan="2" id="Adm_txtsum" style="text-align:right"><?php echo $amount?></td>
				<td class="red -txt-"  colspan="2"><i class="fa fa-times" aria-hidden="true" onclick="btnremove1(this)"></i> </td>
					
			</tr>            
		<?php $i++; 
	}
	?>
	
                      <?php
                      $queryq="SELECT * from ti_purchase_invoice WHERE invoice_id='$id'";
		$val=$conn->query($queryq);
		$val->setfetchmode(PDO::FETCH_ASSOC); 
		while($vq=$val->fetch()){?> 
                          
                            <tr>
								<input type="hidden" id="active" name="active" value="<?php echo $vq['IsActive'];?>">
								<input type="hidden" id="has_return" name="has_return" value="<?php echo $vq['has_return'];?>">
								<input type="hidden" id="taxcgst" name="totcgst" value="">
								<input type="hidden" id="taxsgst" name="totsgst" value="">
								<input type="hidden" id="amttotal" name="amttotal" value="">
								<td class="-txt" colspan="6">Total</td>
								<td colspan="2" name="totqty" class="totqty -txt" id="totqty" value="0"></td>
                                <td colspan="2"></td>
								<td  colspan="2"class="tottax  -txt" id="tottax" value="0"><?php echo $vq['cgst_amt'];?></td>
								<td colspan="2"class="tottax1 -txt" id="tottax1" value="0"><?php echo $vq['sgst_amt'];?></td>
								<td colspan="2"name="totamt" class="totamt -txt" id="totamt"  colspan="2" value="0"><?php echo $vq['amt'];}?></td></td>
								<td class="-txt no-print"> -- </td>
                            </tr>
                            
                        </table>
                    </div>
                    <input type="hidden" name="fraction" id="fraction">
                   <input type="hidden" name="amtpart" id="amtpart"> 
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
	   document.getElementById('supplier').style.pointerEvents = 'none';
	  
	  	  <?php  if(isset($_SESSION['eid']) && $_SESSION['eid'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['eid']);  } ?>
		
	  
	  $(function() {
var w= $('#has_return').val();
if(w==1)
{
notify("warning","Some items in invoice have returned – Invoice edit might not work");
}
});
	  <?php   if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
      alert('<?php echo $_SESSION["status"]; ?>');
      <?php   unset($_SESSION['i']); unset($_SESSION['status']); } ?>
     
	
	   $("#btnsaleedit").click(function(ev){
		 

			//$.post('customeradd.php',{inv_no:$('#inv_no').text()},function(data) {
			
			
				var myvar = $("#in_id").val();
				
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="purchaseinvoiceedit.php?temp=" + myvar;
			//});
					});
	  
	   $("#btnAddCust").click(function(ev){

			$.post('productadd.php',{inv_id:$('#in_id').val()},function(data) {
				document.getElementById("editpopup").style.height = "100%";
				$('#modelbody').html(data);
					});});
					 function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
    function advances(){
		var billAmt = parseFloat(document.getElementById('total-amt').innerText);
	var dis = parseFloat(document.getElementById('advance_amt').value);	
	var wq= parseFloat(billAmt)-parseFloat(dis);
	alert(wq);
	document.getElementById('advanceamt').value = wq;
	
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

				document.getElementById('total-bal').innerText = n;
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
				document.getElementById('total-bal').innerText =z;
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
      
    //~ var picker = new Pikaday(     
       //~ {field: document.getElementById('pur_date'),
        //~ firstDay: 1,
        //~ minDate: new Date(2016,01,01),
        //~ maxDate: new Date(2020, 12, 31),
        //~ yearRange: [2016,2020],
        //~ format: 'DD/MM/YYYY', }
                            //~ );
        //~ document.getElementById("pur_date").value = moment(new Date()).format('DD/MM/YYYY');
        //~ function changeVal(src, desti){
					 //~ var value =  document.getElementById(src).value;
					 //~ document.getElementById(desti).innerHTML=value;
				 //~ }
      
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
				document.getElementById('1dCode').value=i;
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
		
	});
	$("#credit").click(function(){
	var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			document.getElementById("credit").style.display="none";
			document.getElementById("cash").style.display="inline-block";
		
	});
		  function sums(e) {
				 
				 
				 var txtFirstNumberValue=$(e).parent().parent().find('.rate1').val();
				 

var txtSecondNumberValue = $(e).parent().parent().find('.qty').val();
if(txtSecondNumberValue>0)
{
	
var result = parseFloat(txtFirstNumberValue).toFixed(2) * parseFloat(txtSecondNumberValue).toFixed(2);

if (!isNaN(result)) {
var re=parseFloat(result).toFixed(2);

function round(value, decimals) {
return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
var tt=document.getElementById('totamt').innerText; 
var r=$(e).parent().parent().find('.sum2').text();
//alert(r); 
//alert(tt);

var nres=round(result,2);

$(e).parent().parent().find('.Adm_txtamt').val(nres);

var amt=$(e).parent().parent().find('.Adm_txtamt').val();
var sum = parseFloat(amt);
var s=   $(e).parent().parent().find('.sum2').text(sum);

if(amt>r)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a1=parseFloat(amt)-parseFloat(r);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc=parseFloat(tt)+parseFloat(a1);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	document.getElementById('totamt').innerText=abc;
}
else{
	//alert("samll");
	var a3=parseFloat(r)-parseFloat(amt);
	var abc3=parseFloat(tt)-parseFloat(a3);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	document.getElementById('totamt').innerText=abc3;
}


//alert(s); 

//alert(nres);
 
                              var totTax=parseFloat($(e).parent().parent().find('.cgst').val())+parseFloat($(e).parent().parent().find('.sgst').val());
                              var totitemamt =$(e).parent().parent().find('.Adm_txtamt').val();
                             // alert(totTax);
                             //alert(totitemamt);
                             var qe=$('#Adm_txtamt1').val(totitemamt);
                             //alert(qe);
                              
                              var a=parseFloat(totitemamt)*parseFloat(totTax);
                              var b=parseFloat(100)+parseFloat(totTax);
                              var c=parseFloat(a)/parseFloat(b);
                              var grossamt=parseFloat(totitemamt)-parseFloat(c);
                              var cgst=$(e).parent().parent().find('.cgst').val();
                             
                               var tt1=document.getElementById('tottax').innerText;
                               var cgstcur=$(e).parent().parent().find('.cgst1').text();
                              //alert(cgst);
                              
                              var sgst=$(e).parent().parent().find('.sgst').val();
                              //alert(sgst);
                              var d=parseFloat(grossamt)*parseFloat(cgst);
                              var totcgst=parseFloat(d) / parseFloat(100);
                              var ncgst=round(totcgst,2);
                              var rr1=$(e).parent().parent().find('.cgst1').text(ncgst);
                              
//alert(tt1);
//alert(cgstcur);
//alert(ncgst);
if(ncgst>cgstcur)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a12=parseFloat(ncgst)-parseFloat(cgstcur);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc123=parseFloat(tt1)+parseFloat(a12);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	  var curcgst=round(abc123,2);
	 document.getElementById('tottax').innerText=curcgst;
}
else{
	//alert("samll");
	var a31=parseFloat(cgstcur)-parseFloat(ncgst);
	var abc31=parseFloat(tt1)-parseFloat(a31);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	var cur1cgst=round(abc31,2);
	document.getElementById('tottax').innerText=cur1cgst;
}
var tt2=document.getElementById('tottax1').innerText;
//alert(tt2);
                               var sgstcur=$(e).parent().parent().find('.sgst1').text();
                               //alert(sgstcur);
                               

                              //alert(totcgst);
                               var q=parseFloat(grossamt)*parseFloat(sgst);
                              var totsgst=parseFloat(q) / parseFloat(100);
                              var nsgst=round(totsgst,2);
                              var r2=$(e).parent().parent().find('.sgst1').text(nsgst);
                              //alert(nsgst);
                              if(nsgst>sgstcur)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a121=parseFloat(nsgst)-parseFloat(sgstcur);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc1234=parseFloat(tt2)+parseFloat(a121);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	  var cur1sgst=round(abc1234,2);
	 document.getElementById('tottax1').innerText=cur1sgst;
}
else{
	//alert("samll");
	var a311=parseFloat(sgstcur)-parseFloat(nsgst);
	var abc311=parseFloat(tt2)-parseFloat(a311);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	var cur1ssgst=round(abc311,2);
	document.getElementById('tottax1').innerText=cur1ssgst;
}


                            var e=parseFloat(grossamt)*parseFloat(sgst);
                             var totsgst=parseFloat(e) / parseFloat(100);
                           //alert(totsgst);
                              totalcgstamt=totalcgstamt+ncgst;
                             // alert(totalcgstamt);
                               totalsgst=totalsgst+nsgst;
                                totalamt=tt+sum;
                              //alert(totalamt);
                              
                            
                          

//~ var nsgst=round(totsgst,2);
//~ //alert(ncgst);
//~ //alert(nsgst);
//~ $(e).parent().parent().find('.cgst1').text(ncgst);
//~ $(e).parent().parent().find('.sgst1').text(nsgst);
                              
                              


}}
else
{
	alert("please enter valid qty");
	}}
		
$("#btn_additem").click(function() {
			  		  document.getElementById("Adm_txtPro").required = false;
			  		  document.getElementById("Adm_txtCode").required = false;
	 if(parseFloat($('#Adm_txtsum').val())>0) {
			var html='<tr class="tr_row1">';
					html +='<td class="td_sl1 -txt" colspan="2"></td>';
				html +='<td colspan="2" class="no-print"><input type="hidden" value="'+$('#Adm_txtPro').val()+'" name="proname1[]" />'+$('#Adm_txtPro').val()+'</td>';	
							  html +='<td colspan="" class="no-screen no-print"><input type="hidden" value="'+$('#1tag').val()+'" name="proid[]" />'+$('#1tag').val()+'</td>';	//PRODUCT
            html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtmrp" value="'+$('#Adm_txtmrp').val()+'" name="Adm_txtmrp[]"/>'+$('#Adm_txtmrp').val()+'</td>';
			html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtbuyprice" value="'+$('#Adm_txtbuyprice').val()+'" name="Adm_txtbuyprice[]"/>'+$('#Adm_txtbuyprice').val()+'</td>';
          
           
            
            
				html +='<td colspan="2" class="-txt"><input type="hidden" value="'+$('#Adm_txtprice').val()+'" name="buyprice1[]"/>'+$('#Adm_txtprice').val()+'</td>';
				html +='<td class="form-control no-screen no-print"><input type="hidden" value="'+$('#hsn_code').val()+'" name="buypri[]"/>'+$('#hsn_code').val()+'</td>';
				html +='<td colspan="2" class="-txt"><input type="hidden" class="qty" value="'+$('#Adm_txtqty').val()+'" name="qty1[]"/>'+$('#Adm_txtqty').val()+'</td>';
				html+='<td colspan="2"> '+$('#qty_unit').val()+$('#qty_unit').text()+'</td>';
				html +='<td class="no-print"><input type="hidden" id="taxcgsttax"  class="cgst" value="'+$('#Adm_txttax').text()+'" name="cgst[]"/>'+$('#Adm_txttax').text()+'</td>';
				html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax16666').text()+'" name="tax1[]"/>'+$('#Adm_txttax16666').text()+'</td>';
            html +='<td class="cgst1 no-print"><input type="hidden" class="tax" value="'+$('#Adm_txttax16666').text()+'" name="cgstamt[]"/>'+$('#Adm_txttax16666').text()+'</td>';
				html +='<td class="no-print"><input type="hidden" id="taxsgsttax" class="sgst" value="'+$('#Adm_txttax1').text()+'" name="sgst[]"/>'+$('#Adm_txttax1').text()+'</td>';
				html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax17777').text()+'" name="tax2[]"/>'+$('#Adm_txttax17777').text()+'</td>';
            html +='<td class="sgst1 no-print"><input type="hidden" class="tax1" value="'+$('#Adm_txttax17777').text()+'" name="sgstamt[]"/>'+$('#Adm_txttax17777').text()+'</td>';
				html +='<td colspan="2" class="sum2"><input type="hidden" class="sum2" value="'+$('#Adm_txtsum').val()+'" name="added1[]"/>'+$('#Adm_txtsum').val()+'</td>';
				html +='<td class="red -txt-"><i class="fa fa-times" aria-hidden="true" onclick="btnremove1(this)"></i> </td>';
				html +='</tr>';
				//alert(html);
				$('.tbody').append(html);
				//~ $('#sqft').val('');
				//~ $('#rate').val('');
				//~ $('#btn_additem').attr('disabled',true);
				slno1();
				document.getElementById('Adm_txtPro').value = '';
				document.getElementById('Adm_txtCode').value = '';
				document.getElementById('Adm_txtprice').value = '';
				document.getElementById('Adm_txttax').innerText = '';
				document.getElementById('Adm_txttax1').innerText = '';
				document.getElementById('Adm_txtqty').value = '';
				document.getElementById('Adm_txttax16666').innerText = '';
				document.getElementById('Adm_txttax17777').innerText = '';
			document.getElementById('Adm_txtsum').value = '';
				document.getElementById('qty_unit').innerText = '';
				
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

				document.getElementById('total-bal').innerText = n;
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
				document.getElementById('total-bal').innerText =z;
			}
			//sum4();
		}

			}else {
				alert('Please select valid item');
				$('#Adm_txtPro').focus().val('');
			}
		}); 
		
		function slno1() {
			 document.getElementById('amttotal').value=0;
         document.getElementById('taxcgst').value=0;
        document.getElementById('taxsgst').value=0;
       
        $(".tottax").html('0.00');
        $(".tottax1").html('0.00');
        $(".totamt").html('0.00');
		var i=1;
		var totamt=0;
		var tottax=0;
		var tottax1=0;
		var totqty=0;
		$('.tr_row1').each(function() {
			var w=$(this).find('.td_sl1').html(i);
				//alert(w);
				var amt=$(this).find('.sum2').text();
				var qty=$(this).find('.qty').val();
				
			totamt=parseFloat(totamt)+parseFloat(amt);
				var tax=$(this).find('.cgst1').text();
				var tax1=$(this).find('.sgst1').text();
				//alert(totamt);
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
			 tottax=parseFloat(tottax)+parseFloat(tax);
			 tottax1=parseFloat(tottax1)+parseFloat(tax1);
			 totqty=parseFloat(totqty)+parseFloat(qty);
			$("#taxcgst").val(parseFloat(tottax).toFixed(2));
					$("#taxsgst").val(parseFloat(tottax1).toFixed(2));
				$(".totamt").html(parseFloat(totamt).toFixed(2));
				$("#amttotal").val(parseFloat(totamt).toFixed(2));
				$("#total-amt").html(parseFloat(totamt).toFixed(2));
				$("#total-bal").html(parseFloat(totamt).toFixed(2));
				$(".tottax").html(parseFloat(tottax).toFixed(2));
				$(".tottax1").html(parseFloat(tottax1).toFixed(2));
				$(".totqty").html(parseFloat(totqty).toFixed(0));	
				i++;
			});}
	function btnremove1(e) {
		
			var s= $('#has_return').val();
			//alert(s);
			var d=$('#active').val();
			//alert(d);
			
			if(s==0) 
			{
				$(e).parent().parent().find('.estatus').val(0);
			var r=$(e).parent().parent().find('.estatus').val();
			//alert(r);
				
			$(e).parent().parent().removeClass('tr_row1');
			$(e).parent().parent().hide();
		
			
			slno1();
	  
  }
  else
  {
	 notify("warning","item cannot be deleted");
  }
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
			$("#Adm_txtPro").html(data);
			//var inp1 = $("#color").val();
		});
		});
	$("#Adm_txtPro").change(function() {
			
			var a=$("#Adm_txtPro").val();
			var a2=$("#code").val();
			var pid = $("#1tag").val();
			$.ajax({
				url:"../get/post.php?p=geteachitempur",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {

				var res=data.split(",");
				var ttt=res[2];
				$("#Adm_txtprice").val(parseFloat(res[2]));
				$("#Adm_txttax").html(res[0]);
				$("#qty_unit").html(res[1]);
				$("#hsn_code").val(res[3]);
				$("#Adm_txtCode").val(res[4]);
				$("#Adm_txtmrp").val(res[5]);
				$("#Adm_txtbuyprice").val(res[6]);
				sum();
			});
		$.ajax({
				url:"../get/post.php?p=geteachitemtax",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {
				$("#Adm_txttax1").html(data);
				sum();
			});
			});	
			$("#Adm_txtCode").change(function() {
				var a=$("#Adm_txtCode").val();
				var a2=$("#code").val();
				var pid = $("#1dCode").val();
				$.ajax({
				url:"../get/post.php?p=geteachitempur1",
				method:"post",
				data:{ itemid:pid }
			}).done(function(data) {

				var res=data.split(",");
				var ttt=res[2];
				$("#Adm_txtprice").val(parseFloat(res[2]));
				$("#Adm_txttax").html(res[0]);
				$("#qty_unit").html(res[1]);
				$("#hsn_code").val(res[3]);
				$("#Adm_txtmrp").val(res[4]);
				$("#Adm_txtbuyprice").val(res[5]);
					sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res1=data.split(",");
					$("#Adm_txttax1").html(res1[0]);
					$("#Adm_txtPro").val(res1[1]);
					sum();
				});
			});
		
		
  function sum() {
				var txtFirstNumberValue = document.getElementById('Adm_txtprice').value;
				var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
				var result = parseFloat(txtFirstNumberValue).toFixed(2) * parseFloat(txtSecondNumberValue).toFixed(2);
				if (!isNaN(result)) {
					var re=parseFloat(result).toFixed(2);
					
					function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}

						var nres=round(result,2);
						
				document.getElementById('Adm_txtamt').value = nres;
                	var totTax=parseFloat(document.getElementById('Adm_txttax').innerText)+parseFloat(document.getElementById('Adm_txttax1').innerText);
                	var totitemamt = document.getElementById('Adm_txtamt').value;
                	var a=parseFloat(totitemamt)*parseFloat(totTax);
                	var b=parseFloat(100)+parseFloat(totTax);
                	var c=parseFloat(a)/parseFloat(b);
                	var grossamt=parseFloat(totitemamt)-parseFloat(c);
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
						document.getElementById('Adm_txtsum').value=sum.toFixed(2);
					
			}}
		
					//~ if(parseFloat(txtyyumberValue) >0 && parseFloat(txtthird1NumberValue) >0 ) {
						
						//~ document.getElementById('Adm_txttax16666').innerText=n;
						//~ }else {
						//~ document.getElementById('Adm_txttax16666').innerText='0.00';
					//~ }
					
        
        
        function sum2(){
				var txtthirdNumberValue = document.getElementById('Adm_txtsum').value;
				var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
				var result1 = parseFloat(txtthirdNumberValue) / parseFloat(txtSecondNumberValue);
				document.getElementById('Adm_txtprice').value = result1;
                
			}
			
			
			
        function sum3(){
							
				document.getElementById('Adm_txtamt').value = nres;
                	var totTax=parseFloat(document.getElementById('Adm_txttax').innerText)+parseFloat(document.getElementById('Adm_txttax1').innerText);
                	var totitemamt = document.getElementById('Adm_txtamt').value;
                	var a=parseFloat(totitemamt)*parseFloat(totTax);
                	var b=parseFloat(100)+parseFloat(totTax);
                	var c=parseFloat(a)/parseFloat(b);
                	var grossamt=parseFloat(totitemamt)-parseFloat(c);
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
						document.getElementById('Adm_txtsum').value=sum.toFixed(2);
                
			}
			
			
			
			
</script>
