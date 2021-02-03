<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(6.1);
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
    <h2 class="margin-top-10">Tax Report</h2>
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
        <table class="table default-table report-table">
            <tr>
                <th style="width:5%"><i class="fa fa-th-large" aria-hidden="true"></i></th>
                <th>Date</th>
                <th>I/V no</th>
                <th>Total Sales</th>
                <th>GST @ 0%</th>
                <th>GST @ 5%</th>
                <th>GST @ 12%</th>
                <th>GST @ 18%</th>
                <th>GST @ 28%</th>
                
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
	$query1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax ,sum(ti_sale_invoice.amt) as totalsales, 
	ti_sale_invoice.sale_date,min(ti_sale_invoice.invoice_num) as start,max(ti_sale_invoice.invoice_num) as last FROM 
	`ti_tax` left join ti_sale_invoice  on ti_tax.inv_id=ti_sale_invoice.invoice_id left join ti_sale_item on
	 ti_sale_invoice.invoice_id = ti_sale_item.invoice_id WHERE ti_tax.inv_type=1 and 
	 ti_sale_invoice.IsHidden=10 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59'  and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date) ";
	$s1=$conn->query($query1);
	$res=$s1->setfetchmode(PDO::FETCH_ASSOC);
	$query21="SELECT sum(ti_sale_invoice.amt) as totalsales,ti_sale_invoice.invoice_num, ti_sale_invoice.sale_date from ti_sale_invoice  
	WHERE  ti_sale_invoice.IsHidden=10 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1  group by date(ti_sale_invoice.sale_date)";
	$s21=$conn->query($query21);
	$res21=$s21->setfetchmode(PDO::FETCH_ASSOC);
    


            if(count($res)>0){
	$totamt=0;$totamt1=0;$totamt2=0;$totamt3=0;$totamt4=0;$totamt5=0; $i=1;  while($r1=$s1->fetch()){
		$re=$s21->fetch(); 
		$totamt+=$re['totalsales'];
		//~ $totamt+=$r1['amt'];
		//~ $totamt1+=$r1['cgst_amt'];
		//~ $totamt2+=$r1['sgst_amt'];?>
             <tr class="sales box">
                <td><?php echo $i;?></td>
                <td><?php echo $r1['saledate']; ?></td>
                <td><?php echo $r1['start'].'-'.$r1['last']; ?></td>
                <td><?php echo $re['totalsales']; ?></td>
                <?php 
                //~ $qq1="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq1=$conn->query($qq1);
                //~ $sq1->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss1=$sq1->fetch();
               // if($ss1['tax']==0.00){
					$qqs1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=0.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)  ";
					$sqs1=$conn->query($qqs1);
					 $sqs1->setfetchmode(PDO::FETCH_ASSOC);
                $sss1=$sqs1->fetch();
                $totamt1+=$sss1['taxamt'];
			//}
                ?>
                   
                     <td class="red -txt"><?php echo $sss1['taxamt']; ?></td>
                   <?php 
                //~ $qq="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq=$conn->query($qq);
                //~ $sq->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss=$sq->fetch();
                //if($ss['tax']==5.00){
					$qqs="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=5.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date) ";
					$sqs=$conn->query($qqs);
					 $sqs->setfetchmode(PDO::FETCH_ASSOC);
                $sss=$sqs->fetch();
                $totamt2+=$sss['taxamt'];
                ?>
                   <?php //} ?>
                <td class="red -txt"><?php echo $sss['taxamt']; ?></td>
             
              <?php
                //~ $qq2="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq2=$conn->query($qq2);
                //~ $sq2->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss2=$sq2->fetch();
                //if($ss['tax']==5.00){
					$qqs2="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=12.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs2=$conn->query($qqs2);
					 $sqs2->setfetchmode(PDO::FETCH_ASSOC);
                $sss2=$sqs2->fetch();
                $totamt3+=$sss2['taxamt'];
                ?>
                   <?php //} ?>
                <td class="red -txt"><?php echo $sss2['taxamt']; ?></td>
             
              
                 <?php
                //~ $qq3="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq3=$conn->query($qq3);
                //~ $sq3->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss3=$sq3->fetch();
                //if($ss['tax']==5.00){
					$qqs3="SELECT sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and
					 (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=18.00 and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date)";
					$sqs3=$conn->query($qqs3);
					 $sqs3->setfetchmode(PDO::FETCH_ASSOC);
                $sss3=$sqs3->fetch();
                $totamt4+=$sss3['taxamt'];
                ?>
                   <?php //} ?>
                <td class="red -txt"><?php echo $sss3['taxamt']; ?></td>
                   <?php
                //~ $qq4="SELECT (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent) as tax from ti_tax where ti_tax.inv_type=1  group by ti_tax.id";
                //~ $sq4=$conn->query($qq4);
                //~ $sq4->setfetchmode(PDO::FETCH_ASSOC);
                //~ $ss4=$sq4->fetch();
                //if($ss['tax']==5.00){
					$qqs4="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
					left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
					(ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=28.00 and ti_tax.isActive=1 group by date(ti_sale_invoice.sale_date) and 
	ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59'";
					$sqs4=$conn->query($qqs4);
					 $sqs4->setfetchmode(PDO::FETCH_ASSOC);
                $sss4=$sqs4->fetch();
                $totamt5+=$sss4['taxamt'];
                ?>
                   <?php //} ?>
                <td class="red -txt"><?php echo $sss4['taxamt']; ?></td>
            </tr>
            <?php $i++; 
            $qqs1="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,sum(ti_tax.ctax_amt+ti_tax.stax_amt) as taxamt ,sum(ti_tax.taxable_amt) as taxbleamt from ti_tax 
            left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_tax.inv_id where ti_tax.inv_type=1 and 
            (ti_tax.cgst_tax_percent+ti_tax.sgst_tax_percent)=0.00 and 
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
            
            echo "<tr class=\"sales box\">
            <td></td>
            <td></td>
<td  align=\"right\" >Taxableamt</td>
<td align=\"right\"></td>
<td align=\"right\">".number_format($sss1['taxbleamt'],2,'.','')."</td>
<td align=\"right\">".number_format($sss['taxbleamt'],2,'.','')."</td>
<td align=\"right\">".number_format($sss2['taxbleamt'],2,'.','')."</td>
<td align=\"right\">".number_format($sss3['taxbleamt'],2,'.','')."</td>
<td align=\"right\">".number_format($sss4['taxbleamt'],2,'.','')."</td>
</tr>";
           
                 }    echo "<tr class=\"sales box\">
            <td></td>
            <td></td>
<td  align=\"right\" >Total</td>
<td align=\"right\" >".number_format($totamt,2,'.','')."</td>
<td align=\"right\" class=\"red\">".number_format($totamt1,2,'.','')."</td>
<td align=\"right\" class=\"red\">".number_format($totamt2,2,'.','')."</td>
<td align=\"right\" class=\"red\">".number_format($totamt3,2,'.','')."</td>
<td align=\"right\" class=\"red\">".number_format($totamt4,2,'.','')."</td>
<td align=\"right\" class=\"red\">".number_format($totamt5,2,'.','')."</td>
</tr>";  }
                      
                      
                      
                      }?>  
            
        </table>
    </div>
</div>
<?php
html_close();
?>
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
