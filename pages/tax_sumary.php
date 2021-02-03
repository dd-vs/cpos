<?php 
//ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 //error_reporting(E_ALL);
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(8);
//~ $query33=" SELECT count(invoice_num) as num FROM `ti_sale_invoice`  where IsHidden=10";
//~ $s33=$conn->query($query33);
//~ $s33->setfetchmode(PDO::FETCH_ASSOC);
//~ $r33=$s33->fetch();
//~ $num=$r33['num'];
//~ $query1="SELECT ti_sale_invoice.*,ti_customer.name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id where ti_sale_invoice.IsHidden=10 ";
//~ $s1=$conn->query($query1);
//~ $res=$s1->setfetchmode(PDO::FETCH_ASSOC); 
?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">TAX REPORT<span class="btn btn-primary" onclick="printInv().print();"><i class="fa fa-print" aria-hidden="true"></i> </span></h2>
    <div class="report-head">
        <form class="" id="" action="tax_sumary.php" method="post">
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
              
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit" name="search">Search</button>
                </div>
                 
                  
            </div>
        </form>
    </div> 
    <div class="report-body">
        <table class="table default-table report-table" id="invPTable">
            <tr>
                <th >Slno</th>
                <th>Date</th>
                <th>I/V no</th>
                <th>Total Sales</th>
                <th>GST @ 0%</th>
                <th>GST @ 5%</th>
                <th>GST @12%</th>
                <th>GST @18%</th>
                <th>GST @28%</th>
                
			</tr>
<?php
  if(isset($_POST['search']))
{    
	$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');
	//~ $query="SELECT ti_purchase_invoice.*,ti_suppllier.name FROM `ti_purchase_invoice` left join ti_suppllier on ti_suppllier.id=ti_purchase_invoice.supplier_id 
	//~ WHERE ti_purchase_invoice.IsHidden=10 and   ti_purchase_invoice.`pur_date` between  '$f 00:00:00' and '$t 23:59:59'";
	//~ $s=$conn->query($query);
	//~ $res2=$s->setfetchmode(PDO::FETCH_ASSOC);
	$query1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_sale_invoice.sale_date,sum(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax ,sum(ti_sale_invoice.amt) as totalsales, 
	ti_sale_invoice.sale_date,min(ti_sale_invoice.invoice_num) as start,max(ti_sale_invoice.invoice_num) as last FROM 
	`ti_tax` left join ti_sale_invoice  on ti_tax.inv_id=ti_sale_invoice.invoice_id left join ti_sale_item on
	 ti_sale_invoice.invoice_id = ti_sale_item.invoice_id WHERE ti_tax.inv_type=1 and 
	 ti_sale_invoice.IsHidden=10 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59'  and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date) ";
	$s1=$conn->query($query1);
	$res=$s1->fetchAll(PDO::FETCH_ASSOC);
	$query21="SELECT sum(ti_sale_invoice.amt) as totalsales,ti_sale_invoice.invoice_num, ti_sale_invoice.sale_date from ti_sale_invoice  
	WHERE  ti_sale_invoice.IsHidden=10 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1  group by date(ti_sale_invoice.sale_date)";
	$s21=$conn->query($query21);
	$res21=$s21->setfetchmode(PDO::FETCH_ASSOC);
    
    
    $query22="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,ti_sale_invoice.sale_date ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=0.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
	$s22=$conn->query($query22);
	$res22=$s22->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	 
    $query23="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt1 ,ti_sale_invoice.sale_date,sum(ti_tax.taxable_amt) as taxbleamt1 from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=5.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
	$s23=$conn->query($query23);
	$res23=$s23->fetchAll(PDO::FETCH_ASSOC);
	
	
	 $query24="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt2 ,ti_sale_invoice.sale_date,sum(ti_tax.taxable_amt) as taxbleamt2 from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=12.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
	$s24=$conn->query($query24);
	$res24=$s24->fetchAll(PDO::FETCH_ASSOC);
	
	
	$query25="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt3 ,ti_sale_invoice.sale_date,sum(ti_tax.taxable_amt) as taxbleamt3 from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=18.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
	$s25=$conn->query($query25);
	$res25=$s25->fetchAll(PDO::FETCH_ASSOC);
	
	
	$query26="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt4 ,ti_sale_invoice.sale_date,sum(ti_tax.taxable_amt) as taxbleamt4 from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=28.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
	$s26=$conn->query($query26);
	$res26=$s26->fetchAll(PDO::FETCH_ASSOC);


            if(count($res)>0){
	$totamt=0;$totamt1=0;$totamt2=0;$totamt3=0;$totamt4=0;$totamt5=0; $i=1; 
	 foreach($res as $r1){
		$re=$s21->fetch(); 
		
		$totamt+=$re['totalsales'];
		
		//~ $re1=$s22->fetch(); 
		//~ $totamt1+=$re1['taxamt'];
		
		//~ $re2=$s23->fetch(); 
		//~ $totamt2+=$re2['taxamt1'];
		
		
		//~ $re3=$s24->fetch(); 
		//~ $totamt3+=$re3['taxamt2'];
		
		//~ $re4=$s25->fetch(); 
		//~ $totamt4+=$re4['taxamt3'];
		
		//~ $re5=$s26->fetch(); 
		//~ $totamt5+=$re5['taxamt4'];
		
		//~ echo $r1['sale_date'];
		//~ echo "<br>";
		//~ echo $re2['sale_date'];
		//~ foreach($res23 as $r2)
//~ {		if(in_array($r1['sale_date'] , $r2))
		//~ {
			//~ echo "gdg";
			
			//~ }}
		
		//~ $totamt+=$r1['amt'];
		//~ $totamt1+=$r1['cgst_amt'];
		//~ $totamt2+=$r1['sgst_amt'];?>
		  <input type="hidden" id="tnvno" value="<?php if(isset($_POST['todate'])){ echo $_POST['todate']; } ?>"><input type="hidden" id="fnvno" value="<?php if(isset($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>">
             <tr class="sales box">
                <td><?php echo $i;?></td>
                <td><?php echo $r1['saledate']; ?></td>
                <td><?php echo $r1['start'].'-'.$r1['last']; ?></td>
                <td><?php echo $re['totalsales']; ?></td>
       <td class="red -txt"><?php foreach($res22 as $rr2)
{
		
		if(in_array($r1['sale_date'] , $rr2))
		{
			$totamt1+=$rr2['taxamt'];
			echo $rr2['taxamt'];
			
			}} ?> </td>
       <td class="red -txt"><?php foreach($res23 as $r2)
{	
	
	
	
		if(in_array($r1['sale_date'] , $r2))
		{
			$totamt2+=$r2['taxamt1'];
			echo $r2['taxamt1'];
			
			}} ?> </td>
     
      
       <td class="red -txt"> <?php foreach($res24 as $r4)
{	
	
		if(in_array($r1['sale_date'] , $r4))
		{
			$totamt3+=$r4['taxamt2'];
			echo $r4['taxamt2'];
			
			}} ?> </td>
       <td class="red -txt"> <?php foreach($res25 as $r5)
       
       
{	
	
		if(in_array($r1['sale_date'] , $r5))
		{
			$totamt4+=$r5['taxamt3'];
			echo $r5['taxamt3'];
			
			}} ?> </td>
       <td class="red -txt"> <?php foreach($res26 as $r6)
{
	
			if(in_array($r1['sale_date'] , $r6))
		{
			$totamt5+=$r6['taxamt4'];
			echo $r6['taxamt4'];
			
			}} ?> </td>
                

               
                   <?php
                //~ $qq4="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq4=$conn->query($qq4);
                //~ $sq4->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss4=$sq4->fetch();
                //if($ss['tax']==5.00){
					?>
               
            </tr>
            <?php $i++; 
            $qqs1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
            left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
            (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=0.00and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs1=$conn->query($qqs1);
					 $sqs1->setfetchmode(PDO::FETCH_ASSOC);
                $sss1=$sqs1->fetch();
            $qqs="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
            left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
            (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=5.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs=$conn->query($qqs);
					 $sqs->setfetchmode(PDO::FETCH_ASSOC);
                $sss=$sqs->fetch();
                $qqs2="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from 
                ti_tax left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
                (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=12.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59'  and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs2=$conn->query($qqs2);
					 $sqs2->setfetchmode(PDO::FETCH_ASSOC);
                $sss2=$sqs2->fetch();
                $qqs3="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from 
                ti_tax left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
                (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=18.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs3=$conn->query($qqs3);
					 $sqs3->setfetchmode(PDO::FETCH_ASSOC);
                $sss3=$sqs3->fetch();
                $qqs4="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from 
                ti_tax left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
                (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=28.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs4=$conn->query($qqs4);
					 $sqs4->setfetchmode(PDO::FETCH_ASSOC);
                $sss4=$sqs4->fetch();
            ?>
           <tr class="sales box">
            <td></td>
            <td></td>
<td  align="right" >Taxableamt</td>
<td align="right"></td>
<td align="right"><?php foreach($res22 as $rr2)
{		if(in_array($r1['sale_date'] , $rr2))
		{
			echo $rr2['taxbleamt'];
			
			}} ?></td>
<td align="right"><?php foreach($res23 as $r2)
{		if(in_array($r1['sale_date'] , $r2))
		{
			echo $r2['taxbleamt1'];
			
			}} ?></td>
<td align="right"><?php foreach($res24 as $r4)
{		if(in_array($r1['sale_date'] , $r4))
		{
			echo $r4['taxbleamt2'];
			
			}} ?></td>
<td align="right"><?php foreach($res25 as $r5)
{		if(in_array($r1['sale_date'] , $r5))
		{
			echo $r5['taxbleamt3'];
			
			}} ?></td>
<td align="right"><?php foreach($res26 as $r6)
{		if(in_array($r1['sale_date'] , $r6))
		{
			echo $r6['taxbleamt4'];
			
			}} ?></td>

</tr>
           
                 <?php } ?><tr class="sales box">
            <td></td>
            <td></td>
<td  align="right" >Total</td>
<td align="right" ><?php echo number_format($totamt,2,'.','');?></td>
<td align="right" class="red"><?php echo number_format($totamt1,2,'.','');?></td>
<td align="right" class="red"><?php echo number_format($totamt2,2,'.','');?></td>
<td align="right" class="red"><?php echo number_format($totamt3,2,'.','');?></td>
<td align="right" class="red"> <?php echo number_format($totamt4,2,'.','');?></td>
<td align="right" class="red"> <?php echo number_format($totamt5,2,'.','');?></td>
</tr><?php }
                      
                      
                      
                      }?>  
            
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
                          pageMargins: [ 40, 70, 40, 80 ],
						  
						  header: {
							    margin: [40, 40, 40, 65],  
							columns: [
                                        [
                                            {columns:[
                                                    {width: 130, text: 'Tax Summary     From', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 60, text: ': '+document.getElementById('fnvno').value, fontSize: 10, alignment: 'left'},
                                                    {width: 20, text: 'To', fontSize: 10, bold: true, alignment: 'left'},
                                                    {width: 70, text: ': '+document.getElementById('tnvno').value, fontSize: 10, alignment: 'left'}
                                                    ],margin: [0,0,0,10]}, 
                                                          
                                          
                                           
                                        ]	
								]
						  },
						 

                         
                           content: [
										
                                         {table: { 
                                            widths: [ 18, 60,  53, 50, 50,50,50,50,50],
                                            body: parseTableHead("invPTable") }, layout: '' },
										
                                        {table: {
                                                widths: [ 18, 60,  53, 50, 50,50,50,50,50],
												margin: [0,0,0,10],
                                                 body: parseTableBody("invPTable") }, layout: '' },
                                      
                                       {table: {
                                                widths: [ 18, 60,  53, 50, 50,50,50,50,50],
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
</script>
<!-----report content end ----->
<script>
$(document).ready(function(){
    $("select").change(function(){
		
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
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
      document.getElementById('fdate').value=moment(new Date()).format('DD/MM/YYYY');
    document.getElementById('todate').value=moment(new Date()).format('DD/MM/YYYY');
</script>

