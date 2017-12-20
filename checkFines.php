<?php
$isbn=$_GET["isbn"];
$con = new mysqli("localhost","root","","library1");
$sql = "select (case when datediff(current_date,due_date)*0.25 > 0 then datediff(current_date,due_date)*0.25 else 0 end) as fines from book_loans where date_in is null and isbn =  '".$isbn."'";
$result = $con->query($sql);
if ($result->num_rows > 0) 
{
  while($row = $result->fetch_assoc()){
    echo $row['fines'];
  }
}
$con->close();
?>