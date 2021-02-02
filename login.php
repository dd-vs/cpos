<?php
include("include/include.php");

if(isset($_POST['txtuser_name']) && isset($_POST['txtpwd']))
{
		$a=$_POST['txtuser_name'];
$que="select activelog,id from ti_user where uname='$a'";	
$st=$conn->query($que);
$st->setfetchmode(PDO::FETCH_ASSOC);
$q=$st->fetch();
$e=$q['activelog'];
$eid=$q['id'];
//~ if($e==0)
//~ {
	
	$uname=$_POST['txtuser_name'];
	$pwd=sha1($_POST['txtpwd']);



	$query="select * from ti_user where uname='$uname' and password='$pwd' and IsActive=1";
	$stmt=$conn->query($query); $stmt->setfetchmode(PDO::FETCH_ASSOC); $result=$stmt->fetch();
$_SESSION['UID']=$result['id'];

	if($result) {

		$_SESSION['UID']=$result['id'];
		
	
		$que="update ti_user set activelog=1 where uname='$a'";	
 $st=$conn->query($que);

			header("location:./pages/saleinvoice.php");
		
		exit();
	} else {
		$_SESSION['i']='101';
$_SESSION['status']= "username/password is incorrect";
		  header("location:./");
		  exit();
		}
	//~ }
//~ else
//~ {
	//~ $_SESSION['in']='100';
	//~ $_SESSION['inid']=$eid;
//~ $_SESSION['stat']= "already logged in";

  //~ header("location:./");
	//~ }
}
?>

