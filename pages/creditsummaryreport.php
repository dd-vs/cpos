<?php
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(0);
$party_type = $_POST['partytype'];
$party_id = $_POST['partyid'];
$fromdate = isset($_POST['fromdate'])? DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d') :'';
$todate = isset($_POST['todate'])? DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d') :'';
$query = "SELECT date_format(tin.pay_date,'%d-%m-%Y') as pay_date,
(case when tin.purpose_code ='1' then 'Purchase'
 	  when tin.purpose_code ='2' then 'Purchase Return'
 	  when tin.purpose_code ='3' then 'Sale'
 	  when tin.purpose_code ='4' then 'Sale Return'
 	  when tin.purpose_code ='5' then 'Cashbook'
 else '' end) as purposecode,
tin.invoice_id,tin.amt as inamt,tout.amt as outamt,(tin.amt - tout.amt) as amtdiff 
FROM ti_payments_out as tout 
LEFT JOIN ti_payments_in as tin ON tout.id = tin.id  where 1=1 ";
if ($party_type !='') {
	$query .= "and (tin.party_type = '".$party_type."' and tout.party_type = '".$party_type."') ";
}
if ($party_id !='') {
	$query .= "and (tin.from_id = '".$party_id."' and tout.to_id = '".$party_id."') ";
}
if ($fromdate !='' and $todate !='') {
	$query .= "and (tin.pay_date BETWEEN '".$fromdate."' and '".$todate."') and  (tout.pay_date BETWEEN '".$fromdate."' and '".$todate."') ";
}
$query .=" order by tout.id";
$s=$conn->query($query);
$result=$s->fetchAll(PDO::FETCH_ASSOC);
?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Credit Summary Report <span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <form class="" id="" action="creditsummaryreport.php" method="post">
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>From</span>
                        </span>
                       <input type="text" class="form-control" name="fromdate" id="fdate" value="" required/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>To</span>
                        </span>
                       <input type="text" class="form-control" name="todate" id="todate" value="" required/>
                    </div>
                </div>
             
               
                 <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Type</span>
                        </span>
                        <select class="form-control" id="partytype" name="partytype" >                        
                            <option value="1">CUSTOMER</option>
                            <option value="2">SUPPLIER</option>
                        </select>
                    </div>
                </div> 
				<div class="col-md-2">
					<div class="input-group" id="cust_ip">
						<span class="input-group-addon">
							<span>Customer</span>
						</span>
						<input type="text" name="customer" id="customer" class="form-control"    onblur="" />
					</div>
					<div class="input-group" id="sup_ip">
						<span class="input-group-addon">
							<span>Supplier</span>
						</span>
						<input type="text" name="supplier" id="supplier"  class="form-control"   onblur="" />
					</div>
				</div>
				<div class="col-md-1">
                    <button class="btn btn-primary" type="submit" id="sub" name="searchbydate"><i class="glyphicon glyphicon-search"></i></button>
                </div>
				
				<div class="col-md-2"></div>
  
            </div>
            
			
			
			
			<input id="partyid" name="partyid" type="hidden" />
        </form>
    </div>
           
 
			
			<input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>"><input type="hidden" id="invno" value="<?php if(isset($_POST['inv_num'])){ echo $_POST['inv_num']; } ?>">
			<input type="hidden" id="cust" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>">
										 <table class="table default-table report-table " >
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Invoice #</th>
                <th style="text-align: right;">Credit</th>
				<th style="text-align: right;">Debit</th>
                <th style="text-align: right;">Diffrence</th>

            </tr>
         
			<?php
			if (count($result) >0) {
				$id=1;
				$credit=0;
				$debit=0;
				$diffamt=0; 
				foreach($result as $data) {
					?>
						<tr class="purchase box">
							<td><?php echo $id; ?></td>
							<td><?php echo $data['pay_date']; ?></td>
							<td><?php echo $data['purposecode']; ?></td>
							<td><?php echo $data['invoice_id']; ?></td>	
							<td style="text-align: right;"><?php echo $data['inamt']; ?></td>
							<td style="text-align: right;"><?php echo $data['outamt']; ?></td>
							<td style="text-align: right;"><?php echo $data['amtdiff']; ?></td>
						</tr>
					<?php
					$id++;
					$credit = $credit+$data['inamt'];
					$debit = $debit+$data['outamt'];
				}
				if ($debit !='' or $credit !='') {
					$diffamt = $credit-$debit;
					?>
						<tr class="purchase box">
							<td colspan="4" style="text-align: right;">Total</td>
							<td style="text-align: right;"><?php echo number_format($credit,2,'.',''); ?></td>
							<td style="text-align: right;"><?php echo number_format($debit,2,'.',''); ?></td>
							<td style="text-align: right;"><?php echo number_format($diffamt,2,'.',''); ?></td>
						</tr>
					<?php
				}
			}else {
				?>
					<tr class="purchase box">
							<td colspan="7" style="text-align: center;">No records found</td>
						</tr>
				<?php
			}
			?> 
        </table>
    </div>
</div>
<?php
html_close();
?>
<!-----report content end ----->
<script src="../libs/pdfmake.min.js"></script>
<script src="../libs/vfs_fonts.js"></script>
<script>
$(function () {                 
$("#customer").autocomplete({
minLength:2,
source: "../get/search.php?q=getitem",
select: function (e, ui) {
var i=ui.item.id;
document.getElementById('partyid').value=i;
}
});
});
$(function () {         
	$("#supplier").autocomplete({
	minLength:2,
		source: "../get/search.php?p=get",
		select: function (e, ui) {
			var i=ui.item.id;
			document.getElementById('partyid').value=i;
		}
	});
	$('#sup_ip').hide();
});
$('#partytype').change(function(){
	var partytype = $('#partytype').val();
	if (partytype == 1){
		$('#cust_ip').show();
		$('#sup_ip').hide();
	}
	else if (partytype == 2){
		$('#cust_ip').hide();
		$('#sup_ip').show();
	}
		
});	
	 function printInv(){
                   
                     function parseTableHead(tabId) {
                        var tBody   =   new Array();
                        var tWidth  =   document.getElementById(tabId).rows[0].cells.length;
                            tBody[0] = new Array();
                                for(j = 0; j < tWidth; j++){ 
                                                      var x=document.getElementById(tabId).rows[0].cells[j].style.textAlign;
                    switch (x)
									{
											case "right":
											tBody[0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10,alignment:'right' ,};
											break;
											case "left" :
											tBody[0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10,alignment:'left' ,};
											break;
											case "center" :
											tBody[0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10,alignment:'center' ,};
											break;
											default:
											 tBody[0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10,};
										}
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
								
								   //~ alert(j); 
										//~ if(tBody[i][3])
										//~ continue;					
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
											default:
											 tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 10,};
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
                           pageSize: {width: 585, height: 900},

                        // by default we use portrait, you can change it to landscape if you wish
                          pageOrientation: 'portrait',

                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                          pageMargins: [ 40, 110, 40, 80 ],
						  
						  header: {
							    margin: [40, 40, 40, 65],  
							columns: [
                                        [
                                            {columns:[
                                                    {width: 130, text: 'Sales Invoice Report From', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('fnvno').value, fontSize: 10, alignment: 'left'},
                                                    {width: 20, text: 'To', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('tnvno').value, fontSize: 10, alignment: 'left'},
                                                      {width:70, text: 'Invoice No', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('invno').value, fontSize: 10, alignment: 'left'},
                                                    ],margin: [0,0,0,10]}, 
                                            {columns:[
                                                    {width: 130, text: 'Buyer Name', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('cust').value, fontSize: 10, alignment: 'left'},
                                                   
                                                    ],margin: [0,0,0,10]}, 
                                                     { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },       
                                           {table: { 
                                            widths: [ 50, 100,  60, 100,40,70,60],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
                                            { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                        
										
                                        {table: {
                                                widths: [ 50, 100,  60, 100, 40,70,60],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                       {table: {
                                                widths: [ 70,100,40,100, 50,30,100],
												margin: [0,0,0,10],
                                                 body: parseTableFoot("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },

										 {columns:[
											 {width: 200, text: '', fontSize: 10, alignment: 'left'},
											 { text: '', fontSize: 10, alignment: 'right'},
											 
										 ],
										 margin: [0,10],}
                                    ]
                      });
                }     
    
<!------  PDF Print -------------->

	function popup(url) 
	{
	 var width  = 960;
	 var height = 500;
	 var left   = (screen.width  - width)/2;
	 var top    = (screen.height - height)/2;
	 var params = 'width='+width+', height='+height;
	 params += ', top='+top+', left='+left;
	 params += ', directories=no';
	 params += ', location=no';
	 params += ', menubar=no';
	 params += ', resizable=no';
	 params += ', scrollbars=yes';
	 params += ', status=no';
	 params += ', toolbar=no';
	 newwin=window.open(url,'windowname5', params);
	 if (window.focus) {newwin.focus()}
	 return false;
	}
	
	 function edit(e,id) {

$('#txtedit_transaction').val(id);
var myvar = id;
//alert(myvar);
'<%Session["temp"] = "' + myvar +'"; %>';
popup("invoiceedit.php?temp=" + myvar);
}
//~ $(document).ready(function(){
      //~ $("select").change(function(){

              //~ $(this).find("option:selected").each(function(){
                      //~ var optionValue = $(this).attr("value");
                      //~ if(optionValue){
                              //~ $(".box").not("." + optionValue).hide();
                              //~ $("." + optionValue).show();
                      //~ } else{
                              //~ $(".box").show();
                      //~ }
              //~ });
      //~ }).change();
//~ });
    //~ $('#fdate').change(function(){
		//~ alert("fgh");
    //~ $.ajax({
        //~ type: "POST",
        //~ url: "sales_report.php",
       //~ data: {text:$(this).val()}
    //~ });
//~ });
//~ $('#sub').click(function(){
	
	//~ var k=$('#fdate').val();
	//~ alert(k);
	
//~ });
    var picker = new Pikaday(
    {
        field: document.getElementById('fdate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
    var picker = new Pikaday(
    {
        field: document.getElementById('fdate'),
        field: document.getElementById('todate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
 var today = new Date();                     

                      var formattedtoday = today.getDate() + '/' + (today.getMonth() + 0) + '/' + today.getFullYear();
                    
                      
                      document.getElementById("fdate").value=formattedtoday;
    document.getElementById('todate').value=moment(new Date()).format('DD/MM/YYYY');
</script>
