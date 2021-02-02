<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(1);


	
	    ?><!---page specific content begin--->
            
            <h2 style="margin-top:0;">Sales Return</h2>
            <div class="form-container">
                <form  action="../add/sale_return_save.php" method="post">
                    <div class="invoice-head col-md-12">
                        <div class="col-md-6 right-border">
<!--
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Invoice date</span>
                                        </span>
                                        <input class="form-control" type="date" name="date" id="date" value="" />
                                    </div>
                                </div>
--><div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Date</span>
                                        </span>
                                        <input class="form-control" type="text" name="date" id="pur_date" value="" onblur="changeVal('pur_date','datePrint')" required/>
                                    </div>
                                    <div class="form-control print-only" id="datePrint"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Invoice No</span>
                                        </span>
                                       <input class="form-control" type="text" name="inv_num" id="inv_num" value=""  onblur="check(inv_num);"/>
                                       <input type="hidden" id="invoice_id" name="invoice_id">
                                       
                                        <?php /*

								$query="SELECT `invoice_id` as k,`invoice_num` as v FROM `ti_sale_invoice`";
								$stmt=$conn->query($query); $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
								$k= $result['k'];
								foreach($result as $r) {
								$k=$r['k'];
								echo "<option data-code=\"".$r['k']."\" value=\"".$r['v']."\" />".$r['k']."</option>";
							
								}*/
								?>
								
								  <span class="input-group-addon">
<!--
                           <button class="glyphicon glyphicon-search" name="searchinvoice" id="invoicesearch"> </button>
-->
                           </span>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Customer</span>
                                        </span>
                                        <input class="form-control" type="text" name="customer" id="customer" value="" placeholder="Select a customer"  disabled/>
                                        <span class="input-group-addon">
                                            <span class="toggle-btn" id="customer-on"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
                                            <span style="display:none;" class="toggle-btn" id="customer-off"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 right-border">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span style="padding-right:30px;"></span>
                                        </span>
                                        <input class="form-control" type="text" name="" id="" value="" disabled/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Amount</span>
                                        </span>
                                        <input type="hidden" name="qty1" id="qty1" ><input class="form-control" type="text" name="totamt1" id="totamt1" value="" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<input type="hidden" id="cust_id1" >
                                <div class="col-md-6 -txt-">
                                    <button class="btn btn-primary" name="cash">Cash Pay</button>
                                </div>
                                <div class="col-md-6 -txt-">
                                    <button class="btn btn-primary" id="credit" name="credit">Credit to Party</button>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-md-2">
                            <div class="red -txt" id="total-amt">
                                00.00
                            </div>
                        </div>
                    </div>
                    <div class="invoice-body col-md-12">
                        <table class="table invoice-table">
							
                            <tr>
								
                                <th style="width:5%">No</th>
                                <th style="width:45%">Item</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th style="width:10%">Return Qty</th>
                                <th>Return Amt</th>
                            </tr>
                     <tbody class="tbody" id="tbody">
								
							</tbody>
                          
                            <tr>
                                <td class="-txt" colspan="2">Total</td>
                                <td class="-txt" colspan="1"></td>
                                <td class="-txt" colspan="1"></td>
                                <td class="-txt" colspan="1"></td>
                               
                              <input type="hidden" name="cgsttot" class="cgst1" id="cgst"  colspan="1" value="0">
                                <input type="hidden" name="sgsttot" class="sgst1" id="sgst"  colspan="1" value="0"> 
                                <input type="hidden" name="amttot" class="amttot" id="amttot"  colspan="1" value="0"> 
                                <td name="totamt" class="totamt" id="totamt"  colspan="2" value="0"> 0.00</td>
                                
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            	
            <div class="no-screen" id="cust_id"></div>
            <div class="no-screen" id="mob"></div>
            <div class="no-screen" id="emailid"></div>
            <div class="no-screen" id="address"></div>
            <div class="no-screen" id="tin"></div>
            <div class="no-screen" id="tincode"></div>
            <div class="no-screen" id="state"></div>
            <div class="no-screen" id="city"></div>
            <!---page specific content end----->
        <?php
html_close();
 ?>
 <link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
	<?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
	 var picker = new Pikaday(     
       {field: document.getElementById('pur_date'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2016,2020],
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
      
	
	
	$(function () { 
	       
		$("#inv_num").autocomplete({
			
		minLength:1,
			source: "../get/search.php?p=getsinv",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('invoice_id').value=i;
			}
		});
	});
		function check(inv_num){
	//alert("rte");
			var v=$('#invoice_id').val();
		var myvar = v;
		
		$('#date').attr('disabled',false);
		//alert(myvar);
		$.ajax({
		url:"getcodeajax.php?p=getitem",
		method:"post",
		 data:{a1:v}
		 
		}).done(function(data) {
			$("#tbody").html(data);
			
		});
		$.ajax({
		url:"../get/post.php?p=getcust",
		method:"post",
		 data:{a1:v}
		 
		}).done(function(data) {
			var res=data.split(",");
			var ttt=res[1];
			var rr=res[0];
			var tw=res[2];
		//	alert(data);
			//~ alert(rr);
			//~ alert(ttt);
			//~ alert(tw);
			$("#customer").val(res[0]);
			$("#date").val(res[1]);
			$("#totamt1").val(res[2]);
			$("#cust_id").text(res[3]);
			$("#cust_id1").val(res[3]);
			$("#mob").text(res[4]);
			$("#emailid").text(res[5]);
			$("#address").text(res[6]);
			$("#tin").text(res[7]);
			$("#tincode").text(res[8]);
			$("#state").text(res[9]);
			$("#city").text(res[10]);
			
			if(document.getElementById('cust_id1').value==1)
			{
				
				$('#credit').attr('disabled',true);
				
				}
				else{
					$('#credit').attr('disabled',false);
					}
			
		});
		}


var iv = "0";
var totamt=0;
var totcgst=0;
var totsgst=0;
                      var cv = "0";
$(document).on('focusin', '.dispatch_qty', function(){
$(this).data('val', $(this).val());

}).on('change','.dispatch_qty', function(){
iv = $(this).data('val');

var q=$(this).parent().parent().find('.qty').val();

if(parseFloat($(this).val()) <=q) {
cv = $(this).val(); 

var rate=$(this).parent().parent().find('.rate1').val();


var new_qty=cv-iv;

var result= parseFloat(rate)*parseFloat(new_qty);
var result1= parseFloat(rate)*parseFloat(cv);
var tax1=$(this).parent().parent().find('.cgstnew').val();
var tax2=$(this).parent().parent().find('.sgstnew').val();
var gross=$(this).parent().parent().find('.grossamt').val();
var cgst_calu=parseFloat(tax1)*parseFloat(cv);
var sgst_calu=parseFloat(tax2)*parseFloat(cv);
var grossamt=parseFloat(gross)*parseFloat(cv);
var cgst_calu1=parseFloat(tax1)*parseFloat(new_qty);
var sgst_calu1=parseFloat(tax2)*parseFloat(new_qty);
var grossamt1=parseFloat(gross)*parseFloat(new_qty);
function round(value, decimals) {
return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}


//alert(cv);
//alert(cgst_calu);
//alert(sgst_calu);
var cgst12=round(cgst_calu,2);
$(this).parent().parent().find('.changecgst').val(cgst_calu);

var sgst12=round(sgst_calu,2);

$(this).parent().parent().find('.changesgst').val(sgst_calu);
$(this).parent().parent().find('.grossamt').val(grossamt);
totcgst=parseFloat(totcgst)+parseFloat(cgst_calu1);
totsgst=parseFloat(totsgst)+parseFloat(sgst_calu1);
var cgst121=round(totcgst,2);
var sgst121=round(totsgst,2);
//alert(totcgst);
//alert(totsgst);

var nw=parseFloat(rate)*parseFloat(new_qty);
$(this).parent().parent().find('.sum').text(result1);
totamt=parseFloat(totamt)+parseFloat(result);

$(".totamt").html(parseFloat(totamt).toFixed(2));
$("#total-amt").text(parseFloat(totamt).toFixed(2));
$(".cgst1").val(parseFloat(totcgst).toFixed(2));
$(".amttot").val(parseFloat(totamt).toFixed(2));
$(".sgst1").val(parseFloat(totsgst).toFixed(2));

}
else
{
$(this).val(parseInt(0));
alert('Please enter valid qty ');   
var result1=0;
var cgst_calu=0;
var sgst_calu=0;
var grossamt=0;
cv = $(this).val(); 
var rate=$(this).parent().parent().find('.rate1').val();

var new_qty=cv-iv;
var result= parseFloat(rate)*parseFloat(new_qty);
$(this).parent().parent().find('.sum').text(result1);
totamt=parseFloat(totamt)+parseFloat(result);
var tax1=$(this).parent().parent().find('.cgstnew').val();
var tax2=$(this).parent().parent().find('.sgstnew').val();
var gross=$(this).parent().parent().find('.grossamt').val();
var cgst_calu1=parseFloat(tax1)*parseFloat(new_qty);
var sgst_calu1=parseFloat(tax2)*parseFloat(new_qty);
var grossamt1=parseFloat(gross)*parseFloat(new_qty);
totcgst=parseFloat(totcgst)+parseFloat(cgst_calu1);
totsgst=parseFloat(totsgst)+parseFloat(sgst_calu1);
//~ totcgst=0;
//~ totsgst=0;
$(".totamt").html(parseFloat(totamt).toFixed(2));
$(".cgst1").val(parseFloat(totcgst).toFixed(2));
$(".amttot").val(parseFloat(totamt).toFixed(2));
$(".sgst1").val(parseFloat(totsgst).toFixed(2));
}
});


	


	</script>    
     
