//get books for search query from index page
function searchBook(){
	var searchKey = document.getElementById("searchText").value;
	if(searchKey!=''){
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET","search.php?searchKey="+searchKey,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("searchresults").innerHTML=xmlhttp.responseText;
			}
		}
	}
}

function searchBorrower(){
	document.getElementById("searchUserResult").style.display= "block";
	var searchKey = document.getElementById("searchUserText").value;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","getBorrower.php?searchKey="+searchKey,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("searchUserResult").innerHTML=xmlhttp.responseText;
		}
	}
}

//provided for individual isbn as a result of search on index.html
function checkOut(x){
	window.location.href = "book.html?isbn="+x;
}


//populate data in index.html for 4 div elements to display the details of library system

function calculateLibraryDetails(){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","calculateLibraryDetails.php",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("totalBooks").innerHTML=xmlhttp.responseText;
		}
	}
}

function checkIn(isbn){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","checkFines.php?isbn="+isbn,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var fineAmount = xmlhttp.responseText;
			if(fineAmount>0){
				if(confirm("Do you want to pay the fine of $"+fineAmount)==true){
					payFine(isbn, fineAmount);
				} else{
					//user doesnt want to pay the fine.
					return;
				}
			} else{
				if(confirm("You do not have any fine for this book. Proceed to Check In?")){
					checkInBook(isbn);
				}else{
					//user doesnt want to check in
					return;
				}
			}
		}
	}
	document.getElementById("searchUserText").value = txt;
}

function checkInBook(isbn){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","finalBookChecked.php?isbn="+isbn,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			alert(xmlhttp.responseText);
			searchBorrower();
		}
	}
}

function payFine(isbn,fineAmount){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","finalCheckInBook.php?isbn="+isbn+"&fineAmount="+fineAmount,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			alert(xmlhttp.responseText);
		}
	}
}

function setISBN(requestedKey) {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	if (typeof requestedKey == 'undefined') {
		return vars;
	} else {
		document.getElementById("bookISBN").value = vars[requestedKey];
		return vars[requestedKey];
	}
}

function checkBorrowerFine(){
	updateFines();
	var borrowerId = document.getElementById("borrowerId").value;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","getBorrowerFine.php?borrowerId="+borrowerId,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("borrowerFine").innerHTML = xmlhttp.responseText;
		}
	}
}

function payFullFine(){
	var borrowerId = document.getElementById("borrowerId").value;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","payFullFineAmount.php?borrowerId="+borrowerId,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("borrowerFine").innerHTML = xmlhttp.responseText;
		}
	}
}

function updateFines(){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","updateFines.php",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("borrowerFine").innerHTML = xmlhttp.responseText;
		}
	}
}