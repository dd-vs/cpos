<?php 
$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}else
if($status == PHP_SESSION_DISABLED){
    //Sessions are not available
}else
if($status == PHP_SESSION_ACTIVE){
    //Destroy current and start new one
    session_destroy();
    session_start();
}
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Kolkata"); 
$servername = "localhost";
	$username 	= "root";
	$password 	= "123456";
	$db			= "cpos";
	  try {
			$conn = new PDO("mysql:host=localhost;dbname=$db", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   //echo "Connected successfully"; 
		
		  }
		catch(PDOException $e)
		  {
			echo "Connection failed: " . $e->getMessage();
		  }
		   function check_session() {
			if(!isset($_SESSION['UID']) || $_SESSION['UID'] =='')
			{
				header("location:./"); exit();
			}

		}
		 function test($sku)
{ 

$string = $sku;
$string=strip_tags($string,"");
//$string = preg_replace('/[^A-Z a-z0-9\s.\s-\@\&]/',' ',$string); 
 $string = str_replace( array( '#','%','^','*','!','$',',','-',"'",'"','/' ,"\\"), ' ', $string);
 // echo $string1;
  return $string;
}

		function html_head() {?>
			 <?php 
		   ?>
		  
		   
		   
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>INVENTORY</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
      
    <!---- styles---->
    <link href="css/color.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/layout.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/pikaday.min.css" rel="stylesheet">
    <link href="images/ico/favicon.png" rel="shortcut icon" type="image/x-icon">
	<link href="images/ico/ico-phone.png" rel="apple-touch-icon">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
       <link rel="stylesheet" href="js/jquery-ui.css">
  </head>
  <body>
      <!--- Shotcut assigning --->
	<script>
		window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="";}
window.history.forward();
              function noBack() { window.history.forward(); } 

			document.onkeydown = function(evt) {
			evt = evt || window.event;

				if (evt.altKey && evt.keyCode == 83) {
					window.open("saleinvoice.php","_self");
				}  
                if (evt.altKey && evt.keyCode == 72) {
					window.open("saleinvoiceh.php","_self");
				} 
				if (evt.altKey && evt.keyCode == 82) {
					window.open("sale_return.php","_self");
				}
				if (evt.altKey && evt.keyCode == 80) {
					window.open("purchaseinvoice.php","_self");
				}
				if (evt.altKey && evt.keyCode == 74) {
					window.open("purchaseinvoiceh.php","_self");
                }
                if (evt.altKey && evt.keyCode == 79) {
					window.open("purchase_return.php","_self");
				}
                if (evt.altKey && evt.keyCode == 75) {
					window.open("sales_reporth.php","_self");
				}
                if (evt.altKey && evt.keyCode == 76) {
					window.open("purchase_reporth.php","_self");
				}
                if (evt.keyCode == 27) {
                    closePopup();
                    closePopup1();
                }
                if (evt.altKey && evt.keyCode == 107) {
                        openPopup();
                }
                if (evt.altKey && evt.keyCode == 73) {
                        PrintDiv('invoice');
                }
                if (evt.altKey && evt.keyCode == 67) {
                        $('.tableOut').focus();
                }
                if (evt.altKey && evt.keyCode == 72) {
                        document.getElementById('setHidden').value='11'
                }
			};
        
	</script><?php
$servername = "localhost";
	$username 	= "root";
	$password 	= "123456";
	$db			= "cpos";

	$conn = new PDO("mysql:host=localhost;dbname=$db", $username, $password);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$query="SELECT `id`, `uname`, `password`, `name`, `email`, `mobile`, `address`, `IsActive` FROM `ti_user` WHERE id='".$_SESSION['UID']."'";
	$q1=$conn->query($query);
	$q1->setfetchmode(PDO::FETCH_ASSOC);
	$q2=$q1->fetch();?>
		    <div class="main-container">
        <div class="logo"></div>
        <div class="top-panel">
			<form class="navbar-form navbar-right" id="frmlogout" action="../logout.php" method="POST">
				<?php ?>
            <div class="user-display" onclick="if(document.getElementById('udp').style.width == '180px'){document.getElementById('udp').style.width ='0px'} else{document.getElementById('udp').style.width ='180px'}"><?php echo $q2['name'];?><i class="fa fa-user-circle" aria-hidden="true"></i></div>
            <div class="user-details -txt-" id="udp">
                <div class="wrap">
					
                    <span class="name"><?php echo $q2['name'];?></span>
                    <span class="uname"><?php echo $q2['uname'];?></span>
                    <span class="email"><?php echo $q2['email'];?></span>
                    <?php  ?>
                    <button type="submit" class="btn btn-primary">Sign Out</button>
                </div> 
            </div>
        </div>
        </form>
        <div class="menu-min">
            <ul class="nav-min">
				<?php }
			function navbar_user($selected='0') {
				?>
                <a href="saleinvoice.php"><li <?php if($selected=='0') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-cart-plus" aria-hidden="true"></i></span><span class="nav-detail">Sale</span><div class="tool-tip nav-help">ALT+S</div></li></a>
                <a href="sale_return.php"><li <?php if($selected=='1') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span><span class="nav-detail">Return</span><div class="tool-tip nav-help">ALT+R</div></li></a>
                <a href="purchaseinvoice.php"><li <?php if($selected=='2') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span><span class="nav-detail">Purchase</span><div class="tool-tip nav-help">ALT+P</div></li></a>
                <a href="purchase_return.php"><li <?php if($selected=='3') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-reply-all" aria-hidden="true"></i></span><span class="nav-detail">Return</span><div class="tool-tip nav-help">ALT+O</div></li></a>
                <a href="sales_report.php"><li <?php if($selected=='4') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-bar-chart" aria-hidden="true"></i></span><span class="nav-detail">Reports</span></li></a>
                <a href="cash_book.php"><li <?php if($selected=='10') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-book" aria-hidden="true"></i></span><span class="nav-detail">Cashbook</span></li></a>
                <a href="product.php"><li <?php if($selected=='6') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-suitcase" aria-hidden="true"></i></span><span class="nav-detail">Product</span></li></a>
                <a href="category.php"><li <?php if($selected=='5') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-cubes" aria-hidden="true"></i></span><span class="nav-detail">Category</span></li></a>
                <a href="customer.php"><li <?php if($selected=='7') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-user" aria-hidden="true"></i></span><span class="nav-detail">Customer</span></li></a>
                <a href="supplier.php"><li <?php if($selected=='8') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-user-o" aria-hidden="true"></i></span><span class="nav-detail">Supplier</span></li></a>
<!--
				<a href="employesalary.php"><li <?php if($selected=='12') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-money" aria-hidden="true"></i></span><span class="nav-detail">Salary Issue</span></li></a>
				<a href="employee.php"><li <?php if($selected=='11') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-id-card-o" aria-hidden="true"></i></span><span class="nav-detail">Employee</span></li></a>
				<a href="salarymaster.php"><li <?php if($selected=='13') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-gears" aria-hidden="true"></i></span><span class="nav-detail">Salary Conf</span></li></a>
-->
                <a href="user.php"><li <?php if($selected=='9') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-user-circle" aria-hidden="true"></i></span><span class="nav-detail">User</span></li></a>
                <a href="estimate.php"><li <?php if($selected=='14') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-list-alt" aria-hidden="true"></i></span><span class="nav-detail">Estimate</span></li></a>
				<a href="creditnote.php"><li <?php if($selected=='15') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-list-ul" aria-hidden="true"></i></span><span class="nav-detail">Credit Note</span></li></a>
				<a href="debitnote.php"><li <?php if($selected=='17') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-list-ul" aria-hidden="true"></i></span><span class="nav-detail">Debit Note</span></li></a>
				<a href="delivery.php"><li <?php if($selected=='16') echo ' class="active" '; ?> ><span class="nav-ico"><i class="fa fa-truck" aria-hidden="true"></i></span><span class="nav-detail">DeliveryNote</span></li></a>
              
            </ul>
        </div>
        <div class="page-content"  onclick="document.getElementById('udp').style.width = '0px'";>
 <?php }
 function html_close() {
 ?>
	      
        </div>
        <div class="footer"></div>
    </div>
    <div id="notify"> </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/moment.min.js"> </script>
    <script src="js/pickaday.min.js"> </script>
    <script src="js/custom.js"> </script>
	<script src="libs/pdfmake.min.js"></script>
    <script src="libs/vfs_fonts.js"></script>
<!--    <script src="js/npm.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
   
      <script src="js/jquery-ui.js"></script> 
      <script>
        function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
					 
				 }
        //  <!------ number to word js ------>       
        var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
        var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

        function inWords (num) {
            if ((num = num.toString()).length > 9) return 'overflow';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return; var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + '' : '';
            return str;
        }
        
         
                $('.form-control').keypress(function(e){
    if ( e.which == 13 ) return false;
    //or...
    if ( e.which == 13 ) e.preventDefault();
});
       function openPopup() {
        document.getElementById("popup").style.height = "100%";
    }
 function closePopup() {
        document.getElementById("popup").style.height = "0%";
    }      
        // <!------ number to word js ------>
    </script>
  </body>
</html>
<?php } ?>
