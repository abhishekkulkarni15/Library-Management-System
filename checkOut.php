<?php
$cardId = $_GET["cardId"];
$bookISBN = $_GET["bookISBN"];

$con = new mysqli("localhost","root","","library1");

$sql = "select count(*) from borrower where card_id = '".$cardId."'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$c = $row["count(*)"];
if($c>0){
	$sql = "select count(*) as cardIdCount from book_loans where card_id=' ". $cardId. " ' and date_in is null";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$i = $row["cardIdCount"];

	$sql = "select max(loan_id) from book_loans";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$loan_id = $row["max(loan_id)"];
	$loan_id=$loan_id+1;
	/*$sql = "insert into book_loans(loan_id, isbn, card_id, date_out, due_date, date_in) values(' ". $loan_id. " ',' ". $bookISBN. " ',)";*/

	if($i<3){
		$sql = "select count(*) from book_loans where isbn='".$bookISBN."' and date_in is null";
		$result = $con->query($sql);
		$row = $result->fetch_assoc();
		$isbnCheck= $row["count(*)"];
		if($isbnCheck==0){
			$sql = "INSERT INTO book_loans(loan_id,isbn,card_id,date_out,due_date,date_in) VALUES('".$loan_id."','".$bookISBN."','".$cardId."',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 14 DAY),null)";
			if ($con->query($sql) === TRUE) {
				echo "Book successfully checked out";
				header('refresh:2;url=index.html');
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
				header( "refresh:1;url=book.html?isbn=".$bookISBN."");
			}
		}
		else{
			echo "Book Already lent";
			header('refresh:1;url=book.html?isbn='.$bookISBN);
		}
	}
	else{
		echo "Already the user has taken 3 books.";
		header ('refresh:1;url=book.html?isbn='.$bookISBN);
	}
}
else{
	echo "Invalid User Id entered";
	header('refresh:1;url=book.html?isbn='.$bookISBN);
}

?>
