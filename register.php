<?php
$name = $_GET["name"];
$ssn = $_GET["ssn"];
$address = $_GET["address"];
$phone = $_GET["phone"];

$con = new mysqli("localhost","root","","library1");
$sql = "select max(card_id) from borrower";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$i = $row["max(card_id)"];
$i=$i+1;
$sql = "insert into borrower values('".$i."','".$ssn."','".$name."','".$address."','".$phone."');";


if ($con->query($sql) === TRUE) {
	echo "New record created successfully";
	echo "User Id is ".$i;
	header('refresh:2;url=index.html');
} else {
	echo "Cannot create borrower record. Duplicate SSN found";
	header( "refresh:2;url=register.html" );
}
?>
