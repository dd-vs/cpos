<?php
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(4);

				$query1="select ti_category.name,ti_category.id from ti_category  ";
$ss=$conn->query($query1);
$ss->setfetchmode(PDO::FETCH_ASSOC);




	?>

<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Stock report <span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="">
        <form class="" id="" action="stock_report.php" method="post">
			 <div class="row">
                <div class="col-md-4 search-c -div-">
                    <form id="">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search_pro" placeholder="Search">
                            <div class="input-group-btn">
                              <button class="btn btn-default" type="submit" name="search">
                                <i class="glyphicon glyphicon-search"></i>
                              </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
    <div class="report-body">
        <table class="table default-table" id="invPTable">
			<tr> <th>Category</th>
			<th style="display:none;"></th>
			<th style="display:none;"></th></tr>
            <tr>
				
                <th style="width:5%;">No</th>
               
                <th>Product</th>
                <th style="width:10%;">Quantity</th>
                
            </tr>
            <?php 
      if(isset($_POST['search']))
{    
	$name=$_POST['search_pro'];
	$query1="select ti_category.name,ti_category.id from ti_category ";
$ss=$conn->query($query1);
$ss->setfetchmode(PDO::FETCH_ASSOC);

	while($rr=$ss->fetch()){
	$ide=$rr['id'];?>
	 <tr><td><?php echo $rr['name']; ?></td>
	 <td></td>
	 <td></td>
	  </tr>
	 <?php
	$query="select ti_product.name,ti_category.name as cat,ti_product.item_stock from ti_product left join ti_category on ti_category.id=ti_product.cat_id 
	where ti_product.name like  '%".$name."%' and ti_product.cat_id='$ide' " ;
	//~ echo $query;
	//~ exit;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$i=1;
 while($r=$s->fetch()){
            ?>
          
            <tr>
				
                <td><?php echo $i; ?></td>
                
                <td><?php echo $r['name']; ?></td>
                <td class="-txt"><?php echo $r['item_stock']; ?></td>
            </tr>
            <?php $i++;}}
}      
while($rr=$ss->fetch()){
	$ide=$rr['id'];
	//echo $ide;
$query="select ti_product.name,ti_product.item_stock,ti_category.name as cat,ti_product.item_stock from ti_product left join ti_category on ti_category.id=ti_product.cat_id where ti_product.cat_id='$ide'";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
	?>
	 <tr><td><?php echo $rr['name']; ?></td>
	 <td></td>
	 <td></td>
</tr>
	 
<?php	
 $i=1;
 while($r=$s->fetch()){
            ?>
          
            <tr>
				
                <td><?php echo $i; ?></td>
                
                <td><?php echo $r['name']; ?></td>
                <td class="-txt"><?php echo $r['item_stock']; ?></td>
            </tr>
            <?php $i++;}}?>
        </table>
    </div>
</div>
<!-----report content end ----->
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
                          pageMargins: [ 40, 90, 40, 80 ],
						  
						  header: {
							    margin: [40, 40, 40, 65],  
							columns: [
                                        [
                                            {columns:[
                                                    {width: 130, text: 'Stock Report', fontSize: 10, bold: true, alignment: 'left'}
                                                   
                                                    ],margin: [0,0,0,10]}, 
                                                      
                                           {table: { 
                                            widths: [ 100, 200,  60],
                                            body: parseTableHead("invPTable") }, layout: 'noBorders' },
                                            
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                        
										
                                        {table: {
                                                widths: [ 100, 200,60],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: '' },
                                 
                                       {table: {
                                                widths: [ 100, 200,60],
												margin: [0,0,0,10],
                                                 body: parseTableFoot("invPTable") }, layout: '' },
                                      

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
