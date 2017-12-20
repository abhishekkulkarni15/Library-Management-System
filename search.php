<?php
$key=$_GET["searchKey"];
$key_part = explode(" ", $key);
$x="";
for ($i = 0; $i <count($key_part); $i++) 
{
  $key_part[$i]=trim($key_part[$i]);
  if(strcmp($key_part[$i],""))
  {
    $x.=" b.isbn  like '%$key_part[$i]%' or b.title like '%$key_part[$i]%' or a.name like '%$key_part[$i]%' ";
    if($i<count($key_part)-1)
      $x.=" or ";
  }
}
$con = new mysqli("localhost","root","","library1");
$sql = "select isbn from book_loans where date_in is null";
$nobooks = $con->query($sql);
$t="";
if($nobooks->num_rows > 0)
{
  while($row = $nobooks->fetch_assoc())
  {
    //$t.=$row['isbn'];
    //$t.=",";
  }
}
$sql = "select b.isbn,b.title,GROUP_CONCAT(a.name) from book as b natural join book_authors natural join authors as a where ($x) group by isbn";
$result = $con->query($sql);
if ($result->num_rows > 0) 
{
  echo "<table cellpadding='1' class='table table-hover table-condensed' style='width:100%'><tr><th>ISBN</th><th>Title</th><th>Authors</th><th>Actions</th></tr>";
  while($row = $result->fetch_assoc()) 
  {
    echo "<tr>";
    echo "<td>" . $row['isbn'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['GROUP_CONCAT(a.name)'] . "</td>";
    echo "<td><button type='button' class='btn btn-success' onclick=checkOut('$row[isbn]');>Check Out</button></td>";
    echo "</tr>";
  } 
  echo "</table>";
} 
else
{
  echo " Sorry! Could not find anything... ";
}
$con->close();
?>