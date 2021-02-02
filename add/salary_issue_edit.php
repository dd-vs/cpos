<?php 

include("../include/include.php"); 

$emp_id=isset($_POST['emp_id']) ? $_POST['emp_id']:'';
$issueid=isset($_POST['issueid']) ? $_POST['issueid']:'';
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
$newdate = date("Y-m-00",strtotime($show_salary_month));
$query="UPDATE `ti_salary_issue` SET `issue_date`='$show_issue_date',`salary_month`='$newdate',`tot_allow`='$tot_allowance',
`tot_deduct`='$tot_deductuction',`net_salary`='$tot_salary',`remarks`='$remarks'     WHERE id='$issueid'";
$co=$conn->query($query);

  if(isset($_POST['all_id1']) && count($_POST['all_id1']) >0) {

$i=0;
foreach($_POST['all_id1'] as $row) {

$all_id1=$_POST['all_id1'][$i];
$sal_a_id=$_POST['sal_a_id'][$i];
$valallow1=$_POST['valallow1'][$i];

$query1="UPDATE `ti_salary_allow_mapping` SET `value`='$valallow1' WHERE `sal_id`='$issueid' and id='$sal_a_id' and `allow_id`='$all_id1'";

$co1=$conn->query($query1);

$i++;
}


}
if(isset($_POST['ded_id1']) && count($_POST['ded_id1']) >0) {

$j=0;
foreach($_POST['ded_id1'] as $row) {

$ded_id1=$_POST['ded_id1'][$j];
$sal_d_id=$_POST['sal_d_id'][$i];
$valueded1=$_POST['valueded1'][$j];
$query11="UPDATE `ti_salary_deduct_mapping` SET `value`='$valueded1' WHERE `sal_id`='$issueid' and  id='$sal_d_id' and`deduct_id`='$ded_id1'";

$co11=$conn->query($query11);

$j++;
}


}

$_SESSION['i']=1;
header('Location: ' . $_SERVER['HTTP_REFERER']);
