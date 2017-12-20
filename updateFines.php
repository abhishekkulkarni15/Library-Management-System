<?php
$con = new mysqli("localhost","root","","library1");

$sql = "delete from fines where loan_id in (select loan_id from book_loans where date_in is null and due_date < current_date)";
if ($con->query($sql) === TRUE) {
	$sql = "insert into fines (select loan_id,'0','0' from book_loans where date_in is null and due_date<current_date);";
	if ($con->query($sql) === TRUE) {
		$sql = "update fines, book_loans set fine_amt = (case when datediff(current_date,due_date)*0.25 >0 then datediff(current_date,due_date)*0.25 end) where book_loans.loan_id = fines.loan_id;";
		if ($con->query($sql) === TRUE) {
			echo "Done updating fines";
		}
		else{
			echo "Cannot calculate fine.";
		}
	} else {
		echo "Unable to insert updated fine values";
	}
} else {
	echo "Unable to delete records from fine due to internal error.";
}
?>
