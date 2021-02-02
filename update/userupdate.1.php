<?php 
//ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include("../include/include.php"); 
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
	    //~ $tin=isset($_POST['tin']) ? $_POST['tin']:'';
	    //~ $pan=isset($_POST['pan']) ? $_POST['pan']:'';
	    //$city=isset($_POST['cities']) ? $_POST['cities']:'';
	    $address=isset($_POST['address']) ? $_POST['address']:'';
	    $address=test($address);
	    $isactive=isset($_POST['isactive']) ? $_POST['isactive']:'';
	    $proid=isset($_POST['proid']) ? $_POST['proid']:'';
	      $qq="select count(uname) as num,uname from ti_user where uname='$uname'";
	    $qq1=$conn->query($qq);
	    $qq1->setfetchmode(PDO::FETCH_ASSOC);
	    $n=$qq1->fetch();
	    $num=$n['num'];
	    if ($_POST['uname']!=$n['uname']){
	   if($num==0){ 
	    if(isset($_POST['password']) && $_POST['password']!='' ){
	
			
	if($password==$con_password && $num==0){
	
	
	$query="UPDATE `ti_user` SET `uname`='$uname',`password`='$password',`name`='$name',`email`='$email',`mobile`='$mobile',`address`='$address' where id='$proid'";
	 //~ select id from master_cities where name='$city')
	$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	
	if($a)
{	echo "dff";
		$_SESSION['i']=1;
		$_SESSION['status']="successfully saved";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
}
else
{
	$_SESSION['ing']='101';
$_SESSION['status']= "password is incorrect;cannot be save";
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
}
else{
	
	$query="UPDATE `ti_user` SET `uname`='$uname',`name`='$name',`email`='$email',`mobile`='$mobile',`address`='$address' where id='$proid'";
		$r=$conn->query($query);
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	$_SESSION['i']=1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	}
}else{
		$_SESSION['ing']='101';
$_SESSION['status']= "password is incorrect;cannot be save";
header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	}
}
else{
	$query="UPDATE `ti_user` SET `name`='$name',`email`='$email',`mobile`='$mobile',`address`='$address' where id='$proid'";
		$r=$conn->query($query);
		$_SESSION['i']=1;
	$a=$r->setfetchmode(PDO::FETCH_ASSOC);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	}
?>

