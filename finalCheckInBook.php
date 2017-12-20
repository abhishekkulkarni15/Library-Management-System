<?php
$fineAmount=$_GET["fineAmount"];
$isbn=$_GET["isbn"];
$con = new mysqli("localhost","root","","library1");

$sql = "update fines set fine_amt = fine_amt - ".$fineAmount.", paid = '1' where loan_id = (select loan_id from book_loans where isbn = '".$isbn."' and date_in is null)";
if ($con->query($sql) === TRUE) {
	$sql = "update book_loans set date_in = current_date where isbn = '".$isbn."' and date_in is null";
	if ($con->query($sql) === TRUE) {
		echo "Fine paid and the book is checked in.";
	} else {
		echo "Error updating record: " . $con->error;
	}
} else {
	echo "Error updating record: " . $con->error;
}

$con->close();
?>
