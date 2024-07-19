<?php
require_once 'connect.php';

if (isset($_REQUEST['transferid'])) {
	$transferid = $_REQUEST['transferid'];

	$query = mysqli_query($conn, "SELECT * FROM `pending` WHERE `transferid`='$transferid'") or die(mysqli_error());
	$fetch = mysqli_fetch_array($query);
	$services = $fetch['services'];
	$cusname = $fetch['cusname'];
	$cusemail = $fetch['cusemail'];
	$cusnum = $fetch['cusnum'];
	$cusdate = $fetch['cusdate'];
	$cusadd = $fetch['cusadd'];
	$cuscity = $fetch['cuscity'];
	$cusprov = $fetch['cusprov'];
	$Inquiry = $fetch['Inquiry'];

	mysqli_query($conn, "INSERT INTO `pending_scheduled` VALUES('', '$services', '$cusname', '$cusemail', '$cusnum', '$cusdate', '$cusadd', '$cuscity', '$cusprov', '$Inquiry')") or die(mysqli_error());
	mysqli_query($conn, "DELETE FROM `pending` WHERE `id`='$id'") or die(mysqli_error());

	echo "<script>alert('Data successfully transfer')</script>";
	echo "<script>window.location='Customers.php'</script>";
}
