<?php
$borrowerId = $_GET["borrowerId"];
$con = new mysqli("localhost","root","","library1");

$sql = "select count(loan_id) from book_loans where card_id = '".$borrowerId."'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$bookCount = $row["count(loan_id)"];

if($bookCount)
{
	$sql = "select sum(fine_amt) as fine from fines where paid = '0' and loan_id in (select loan_id from book_loans where card_id = '".$borrowerId."')";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$sum_amt = $row["fine"];
	if($sum_amt){
		echo "<table cellpadding='1' class='table table-hover table-condensed' style='width:50%'><tr><th>AMOUNT DUE</th><th>ACTION</th></tr>";
		echo "<tr>";
		echo "<td>".$sum_amt."</td>";
		echo "<td><button type='button' class='btn btn-success' onclick='payFullFine()'>Pay Fine</button></td>";
		echo "</tr>";
		echo "</table>";
	}
	else{
		echo "<center><h3>You do not have any fine.</h3></center>";
	}
}
else{
	echo "<center><h3>The user have not taken any book from library.</h3></center>";
}
?>
