<?php
include("../include/include.php");

$vah_no=isset($_POST['veh_no']) ? $_POST['veh_no']:'';
$veh_name=isset($_POST['veh_name']) ? $_POST['veh_name']:'';
$qty1=isset($_POST['qty1']) ? $_POST['qty1']:'';
$qty=isset($_POST['qty']) ? $_POST['qty']:'';
$IsActive=isset($_POST['isActive']) ? $_POST['isActive']:'1';
echo "rweteyrtu";
$query="INSERT INTO `vehicle_details`(`vehicle_name`, `vehicle_no`, `transport_qty1`, `transport_qty2`,`IsActive`) VALUES('$veh_name','$vah_no','$qty','$qty1','$IsActive')";
echo $query;
$s1=$conn->query($query);
header("location:vehicle.php");

