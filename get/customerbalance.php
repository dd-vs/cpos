 <?php
	include("../include/include.php"); 
    unset($_SESSION['customermail']);
	$a4=isset($_POST['a4']) ? $_POST['a4']:'';
  $val=$conn->query("SELECT master_cities.name as city,ti_customer.cus_balance,ti_customer.mobile,ti_customer.TIN,ti_customer.email,ti_customer.Address_l1,master_states.name,master_states.tin_code FROM `ti_customer` left join master_cities on master_cities.id=ti_customer.city_id left join master_states on master_states.id=master_cities.state_id where ti_customer.id='$a4'");
  $val->setfetchmode(PDO::FETCH_ASSOC);
 
  
  while($v=$val->fetch())
  {
	  $_SESSION['customermail'] = $v['email'];
echo $v['cus_balance'].','.$v['mobile'].','.$v['Address_l1'].','.$v['name'].','.$v['tin_code'].','.$v['TIN'].','.$v['city']; }
    ?>
