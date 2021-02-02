
<?php 

include("../include/include.php"); 
$emp_id=isset($_POST['emp_id']) ? $_POST['emp_id']:'';
$emp_name=isset($_POST['emp_name']) ? $_POST['emp_name']:'';
	$emp_name=test($emp_name);
	$designation=isset($_POST['designation']) ? $_POST['designation']:'';
	$designation=test($designation);
	$remarks=isset($_POST['remarks']) ? $_POST['remarks']:'';
	$remarks=test($remarks);
	$tot_allowance=isset($_POST['totallow']) ? $_POST['totallow']:'';
	$tot_deductuction=isset($_POST['totded']) ? $_POST['totded']:'';
	$tot_salary=isset($_POST['totamt']) ? $_POST['totamt']:'';
	$issueDate=isset($_POST['issueDate']) ? $_POST['issueDate']:'';
	$salary_month=isset($_POST['salary_month']) ? $_POST['salary_month']:'';

	

	$show_issue_date = DateTime::createFromFormat('d/m/Y', $issueDate)->format('Y-m-d');
	$show_salary_month = DateTime::createFromFormat('m/Y', $salary_month)->format('Y-m');
	//~ $time=strtotime($show_issue_date);
//~ $month=date("F",$time);
//~ $year=date("Y",$time);
$newdate = date("Y-m-00",strtotime($show_salary_month));

$query="INSERT INTO `ti_salary_issue`( `emp_id`, `issue_date`, `salary_month`, `tot_allow`, `tot_deduct`, `net_salary`, `remarks`, `IsActive`) VALUES
('$emp_id','$show_issue_date','$newdate','$tot_allowance','$tot_deductuction','$tot_salary','$remarks',1)";
$co=$conn->query($query);
$lid=$conn->lastInsertId();
$query='INSERT INTO `ti_salary_allow_mapping`( `sal_id`, `allow_id`,  `value`, `IsActive`) VALUES ';
			$append_query='';

	if(isset($_POST['allow_id']) && count($_POST['allow_id']) >0) {
				
				$i=0;
				foreach($_POST['allow_id'] as $row) {
				
					$allow_name=$_POST['allow_name'][$i];
					$allow_id=$_POST['allow_id'][$i];
					$value=$_POST['valueallow'][$i];
					$query3="select id from master_allowance where allowance_name='$allow_name'";
				$exec=$conn->query($query3);
				$exec->setfetchmode(PDO::FETCH_ASSOC);
				$ec=$exec->fetch();
				$allowance_id=$ec['id'];
					$append_query .="('$lid','$allow_id','$value','1'),";
					$i++;
				}
			if($append_query !='') {
					$query .=rtrim($append_query,',');
					$conn->query($query);
				}	
				
			}
			$query1='INSERT INTO `ti_salary_deduct_mapping`( `sal_id`, `deduct_id`,  `value`, `IsActive`) VALUES ';
			$append_query='';

	if(isset($_POST['ded_id']) && count($_POST['ded_id']) >0) {
				
				$i=0;
				foreach($_POST['ded_id'] as $row) {
				
					$deduct_name=$_POST['ded_name'][$i];
					$ded_id=$_POST['ded_id'][$i];
					$value1=$_POST['valueded'][$i];
						$query2="select id from master_deduction where deduction_name='$item_name1'";
				$exec2=$conn->query($query2);
				$exec2->setfetchmode(PDO::FETCH_ASSOC);
				$ec2=$exec2->fetch();
				$deduct_id=$ec2['id'];
					$append_query .="('$lid','$ded_id','$value1','1'),";
					$i++;
				}
			if($append_query !='') {
					$query1 .=rtrim($append_query,',');
					$conn->query($query1);
				}	
				
			}

$_SESSION['i']=1;
header('Location: ' . $_SERVER['HTTP_REFERER']);

