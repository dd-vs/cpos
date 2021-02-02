<?php 

include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(0); 
$query="SELECT ti_sale_return.*,DATE_FORMAT(ti_sale_return.ret_date,'%d/%m/%Y') as ret_date,ti_customer.name,ti_sale_invoice.invoice_num FROM `ti_sale_return` left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_sale_return.invoice_id left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id ";
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$query33="SELECT sum(ti_sale_return.ret_amt) as ret_amt from ti_sale_return where ti_sale_return.ret_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_return.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();
	?>

<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Sales Return Report <span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <form class="" id="" action="sales_return_report.php" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>From</span>
                        </span>
                        <input type="text" class="form-control" name="fromdate" id="fdate" value="" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>To</span>
                        </span>
                         <input type="text" class="form-control" name="todate" id="todate" value="" />
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" name="searchbydate" id="datesearch">Search</button>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
						<form class="" id="" action="sales_return_report.php" method="post">
                        <span class="input-group-addon">
                            <span>Search an Invoice</span>
                        </span>
                         <input type="text" class="form-control" id="" name="inv_num" value="" placeholder="Invoice num" />
                        
                        <span class="input-group-addon">
                           <button class="glyphicon glyphicon-search" name="searchinvoice" id="invoicesearch"> </button>
                        </span>
                    </div>
                </div>
                </form>
            </div>
        </form>
    </div>
    <input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>">
    <div class="report-body">
        <table class="table default-table" id="invPTable">
            <tr>
                <th>Slno</th>
                <th>Date</th>
                <th>I/V no</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Payment</th>
                
            </tr>
               <?php
            if(isset($_POST['searchbydate'])){
			$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');
	 
	$query="SELECT ti_sale_return.*,DATE_FORMAT(ti_sale_return.ret_date,'%d/%m/%Y') as ret_date,ti_customer.name,ti_sale_invoice.invoice_num FROM `ti_sale_return` left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_sale_return.invoice_id left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id where ti_sale_return.ret_date between  '$f 00:00:00' and '$t 23:59:59'";
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$query33="SELECT sum(ti_sale_return.ret_amt) as ret_amt from ti_sale_return where ti_sale_return.ret_date between  '$f 00:00:00' and '$t 23:59:59' and ti_sale_return.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();
$i=1; while($r=$s->fetch()){ ?>
	
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $r['ret_date']; ?></td>
                <td><?php echo $r['invoice_num']; ?></td>
                <td><?php echo $r['name']; ?></td>
                <td class="-txt"><?php echo $r['ret_amt'];?></td>
                <?php if($r['pay_mode']==10) {?>
                <td> cash</td>
                <?php } else {?>
					<td>Credit</td><?php } ?>
            </tr>
            <?php $i++;}

}
            if(isset($_POST['searchinvoice'])){
	 $f=$_POST['inv_num'];
	
	 
	$query="SELECT ti_sale_return.*,DATE_FORMAT(ti_sale_return.ret_date,'%d/%m/%Y') as ret_date,ti_customer.name,ti_sale_invoice.invoice_num FROM `ti_sale_return` left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_sale_return.invoice_id left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id where ti_sale_invoice.invoice_num='$f'";
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$query33="SELECT sum(ti_sale_return.ret_amt) as ret_amt from ti_sale_return left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_sale_return.invoice_id where ti_sale_invoice.invoice_num='$f' and ti_sale_return.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();
$i=1; while($r=$s->fetch()){ ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $r['ret_date']; ?></td>
                <td><?php echo $r['invoice_num']; ?></td>
                <td><?php echo $r['name']; ?></td>
                <td class="-txt"><?php echo $r['ret_amt'];?></td>
                <?php if($r['pay_mode']==10) {?>
                <td> cash</td>
                <?php } else {?>
					<td>Credit</td><?php } ?>
            </tr>
            <?php $i++;}
}

$i=1; while($r=$s->fetch()){ ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $r['ret_date']; ?></td>
                <td><?php echo $r['invoice_num']; ?></td>
                <td><?php echo $r['name']; ?></td>
                <td class="-txt"><?php echo $r['ret_amt'];?></td>
                <?php if($r['pay_mode']==10) {?>
                <td> cash</td>
                <?php } else {?>
					<td>Credit</td><?php } ?>
            </tr>
            <?php $i++;}

?>
<tr><td>Total</td> <td></td><td></td><td></td><?php echo "<td align=\"right\">".number_format($r33['ret_amt'],2,'.','')."</td>"?><td></td></tr>
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
                            for(j = 0; j < tWidth; j++){    //alert(document.getElementById(tabId).rows[k].cells[j].innerHTML);
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
                          pageMargins: [ 40, 90, 40, 80 ],
						  
						  header: {
							    margin: [40, 40, 40, 65],  
							columns: [
                                        [
                                            {columns:[
                                                    {width: 130, text: 'Sales Return Report From', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('fnvno').value, fontSize: 10, alignment: 'left'},
                                                    {width: 20, text: 'To', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('tnvno').value, fontSize: 10, alignment: 'left'}
                                                    ],margin: [0,0,0,10]}, 
                                                     { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },       
                                           {table: { 
                                            widths: [ 50, 60,  60, 100, 80,50],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
                                            { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                        
										
                                        {table: {
                                                widths: [ 50, 60,  60, 100, 80,50],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                       {table: {
                                                widths: [ 50, 60,  60, 100, 80,50],
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
</script>
 <script>
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
    document.getElementById('fdate').value=moment(new Date()).format('DD/MM/YYYY');
    document.getElementById('todate').value=moment(new Date()).format('DD/MM/YYYY');
 
 
 </script>
<!-----report content end ----->
