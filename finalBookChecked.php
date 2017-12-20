<?php
$isbn=$_GET["isbn"];
$con = new mysqli("localhost","root","","library1");
$sql = "update book_loans set date_in = current_date where isbn = '".$isbn."' and date_in is null";
if ($con->query($sql) === TRUE) {
    echo "Book Checked In successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$con->close();
?>
