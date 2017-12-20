<?php
$borrowerId=$_GET["borrowerId"];
$con = new mysqli("localhost","root","","library1");

$sql = "update fines set paid = '1' where loan_id in (select loan_id from book_loans where card_id ='".$borrowerId."')";
if ($con->query($sql) === TRUE) {
	$sql = "update book_loans set date_in = current_date where card_id = '".$borrowerId."'";
	if ($con->query($sql) === TRUE) {
		echo "Successfully paid fine. Now you can check out new books";
	}
}
else{
	echo "error";
}
?>
