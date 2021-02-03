<?php 
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(4); 
	$query="select  DATE_FORMAT(ti_stock.transaction_date,'%d/%m/%Y') as transaction_date,ti_product.name,ti_category.name as cat,ti_product.item_stock,ti_stock.qty_stock,ti_stock.qty_in,ti_stock.qty_out from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() order by ti_stock.transaction_date" ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);

	?>

<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Stock Summary<span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <div class="row">
            <div class="col-md-8">
                <form class="" id="" action="stock_report_summ.php" method="post">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>From</span>
                            </span>
                           <input type="text" class="form-control" name="fromdate" id="fdate" value="" required/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>To</span>
                            </span>
                           <input type="text" class="form-control" name="todate" id="todate" value="" required/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit" name="searchbydate">Search</button>
                     </div>
                </form>
            </div>
            <div class="col-md-4">
                <form  class="" id="" action="stock_report_summ.php" method="post">
                    <div class="col-md-12 search-c -div-">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search_pro" placeholder="Search">
                            <div class="input-group-btn">
                              <button class="btn btn-default" type="submit" name="search">
                                <i class="glyphicon glyphicon-search"></i>
                              </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
    </div>
 <input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>">
    <div class="report-body">
        <table class="table default-table" id="invPTable">
            <tr>
                <th>Slno</th>
                 <th>Date</th>
                 <th>Product</th>
                <th>Category</th>
                <th>Qty_in</th>
                <th>Qty_out</th>
               
                <th style="width:10%;">Stock</th>
                
            </tr>
            <?php 
      if(isset($_POST['search']))
{    
	$name=$_POST['search_pro'];
	$query="select  DATE_FORMAT(ti_stock.transaction_date,'%d/%m/%Y') as transaction_date,ti_product.name,ti_category.name as cat,ti_product.item_stock,ti_stock.qty_stock,ti_stock.qty_in,ti_stock.qty_out from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on ti_product.cat_id=ti_category.id
	where ti_category.name like  '%".$name."%' or ti_product.name like  '%".$name."%'" ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);

$i=1;
 while($r=$s->fetch()){
            ?>
           
            <tr>
                <td><?php echo $i; ?></td>
                 <td><?php echo $r['transaction_date']; ?></td>
                <td><?php echo $r['name']; ?></td>
               
                <td><?php echo $r['cat']; ?></td>
                <td><?php echo $r['qty_in']; ?></td>
                <td><?php echo $r['qty_out']; ?></td>
                <td class="-txt"><?php echo $r['qty_stock']; ?></td>
            </tr>
            <?php $i++;}
}      
      if(isset($_POST['searchbydate']))
{    
	$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');

	$query="select  DATE_FORMAT(ti_stock.transaction_date,'%d/%m/%Y') as transaction_date,ti_product.name,ti_category.name as cat,ti_product.item_stock,ti_stock.qty_stock,ti_stock.qty_in,ti_stock.qty_out from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date BETWEEN '$f' and '$t' order by ti_stock.transaction_date" ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$i=1;
 while($r=$s->fetch()){
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                
                <td><?php echo $r['transaction_date']; ?></td>
                <td><?php echo $r['name']; ?></td>
                <td><?php echo $r['cat']; ?></td>
                <td><?php echo $r['qty_in']; ?></td>
                <td><?php echo $r['qty_out']; ?></td>
                <td class="-txt"><?php echo $r['qty_stock']; ?></td>
            </tr>
            <?php $i++;}
}      

$i=1;
 while($r=$s->fetch()){
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                 <td><?php echo $r['transaction_date']; ?></td>
                <td><?php echo $r['name']; ?></td>
               
                <td><?php echo $r['cat']; ?></td>
                <td><?php echo $r['qty_in']; ?></td>
                <td><?php echo $r['qty_out']; ?></td>
                <td class="-txt"><?php echo $r['qty_stock']; ?></td>
            </tr>
            <?php $i++;}

?>
 
        </table>
    </div>
</div>
<!-----report content end ----->
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
                          pageMargins: [ 40, 100, 40, 80 ],
						  
						  header: {
							    margin: [40, 40, 40, 65],  
							columns: [
                                        [
                                            {columns:[
                                                    {width: 130, text: 'Stock Report Summ From', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('fnvno').value, fontSize: 10, alignment: 'left'},
                                                    {width: 20, text: 'To', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('tnvno').value, fontSize: 10, alignment: 'left'}
                                                    ],margin: [0,0,0,10]}, 
                                                     { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },       
                                           {table: { 
                                            widths: [ 50, 60,  60, 100, 80,50,50],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
                                            { canvas: [{ type: 'line', x1: -5, y1: 2, x2: 515, y2: 2, lineWidth: 1.5 }] },
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                        
										
                                        {table: {
                                                widths: [ 50, 60,  60, 100, 80,50,50],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: 'noBorders' },
                                       
                                       {table: {
                                                widths: [ 50, 60,  60, 100, 80,50,50],
												margin: [0,0,0,10],
                                                 body: parseTableFoot("invPTable") }, layout: 'noBorders' },
                                       

										 {columns:[
											 {width: 200, text: '', fontSize: 10, alignment: 'left'},
											 { text: '', fontSize: 10, alignment: 'right'},
											 
										 ],
										 margin: [0,10],}
                                    ]
                      });
                }  	
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
