<?php 

include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(7); 
$query="select  ti_product.name,ti_category.name as cat,ti_product.item_stock,ti_stock.qty_stock,ti_stock.qty_in,ti_stock.qty_out,ti_stock.transaction_date 
	from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date BETWEEN (CURRENT_DATE - INTERVAL 30 DAY ) and now() order by ti_stock.transaction_date" ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
	$query1="select  sum(ti_stock.qty_in) as num,sum(ti_stock.qty_out) as totamt from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on
	 ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date BETWEEN (CURRENT_DATE - INTERVAL 30 DAY ) and now() order by ti_stock.transaction_date" ;
	$s1=$conn->query($query1);
	$s1->setfetchmode(PDO::FETCH_ASSOC);

	?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Stock Summary</h2>
    <div class="report-head">
        <div class="row">
            <div class="col-md-8">
                <form class="" id="" action="stock_summ_rep.php" method="post">
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
					<input type="text" class="form-control" name="search_pro" placeholder="Search">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit" name="searchbydate">Search</button>
                     </div>
                </form>
            </div>
         
            </div>
        </div>    
    </div>

    <div class="report-body">
        <table class="table default-table">
            <tr>
                <th style="width:5%;"><i class="fa fa-th-large" aria-hidden="true"></i></th>
                 <th>Date</th>
                 <th>Product</th>
                <th>Category</th>
                <th>Qty_in</th>
                <th>Qty_out</th>
               
                <th style="width:10%;">Stock</th>
                
            </tr>
            <?php 
      
      if(isset($_POST['searchbydate']))
{    
	$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');
$name=$_POST['search_pro'];
	$query="select  ti_product.name,ti_category.name as cat,ti_product.item_stock,ti_stock.qty_stock,ti_stock.qty_in,ti_stock.qty_out,ti_stock.transaction_date 
	from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date BETWEEN '$f' and '$t' and ti_product.name like  '%".$name."%' order by ti_stock.transaction_date" ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
	$query1="select  sum(ti_stock.qty_in) as num,sum(ti_stock.qty_out) as totamt from ti_stock left join ti_product on ti_stock.p_id=ti_product.id join ti_category on
	 ti_product.cat_id=ti_category.id
	where ti_stock.transaction_date BETWEEN '$f' and '$t' and ti_product.name like  '%".$name."%' order by ti_stock.transaction_date" ;
	$s1=$conn->query($query1);


            
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
            while( $r1=$s1->fetch()){
            echo "<tr id=\"credit\" class=\"purchase box tbl-footer\">
            <td colspan=\"2\" align=\"right\"></td>
            <td colspan=\"2\" align=\"right\"></td>
                                            <td  align=\"left\">Qty_in : ".number_format($r1['num'],2,'.','')."</td>
											
											<td align=\"left\">Qty_out :".number_format($r1['totamt'],2,'.','')."</td>
									<td></td>
										</tr>";
            }
?>
 
        </table>
    </div>
</div>
<!-----report content end ----->
<?php
html_close();
 ?>
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
