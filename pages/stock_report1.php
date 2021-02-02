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
    <h2 class="margin-top-10">Stock Report</h2>
    <div class="">
        <form class="" id="" action="stock_report1.php" method="post">
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
        <table class="table default-table">
			<tr> <th>Category</th></tr>
            <tr>
				
                <th style="width:5%;"><i class="fa fa-th-large" aria-hidden="true"></i></th>
               
                <th>Product</th>
                <th style="width:10%;">Quantity</th>
                
            </tr>
            <?php 
      if(isset($_POST['search']))
{    
	$name=$_POST['search_pro'];
	$query1="select ti_category.name,ti_category.id from ti_category where ti_category.name like  '%".$name."%'";
$ss=$conn->query($query1);
$ss->setfetchmode(PDO::FETCH_ASSOC);

	
	
while($rr=$ss->fetch()){
	$ide=$rr['id'];
	//echo $ide;
$query="select ti_product.name,ti_category.name as cat,ti_product.item_stock from ti_product left join ti_category on ti_category.id=ti_product.cat_id 
	where ti_product.id<=200 and  ti_category.name like  '%".$name."%' or ti_product.name like  '%".$name."%'  " ;
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
	?>
	 <tr><td><?php echo $rr['name']; ?></td></tr>
	 
<?php	
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
$query="select ti_product.name,ti_product.item_stock,ti_category.name as cat,ti_product.item_stock from ti_product left join ti_category on ti_category.id=ti_product.cat_id where ti_product.id<=200 and  ti_product.cat_id='$ide'";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
	?>
	 <tr><td><?php echo $rr['name']; ?></td></tr>
	 
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
