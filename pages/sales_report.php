<?php
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(0);

				$query1="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s1=$conn->query($query1);
				$result=$s1->fetchAll(PDO::FETCH_ASSOC);
				$query32="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date  between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1";
				$s32=$conn->query($query32);
				$r32=$s32->fetch();
?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Sales Invoice Report <span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <form class="" id="" action="sales_report.php" method="post">
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
                        <select class="form-control" id="select" name="select" >
                         
                            <option value="sales">CREDIT</option>
                               <option value="purchase">CASH</option>
                             <option value="salpur">CASH+CREDIT</option>
                        </select>
                    </div>
                </div> <div class="col-md-1">
                    <button class="btn btn-primary" type="submit" id="sub" name="searchbydate">search</button>
                </div>
                <form class="" id="" action="sales_report.php" method="post">
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="nm" name="inv_num" value="" placeholder="Invoice num" />
                        <span class="input-group-addon">
                           <button class="glyphicon glyphicon-search" name="searchbydate" id="invoicesearch"> </button>
                        </span>
                    </div>
                </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" class="form-control" id="nname" name="name" value="" placeholder="Search Name" />
                        
                        <span class="input-group-addon">
                           <button class="glyphicon glyphicon-search" name="searchbydate" id="invoicesearch"> </button>
                           </span>
                        </div>
                    </div>
                        

            
             </form>    
                
                
            </div>
            
        </form>
    </div>
           
    
   <?php
   $res2;$r3;
   	$condition = '';
     if(isset($_POST['searchbydate'])){
									
										  
                                               if (isset($_POST['inv_num']) && !empty($_POST['inv_num']) ) {
												   $num=$_POST['inv_num'];
												   unset($_POST['fromdate']);  unset($_POST['todate']);
												   unset($_POST['select']);
												   
                                                      $condition .= " AND ti_sale_invoice.invoice_num='$num' ";
                                                      
                                              } 
                                              
                                               if (isset($_POST['name']) && !empty($_POST['name']) ) {
												   $name=$_POST['name']; unset($_POST['fromdate']);  unset($_POST['todate']);
												   unset($_POST['select']);
                                                      $condition .= " and ti_customer.name like '%$name%' ";
                                              } 
                                              if (isset($_POST['fromdate']) && !empty($_POST['fromdate']) && isset($_POST['todate']) && !empty($_POST['todate'])&& isset($_POST['select']) && !empty($_POST['select'])) {
					  $f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');
				$post=$_POST['select'];
				
				if($post=='purchase')
				{
					$condition .= "AND ti_sale_invoice.cash_credit='10' AND ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' ";
					}
					else if($post=='sales'){
						$condition .= "AND ti_sale_invoice.cash_credit='11' AND ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' ";
						}
					else if($post=='salpur'){
						$condition .= "AND ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' ";
						}
                                                      
                                              }
                                              $query="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE  ti_sale_invoice.IsHidden=10  {$condition} and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s=$conn->query($query);
				
				$res2=$s->fetchAll(PDO::FETCH_ASSOC);
				$query3="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id
				WHERE  ti_sale_invoice.IsHidden=10  {$condition} and ti_sale_invoice.IsActive=1";
				$s3=$conn->query($query3);
				$r3=$s3->fetch();
				
			}
			else {
					 $query="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s=$conn->query($query);
				$res2=$s->fetchAll(PDO::FETCH_ASSOC);
				$query3="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date  between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1";
				$s3=$conn->query($query3);
				$r3=$s3->fetch();
			}
				
				
			
				
			?>
			
			<input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>"><input type="hidden" id="invno" value="<?php if(isset($_POST['inv_num'])){ echo $_POST['inv_num']; } ?>">
			<input type="hidden" id="cust" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>">
										 <table class="table default-table report-table " >
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Bill No</th>
                <th>Buyer Name</th>
                <th style="text-align: right;">Amount</th>
                <th>Payment</th>
                 <th>Bill type</th>

            </tr>
            <?php
               
						$totamt=0;
							$i=1; 
						foreach($res2 as $r){
								$totamt+=$r['amt'];
								
								
								?>
								<tr class="purchase box">
									<td><?php echo $i; ?></td>
									<td><?php echo $r['saledate']; ?></td>
									<td><a href="javascript:void(0)" onclick="edit(this,'<?php echo $r['invoice_id']; ?>')"><form method="get" action="saleinvoiceedit.php"><input type="hidden" name="txtedit_transaction" id="txtedit_transaction" value="0" />
                                  <input type="hidden" name="id" id="id" value="<?php     echo $r['invoice_id']; ?>" /><?php echo $r['invoice_num']; ?></td>	
									<td><?php echo $r['name'];?></td>
									<td style="text-align: right;"><?php echo $r['amt']; ?></td>
									<?php if($r['cash_credit']==10) {?>
									<td> cash</td><?php } else {?>
									<td> credit</td><?php } ?>
									<?php if($r['sale_type']==0) {?>
									<td> B to C</td><?php } else {?>
									<td> B to B</td><?php } ?>
						</tr>
									
								</tr>
						<?php $i++; }									  
							echo "<tr id=\"credit\" class=\"purchase box tbl-footer\">
                                            <td align=\"left\">Invoices : ".number_format($r3['num'],0,'.','')."</td>
                                            <td></td>
											<td></td>
											<td align=\"right\">Total</td>
											<td text-align=\"right\">".number_format($r3['totamt'],2,'.','')."</td>
											<td></td>
											<td></td>
										</tr>";	?>	
										 <table class="table default-table report-table no-screen" id="invPTable">
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Bill No</th>
                <th>Buyer Name</th>
                <th style="text-align: right;">Amount</th>
                <th>Payment</th>
                 <th>Bill type</th>

            </tr>
            <?php
               
						$totamt=0;
							$i=1; 
						foreach($res2 as $r){
								$totamt+=$r['amt'];
								
								
								?>
								<tr class="purchase box">
									<td><?php echo $i; ?></td>
									<td><?php echo $r['saledate']; ?></td>
									<td><?php echo $r['invoice_num']; ?></td>	
									<td><?php echo $r['name'];?></td>
									<td style="text-align: right;"><?php echo $r['amt']; ?></td>
									<?php if($r['cash_credit']==10) {?>
									<td> cash</td><?php } else {?>
									<td> credit</td><?php } ?>
									<?php if($r['sale_type']==0) {?>
									<td> B to C</td><?php } else {?>
									<td> B to B</td><?php } ?>
						</tr>
									
								</tr>
						<?php $i++; }									  
							echo "<tr id=\"credit\" class=\"purchase box tbl-footer\">
                                            <td align=\"left\">Invoices : ".number_format($r3['num'],0,'.','')."</td>
                                            <td></td>
											<td></td>
											<td align=\"right\">Total</td>
											<td text-align=\"right\">".number_format($r3['totamt'],2,'.','')."</td>
											<td></td>
											<td></td>
										</tr>";		
									
			
				
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
        maxDate: new Date(2020, 12, 31),
        yearRange: [2016,2020],
        format: 'DD/MM/YYYY',
    });
    var picker = new Pikaday(
    {
        field: document.getElementById('fdate'),
        field: document.getElementById('todate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2016,2020],
        format: 'DD/MM/YYYY',
    });
 var today = new Date();                     

                      var formattedtoday = today.getDate() + '/' + (today.getMonth() + 0) + '/' + today.getFullYear();
                    
                      
                      document.getElementById("fdate").value=formattedtoday;
    document.getElementById('todate').value=moment(new Date()).format('DD/MM/YYYY');
</script>
