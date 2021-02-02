<?php 

	include("../include/include.php"); 
		$qm="SELECT `id`, `type`, `value` FROM `master_config` where type='user-account-limit'";
	$sm=$conn->query($qm);
	$sm->setfetchmode(PDO::FETCH_ASSOC);
	$tm=$sm->fetch();
	
	$user_limit=$tm['value'];
	$qm1="SELECT count(id) as coun FROM `ti_user` ";
	$sm1=$conn->query($qm1);
	$sm1->setfetchmode(PDO::FETCH_ASSOC);
	$tm1=$sm1->fetch();
	$coun=$tm1['coun'];
	if($coun<=$user_limit){
	    $uname=isset($_POST['uname']) ? $_POST['uname']:'';
	    $uname=test($uname);
	    $password=isset($_POST['password']) ? sha1($_POST['password']):'';
	    $con_password=isset($_POST['con_password']) ? sha1($_POST['con_password']):'';
	    $name=isset($_POST['name']) ? $_POST['name']:'';
	    $name=test($name);
	    $mobile=isset($_POST['mobile']) ? $_POST['mobile']:'';
	    $mobile=test($mobile);
	    $email=isset($_POST['email']) ? $_POST['email']:'';
	     $email=test($email);
	   
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	    $address=test($address);
	    $isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	    $qq="select count(uname) as num from ti_user where uname='$uname'";
	    $qq1=$conn->query($qq);
	    $qq1->setfetchmode(PDO::FETCH_ASSOC);
	    $n=$qq1->fetch();
	    $num=$n['num'];
	      if($num==0){ 
	if($password==$con_password && $num==0){
	
	
	$query="INSERT INTO `ti_user`( `uname`, `password`, `name`, `email`, `mobile`, `address`, `IsActive`) VALUES
	 ('$uname','$password','$name','$email','$mobile','$address','$isactive')";
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	if($a)
{	
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
}
else
{
	$_SESSION['in']='101';
$_SESSION['status']= "password or username is incorrect;cannot be save";
header('Location: ' . $_SERVER['HTTP_REFERER']);}
}else{
		$_SESSION['ing']='101';
$_SESSION['status']= "password is incorrect;cannot be save";
header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	}
	}
else{
	$_SESSION['i1']='101';
$_SESSION['status1']= "user limit exeeded";
header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>

