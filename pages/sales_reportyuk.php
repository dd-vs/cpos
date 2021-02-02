<?php 

include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(0);
$query="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s=$conn->query($query);
				$result2=$s->fetchAll(PDO::FETCH_ASSOC);
				$query33="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();
				$query1="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=10 and ti_sale_invoice.sale_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s1=$conn->query($query1);
				$result=$s1->fetchAll(PDO::FETCH_ASSOC);
				$query32="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=10 and ti_sale_invoice.sale_date  between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_sale_invoice.IsActive=1";
				$s32=$conn->query($query32);
				$r32=$s32->fetch();
?>
<!---- report content ----->
<div class="report-container">
	<button class="btn btn-primary" onclick="PrintDiv('invoice');">Print</button>
    <h2 class="margin-top-10">Sales Invoice Report</h2>
    <div class="report-head">
        <form class="" id="" action="sales_reportyuk.php" method="post">
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
                            <option value="sales">Credit</option>
                            <option value="purchase">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit" name="searchbydate">search</button>
                </div>
                <form class="" id="" action="sales_reportyuk.php" method="post">
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="" name="inv_num" value="" placeholder="Invoice num" />
                        <span class="input-group-addon">
                           <button class="glyphicon glyphicon-search" name="searchinvoice" id="invoicesearch"> </button>
                        </span>
                    </div>
                </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" class="form-control" id="" name="name" value="" placeholder="Search Name" />
                        
                        <span class="input-group-addon">
                           <button class="glyphicon glyphicon-search" name="searchinvoice1" id="invoicesearch"> </button>
                           </span>
                        </div>
                    </div>
                        

            
             </form>    
                
                
            </div>
            
        </form>
    </div>
           
     
    <div class="report-body">
        <table class="table default-table report-table">
            <tr>
                <th><i class="fa fa-th-large" aria-hidden="true"></i></th>
                 
                <th>Date Time</th>
                <th>I/V no</th>
                
                <th>Buyer Name</th>
           
                <th>Amount</th>
                <th>Payment</th>
                
            </tr>
             <?php
          if(isset($_POST['searchbydate'])){
				$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');

					$query="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s=$conn->query($query);
				$result2=$s->fetchAll(PDO::FETCH_ASSOC);
				$query33="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();

				$query1="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
				WHERE ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=10 and ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
				$s1=$conn->query($query1);
				$result=$s1->fetchAll(PDO::FETCH_ASSOC);
				$query32="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=10 and ti_sale_invoice.sale_date between '$f 00:00:00' and '$t 23:59:59' and ti_sale_invoice.IsActive=1";
				$s32=$conn->query($query32);
				$r32=$s32->fetch();
					
			  }
            if(isset($_POST['searchinvoice'])){
	 $f=$_POST['inv_num'];
	 $s=$_POST['inv_num'];
$query="SELECT ti_sale_invoice.*,DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_customer.name FROM `ti_sale_invoice` 
				left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
				left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id
	 WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.invoice_num='$f' and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
	$s=$conn->query($query);
$result2=$s->fetchAll(PDO::FETCH_ASSOC);
$query33="SELECT count(ti_sale_invoice.invoice_num) as num ,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice
				WHERE  ti_sale_invoice.IsHidden=10   and ti_sale_invoice.invoice_num='$f' and ti_sale_invoice.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();


	//~ $query1="SELECT ti_sale_item.*,ti_sale_invoice.*,ti_customer.name,ti_product.name as item_name,vehicle_details.vehicle_no as vehicle,master_unit.unit_name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id left join ti_sale_item on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id left join vehicle_details on vehicle_details.vehicle_no=ti_transport.vehicle_num left join master_unit on master_unit.id=ti_product.unit_id
	 //~ WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.invoice_num='$f'";
	//~ $s1=$conn->query($query1);
//~ $result=$s->fetchAll(PDO::FETCH_ASSOC);
//~ $query32="SELECT count(ti_sale_invoice.invoice_num) as num  from ti_sale_invoice
				//~ WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.invoice_num='$f'";
				//~ $s32=$conn->query($query32);
				//~ $r32=$s32->fetch();

										
					
               	
                      
                  
                  
}

  
          if(isset($_POST['searchinvoice1'])){
	 $f=$_POST['name'];
	$query="SELECT DATE_FORMAT(ti_sale_invoice.sale_date,'%d/%m/%Y') as saledate,ti_sale_invoice.*,ti_customer.name FROM `ti_sale_invoice`
	 left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id 
	 left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id 
	
	 WHERE ti_sale_invoice.IsHidden=10 and ti_customer.name like '%$f%' and ti_sale_invoice.IsActive=1 order by ti_sale_invoice.sale_date";
	$s=$conn->query($query);
$result2=$s->fetchAll(PDO::FETCH_ASSOC);
$query33="SELECT count(ti_sale_invoice.invoice_num) as num,sum(ti_sale_invoice.amt) as totamt from ti_sale_invoice left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id WHERE ti_sale_invoice.IsHidden=10 and ti_customer.name like '%$f%' and ti_sale_invoice.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();

	//~ $query1="SELECT ti_sale_item.*,ti_sale_invoice.*,ti_customer.name,ti_product.name as item_name,vehicle_details.vehicle_no as vehicle,master_unit.unit_name FROM `ti_sale_invoice` left join ti_customer on ti_customer.id=ti_sale_invoice.cust_id left join ti_sale_item on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id left join ti_transport on ti_transport.invoice_id=ti_sale_invoice.invoice_id left join vehicle_details on vehicle_details.vehicle_no=ti_transport.vehicle_num left join master_unit on master_unit.id=ti_product.unit_id
	 //~ WHERE ti_sale_invoice.IsHidden=10 and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.invoice_num='$f'";
	//~ $s1=$conn->query($query1);
//~ $result=$s->fetchAll(PDO::FETCH_ASSOC);
//~ $query32="SELECT count(ti_sale_invoice.invoice_num) as num  from ti_sale_invoice
				//~ WHERE  ti_sale_invoice.IsHidden=10  and ti_sale_invoice.cash_credit=11 and ti_sale_invoice.invoice_num='$f'";
				//~ $s32=$conn->query($query32);
				//~ $r32=$s32->fetch();

                      
                  
                  
}
if(count($result2)>0) {
						$totamt=0;
							$i=1; 
						foreach($result2 as $r){
								$totamt+=$r['amt'];
								//$show_date = DateTime::createFromFormat('Y-m-d', $r['sale_date'])->format('d/m/Y');
								
								?>
								<tr class="sales box">
									<td><?php echo $i; ?></td>
									<td><?php echo $r['saledate']; ?></td>
									<td><a href="javascript:void(0)" onclick="edit(this,'<?php echo $r['invoice_id']; ?>')"><form method="get" action="saleinvoiceedit.php"><input type="hidden" name="txtedit_transaction" id="txtedit_transaction" value="0" />
										<input type="hidden" name="id" id="id" value="<?php     echo $r['invoice_id']; ?>" /><?php echo $r['invoice_num']; ?></form></a></td>
                                   
									<td><?php echo $r['name'];?></td>
							
									<td class="-txt"><?php echo $r['amt']; ?></td>
									<?php if($r['cash_credit']==10) {?>
									<td> cash</td><?php } else {?>
									<td> credit</td><?php } ?>
								</tr>
						<?php $i++; }									  
									echo "<tr id=\"credit\" class=\"sales box tbl-footer\">
                                            <td colspan=\"2\" align=\"left\">Invoices : ".number_format($r33['num'],0,'.','')."</td>
											<td colspan=\"2\" align=\"right\">Total</td>
											<td align=\"right\">".number_format($r33['totamt'],2,'.','')."</td>
											<td></td>
										</tr>";
									}							 
									else	{
										echo "<tr id=\"credit\" class=\"purchase box  tbl-footer\"><td colspan=\"9\" align=\"center\">No Data To show</td></tr>";
										}					  

				if(count($result)>0) {
					$totamt1=0; 
					$j=1; 
					foreach($result as $r1){
						$totamt1+=$r1['amt']; ?>
                        <tr class="purchase box">
							<td><?php echo $j; ?></td>
							<td><?php echo $r1['saledate']; ?></td>
							<td><a href="javascript:void(0)" onclick="edit(this,'<?php echo $r1['invoice_id']; ?>')"><form method="get" action="saleinvoiceedit.php"><input type="hidden" name="txtedit_transaction" id="txtedit_transaction" value="0" />
                                  <input type="hidden" name="id" id="id" value="<?php     echo $r1['invoice_id']; ?>" /><?php echo $r1['invoice_num']; ?></form></a></td>
							
							<td><?php echo $r1['name'];?></td>
					
							<td class="-txt"><?php echo $r1['amt']; ?></td>
                              <?php if($r1['cash_credit']==10) {?>
							<td> cash</td><?php } else {?>
							<td> credit</td><?php } ?>
						</tr>
				<?php $j++;	}
				 
							echo "<tr id=\"credit\" class=\"purchase box tbl-footer\">
                                            <td colspan=\"2\" align=\"left\">Invoices : ".number_format($r32['num'],0,'.','')."</td>
											<td colspan=\"2\" align=\"right\">Total</td>
											<td align=\"right\">".number_format($r32['totamt'],2,'.','')."</td>
											<td></td>
										</tr>";
											  }
											 else{
										echo "<tr id=\"cash\" class=\"sales box tbl-footer \"><td colspan=\"9\" align=\"center\">No Data To show</td></tr>";
										}	
				
  ?>
        </table>
    </div>
</div>


<?php
html_close();
?>
<!-----report content end ----->
<script>
	 function edit(e,id) {

$('#txtedit_transaction').val(id);
var myvar = id;
//alert(myvar);
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="invoiceedit.php?temp=" + myvar;
}
$(document).ready(function(){
    $("select").change(function(){
		//~ document.getElementById("cash").style.display="inline-block";
		//~ document.getElementById("credit").style.display="none";
		
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
