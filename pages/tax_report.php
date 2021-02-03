<?php 
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(8);
//~ $query="SELECT DATE_FORMAT(ti_purchase_invoice.pur_date,'%d/%m/%Y') as purdate,ti_purchase_invoice.*,ti_suppllier.name FROM `ti_purchase_invoice` left join ti_suppllier on ti_suppllier.id=ti_purchase_invoice.supplier_id 
	//~ WHERE ti_purchase_invoice.IsHidden=10 and  ti_purchase_invoice.pur_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_purchase_invoice.IsActive=1 order by ti_purchase_invoice.pur_date";
	//~ $s=$conn->query($query);
	//~ $res2=$s->setfetchmode(PDO::FETCH_ASSOC);
	//~ $query1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_sale_invoice.*,ti_customer.name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
	//~ WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
	//~ $s1=$conn->query($query1);
	//~ $res=$s1->setfetchmode(PDO::FETCH_ASSOC);
?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Tax Report<span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <form class="" id="" action="tax_report.php" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>From</span>
                        </span>
                       <input type="text" class="form-control" name="fromdate" id="fdate" value="" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>To</span>
                        </span>
                       <input type="text" class="form-control" name="todate" id="todate" value="" required/>
                    </div>
                </div>
              
               
                  <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Invoice Type</span>
                        </span>
                        <select class="form-control" id="select" name="select"  >
                            <option value="sales">Sales</option>
                            <option value="purchase">Purchase</option>
                        </select>
                    </div>
                </div>
                 <div class="col-md-2">
                    <button class="btn btn-primary" type="submit" name="search">Search</button>
                </div>
            </div>
        </form>
    </div> 
     <input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>">
    <div class="report-body">
        <table class="table default-table report-table" id="invPTable">
            <tr>
                <th>Slno</th>
                <th>Date</th>
                <th>I/V no</th>
                <th>Party Name</th>
                <th>Amount</th>
                <th>CGST Amt</th>
                <th>SGST Amt</th>
			</tr>
<?php
  if(isset($_POST['search']))
{ 
	$condition = '';
	
				if (isset($_POST['fromdate']) && !empty($_POST['fromdate']) && isset($_POST['todate']) && !empty($_POST['todate'])&& isset($_POST['select']) && !empty($_POST['select'])) {
					  $f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');
				$post=$_POST['select'];
				
				if($post=='purchase')
				{
					$query="SELECT DATE_FORMAT(ti_purchase_invoice.pur_date,'%d/%m/%Y') as purdate,ti_purchase_invoice.*,ti_suppllier.name FROM `ti_purchase_invoice` left join ti_suppllier on ti_suppllier.id=ti_purchase_invoice.supplier_id 
	WHERE ti_purchase_invoice.IsHidden=10 and   ti_purchase_invoice.pur_date between  '$f 00:00:00' and '$t 23:59:59' and ti_purchase_invoice.IsActive=1 order by ti_purchase_invoice.pur_date";
	$s=$conn->query($query);
	$res2=$s->setfetchmode(PDO::FETCH_ASSOC);
	
	                      if(count($res2)>0){
	$tot=0;$tot1=0;$tot2=0;
	$i=1; 
	while($r=$s->fetch()){
		
    $tot+=$r['amt'];
		$tot1+=$r['cgst_amt'];
		$tot2+=$r['sgst_amt'];?>
		 
            <tr class="purchase box">
                <td><?php echo $i;?></td>
                <td><?php echo $r['purdate']; ?></td>
                <td><?php echo $r['invoice_num']; ?></td>
                <td ><?php echo $r['name']; ?></td>
                <td class="red -txt"><?php echo $r['amt']; ?></td>
                <td class="-txt"><?php echo $r['cgst_amt']; ?></td>
                <td class="-txt"><?php echo $r['sgst_amt']; ?></td>
            </tr>
            <?php $i++; }
            
              echo "<tr class=\"purchase box\">
<td  align=\"right\">Total</td>
<td></td>
<td></td>
<td></td>
<td align=\"right\">".number_format($tot,2,'.','')."</td>
<td align=\"right\">".number_format($tot1,2,'.','')."</td>
<td align=\"right\">".number_format($tot2,2,'.','')."</td>
</tr>";
}
					}
					else if($post=='sales'){
						$query1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_sale_invoice.*,ti_customer.name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
	WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
	$s1=$conn->query($query1);
	$res=$s1->setfetchmode(PDO::FETCH_ASSOC);
	 if(count($res)>0){
	$totamt=0;$totamt1=0;$totamt2=0; $i=1; while($r1=$s1->fetch()){ 
		$totamt+=$r1['amt'];
		$totamt1+=$r1['cgst_amt'];
		$totamt2+=$r1['sgst_amt'];?>
             <tr class="sales box">
                <td><?php echo $i;?></td>
                <td><?php echo $r1['saledate']; ?></td>
                <td><?php echo $r1['invoice_num']; ?></td>
                <td><?php echo $r1['name']; ?></td>
                <td class="red -txt"><?php echo $r1['amt']; ?></td>
                <td class="-txt"><?php echo $r1['cgst_amt']; ?></td>
                <td class="-txt"><?php echo $r1['sgst_amt']; ?></td>
            </tr>
            <?php $i++; }
            echo "<tr class=\"sales box\">
<td  align=\"right\" >Total</td>
<td></td>
<td></td>
<td></td>
<td align=\"right\">".number_format($totamt,2,'.','')."</td>
<td align=\"right\">".number_format($totamt1,2,'.','')."</td>
<td align=\"right\">".number_format($totamt2,2,'.','')."</td>
</tr>";
           
                      }
    
						}   
	
    

	
                      
                      }}
                      else{
						 $query1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_sale_invoice.*,ti_customer.name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
	 WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
	 $s1=$conn->query($query1);
	$res=$s1->setfetchmode(PDO::FETCH_ASSOC);
	 if(count($res)>0){
	$totamt=0;$totamt1=0;$totamt2=0; $i=1; while($r1=$s1->fetch()){ 
		$totamt+=$r1['amt'];
		$totamt1+=$r1['cgst_amt'];
		$totamt2+=$r1['sgst_amt'];?>
             <tr class="sales box">
                <td><?php echo $i;?></td>
                <td><?php echo $r1['saledate']; ?></td>
                <td><?php echo $r1['invoice_num']; ?></td>
                <td><?php echo $r1['name']; ?></td>
                <td class="red -txt"><?php echo $r1['amt']; ?></td>
                <td class="-txt"><?php echo $r1['cgst_amt']; ?></td>
                <td class="-txt"><?php echo $r1['sgst_amt']; ?></td>
            </tr>
            <?php $i++; }
            echo "<tr class=\"sales box\">
<td  align=\"right\" >Total</td>
<td></td>
<td></td>
<td></td>
<td align=\"right\">".number_format($totamt,2,'.','')."</td>
<td align=\"right\">".number_format($totamt1,2,'.','')."</td>
<td align=\"right\">".number_format($totamt2,2,'.','')."</td>
</tr>";
           
                      }
						  }
                      
                      
                      
 
           
                      
                      
                      
                      ?>  
            
        </table>
    </div>
</div>
<?php
html_close();
?>
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
                                                    {width: 130, text: 'Tax report  From', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('fnvno').value, fontSize: 10, alignment: 'left'},
                                                    {width: 20, text: 'To', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('tnvno').value, fontSize: 10, alignment: 'left'}
                                                    ],margin: [0,0,0,10]}, 
                                                     { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },       
                                           {table: { 
                                            widths: [ 50, 60,  30, 100, 80,50,50],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
                                            { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                        
										
                                        {table: {
                                                widths: [ 50, 60,  30, 100, 80,50,50],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: 'noBorders' },
                                        { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                       {table: {
                                                widths: [ 50, 60,  30, 100, 80,50,50],
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
<!-----report content end ----->
<script>

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
