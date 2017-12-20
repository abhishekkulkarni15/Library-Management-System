<?php
$key=$_GET["searchKey"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library1";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if($key==''){
  return;
}
$sql = "select bo.card_id, bo.bname, b.isbn, b.title from borrower bo inner join book_loans bl on bo.Card_ID = bl.card_id inner join book b on b.isbn = bl.isbn where bo.card_id = '".$key."' and date_in is null";
$result = $con->query($sql);
if ($result->num_rows > 0) 
{
  echo "<table cellpadding='1' class='table table-hover table-condensed' style='width:100%'><tr><th>Id</th><th>Name</th><th>ISBN</th><th>Title</th><th>Action</th></tr>";
  while($row = $result->fetch_assoc()) 
  {
    echo "<tr>";
    echo "<td>".$row['card_id']."</td>";
    echo "<td>".$row['bname']."</td>";
    echo "<td>".$row['isbn']."</td>";
    echo "<td>".$row['title']."</td>";
    echo "<td><button type='button' class='btn btn btn-success' onclick=checkIn('$row[isbn]');>Check In</td>";
    echo "</tr>";
  } 
  echo "</table>";
} 
else
{
  echo "<div align='center'><h3><b>Sorry! Could not find anything...</b><h3></div>";
}
$con->close();
?>