 <?php
 
	include("../include/include.php"); 
	$a4=isset($_POST['a4']) ? $_POST['a4']:'';

  
  $val=$conn->query("SELECT master_cities.name as city,ti_supplier.sup_balance,ti_supplier.phone,ti_supplier.TIN,ti_supplier.mail,ti_supplier.address,master_states.name,master_states.tin_code FROM `ti_supplier` left join master_cities on master_cities.id=ti_supplier.city_id left join master_states on master_states.id=master_cities.state_id where ti_supplier.id='$a4'");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 
  

  while($v=$val->fetch())
  {
	  $_SESSION['customermail'] = $v['mail'];
echo $v['sup_balance'].','.$v['phone'].','.$v['address'].','.$v['name'].','.$v['tin_code'].','.$v['TIN'].','.$v['city']; }
    ?>