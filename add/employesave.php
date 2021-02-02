<?php 

include("../include/include.php"); 
	$name=isset($_POST['name']) ? $_POST['name']:'';
	$name=test($name);
	$designation=isset($_POST['designation']) ? $_POST['designation']:'';
	$designation=test($designation);
	$passport=isset($_POST['passport']) ? $_POST['passport']:'';
	$passport=test($passport);
	$visa=isset($_POST['visa']) ? $_POST['visa']:'';
	$visa=test($visa);
	$iqama=isset($_POST['iqama']) ? $_POST['iqama']:'';
	$iqama=test($iqama);
	$mobile=isset($_POST['mobile']) ? $_POST['mobile']:'';
	$mobile=test($mobile);
	$alternate_num=isset($_POST['alternate_num']) ? $_POST['alternate_num']:'';
	$alternate_num=test($alternate_num);
	$house_num=isset($_POST['house_num']) ? $_POST['house_num']:'';
	$house_num=test($house_num);
	$address=isset($_POST['address']) ? $_POST['address']:'';
	$address=test($address);
	$state=isset($_POST['state']) ? $_POST['state']:'';
	
	$country=isset($_POST['country']) ? $_POST['country']:'';
	
    $q1="select id from master_countries where  name='$country'";
    $c1=$conn->query($q1);
    $c1->setfetchmode(PDO::FETCH_ASSOC);
    $s1=$c1->fetch();
    $country_id=$s1['id'];
    $q2="select id from master_states where  name='$state'";
    $c2=$conn->query($q2);
    $c2->setfetchmode(PDO::FETCH_ASSOC);
    $s2=$c2->fetch();
    $state_id=$s2['id'];

	
	$join_date=isset($_POST['join_date']) ? $_POST['join_date']:'';
	$show_join_date = DateTime::createFromFormat('d/m/Y', $join_date)->format('Y-m-d');
	$gender=isset($_POST['gender']) ? $_POST['gender']:'';
	$dob=isset($_POST['dob']) ? $_POST['dob']:'';
	$show_dob = DateTime::createFromFormat('d/m/Y', $dob)->format('Y-m-d');
	
	$blood_group=isset($_POST['blood_group']) ? $_POST['blood_group']:'';
	$query1="INSERT INTO `ti_employee`( `name`, `designation`, `join_date`, `passport_num` , `visa_details`, `iqama`, `mobile`, `gender`, `dob`, `blood_group`, `alternate_phon`, 
	`house_num`, `address`, `state`, `country`, `IsActive`) VALUES ('$name','$designation','$show_join_date','$passport','$visa','$iqama','$mobile','$gender','$show_dob','$blood_group',
	'$alternate_num','$house_num','$address','$state_id','$country_id','1')";
	$q=$conn->query($query1);
	
	$lid=$conn->lastInsertId();
		$category=isset($_POST['category']) ? $_POST['category']:'';
		
	

	
	if($lid > 0 ) {
			
			$category1=isset($_POST['category1']) ? $_POST['category1']:'';
		
			
			//
			
			if(isset($_POST['category1']) && count($_POST['category1']) >0) {
				
				$i=0;
				foreach($_POST['category1'] as $row) {
				
					$category1=$_POST['category1'][$i];
					$item_name1=$_POST['item_name1'][$i];
					$item_value1=$_POST['item_value1'][$i];
				$item_value1=trim($item_value1,' ');
					if($category1=="Allowance"){
					$conn->beginTransaction();
			$querya='INSERT INTO `ti_emp_allow_mapping`(`emp_id`, `allow_id`, `value`, `IsActive`) VALUES ';
			$append_querya='';
				$query3="select id from master_allowance where allowance_name='$item_name1'";
				$exec=$conn->query($query3);
				$exec->setfetchmode(PDO::FETCH_ASSOC);
				$ec=$exec->fetch();
				$allow_id=$ec['id'];
					
						$append_querya .="('$lid','$allow_id','$item_value1',1),";
				
					$i++;
				
				
				if($append_querya !='') {
					$querya .=rtrim($append_querya,',');
				
					$conn->query($querya);
				}
				$conn->commit();
					}
		
			else if($category1=="Deduction"){
				$conn->beginTransaction();
			$queryd='INSERT INTO `ti_emp_deduct_mapping`( `emp_id`, `deduction_id`, `value`, `IsActive`) VALUES';
			$append_queryd='';
				$query2="select id from master_deduction where deduction_name='$item_name1'";
				$exec2=$conn->query($query2);
				$exec2->setfetchmode(PDO::FETCH_ASSOC);
				$ec2=$exec2->fetch();
				$deduct_id=$ec2['id'];
				
					
						$append_queryd .="('$lid','$deduct_id','$item_value1',1),";
				
					$i++;
				
				
				if($append_queryd !='') {
					$queryd .=rtrim($append_queryd,',');
				
					$conn->query($queryd);
				}
				$conn->commit();
			}
			}
			}
				$_SESSION['i']=1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
	

	
?>
