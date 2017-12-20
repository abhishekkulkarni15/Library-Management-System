<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library1";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

$sql = "select count(*) as count from book";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$i = $row["count"];
//echo "Total Book Count: ".$i;

$sql = "select count(*) as count from book_loans where date_in is null";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$j = $row["count"];
//echo "<br>Total Books Out: ".$j;

$sql = "select count(*) as count from book_loans where due_date < current_date and date_in is null";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$k = $row["count"];
//echo "<br>Total Books Due: ".$k;

echo "<table cellpadding='1' class='table table-hover table-condensed' style='width:100%'>";
echo "<tr><th>Total Book count</th><th>Total Books Out</th><th>Total Books Due</th></tr>";
echo "<td>".$i."</td>";
echo "<td>".$j."</td>";
echo "<td>".$k."</td>";
echo "</tr>";
echo "</table>";

?>
