<?php 

include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(5); 
$query="select ti_customer.name as cust,ti_customer.cus_balance from ti_customer where id>1 and 	IsActive=1";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$query1="select ti_suppllier.name as sup,ti_suppllier.sup_balance from ti_suppllier where id>1 and 	IsActive=1";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s1=$conn->query($query1);
$s1->setfetchmode(PDO::FETCH_ASSOC);
	?>

<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Credit Report</h2>
    <div class="report-head">
        <form class="" id="" action="credit_report.php" method="post">
            <div class="row">
                <div class="col-md-6 nopadding">
                    <div class="party" onclick="changeClass('type1','type2','cust')" id="type1">Customer</div>
                    <div class="party" onclick="changeClass('type2','type1','sup')" id="type2">Supplier</div>
                </div>
                <div class="col-md-4 search-c">
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
        <table class="table default-table ">
            <tr>
				<thead>                <th style="width:5%;"><i class="fa fa-th-large" aria-hidden="true"></i></th>
                <th>Name</th>
                <th style="width:20%;">Party Type</th>
                <th style="width:15%;">Amount </th>
                </thead>
            </tr>

            <?php
    
      if(isset($_POST['search']))
{    
	$name=$_POST['search_pro'];
	$query="select ti_customer.name as cust,ti_customer.cus_balance from ti_customer where ti_customer.name like '%".$name."%' and  ti_customer.id>1 and ti_customer.IsActive=1";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s=$conn->query($query);
$s->setfetchmode(PDO::FETCH_ASSOC);
$query1="select ti_suppllier.name as sup,ti_suppllier.sup_balance from ti_suppllier where ti_suppllier.name like '%".$name."%' and  ti_suppllier.id>1 and ti_customer.IsActive=1";
//where ti_category.name like '%c%' or ti_product.name like '%c%
	$s1=$conn->query($query1);
$s1->setfetchmode(PDO::FETCH_ASSOC);
}      
            
            
             $i=1; 
         while($r=$s->fetch()){
        
			 ?>
			<tbody>
            <tr id="cust" >
                <td><a class="cust"><?php echo $i;?></a></td>
                <td><?php echo $r['cust']; ?></td>
                <td>Customer</td>
                <td class="red -txt"><?php echo $r['cus_balance']; ?></td>
            </tr>
            <?php $i++; }  while($r1=$s1->fetch()){ ?>
             <tr id="supl"  >
                <td><a class="sup"><?php echo $i;?></a></td>
                <td><?php echo $r1['sup']; ?></td>
                <td>Supplier</td>
                <td class="red -txt"><?php echo $r1['sup_balance']; ?></td>
            </tr>
            <?php $i++; }?>
          </tbody>
           
        </table>
    </div>
</div>
<?php
html_close();
 ?>
<script>
    function changeClass(currentID,nextID,champ){
        var CLASS1 = document.getElementById(currentID)
        var CLASS2 = document.getElementById(nextID)
        var currentClass = CLASS1.className;
        $('tbody tr').hide()
        $('tbody tr:has(a.'+champ+')').show()
        if(currentClass == "party"){
			
            CLASS1.className = "selected";
            CLASS2.className = "party";
           
        } 
      
    }
      //~ $("#type1").click(function(){
			//~ alert("cust");
			//~ $('.td2').toggle("hide");
			//~ //tyle.display="none";
			//~ document.getElementById("cust").style.display="inline-block";
			
			
		//~ });
         //~ $("#type2").click(function(){
			 
        //~ alert("sup");
        //~ //$('.td1').toggle("hide");
        
        //~ $('.td1').toggle("hide");
			
        //~ document.getElementById("supl").style.display="inline-block";
        //~ document.getElementById("cust").style.display="none";
	//~ });
</script>
<!-----report content end ----->
