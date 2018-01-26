var baseURL = "http://cop4331-2.com/API"

var userID = 0;
//var firstName = "";
//var lastName = "";

$(document).ready(function() {
	$('#form-password').keydown(function (event) {
	    var keypressed = event.keyCode || event.which;
	    if (keypressed == 13) {
	        doLogin();
	    }
	});
});

$(document).ready(function() {
	$('#search-username').keydown(function (event) {
	    var keypressed = event.keyCode || event.which;
	    if (keypressed == 13) {
	        searchContacts();
	    }
	});
});

function addContactRow(username, phoneNumber, email, notes){
    var table = document.getElementById("search-table").getElementsByTagName("tbody")[0];

    // New row at top of table (but below add contact boxes)
    var row = table.insertRow(1);

    var buttonCell = row.insertCell(0);

    row.insertCell(0).innerHTML = notes;
    row.insertCell(0).innerHTML = email;
    row.insertCell(0).innerHTML = phoneNumber;
    row.insertCell(0).innerHTML = username;

    buttonCell.setAttribute("style", "width:40px");

    // TODO: Put remove contact functionality here!!!!
    // buttonCell.setAttribute("onclick", "")
}

function doLogin() {

	userID = 0;
	//firstName = "";
	//lastName = "";

	var userName = document.getElementById("form-username").value;
	var password = md5(document.getElementById("form-password").value);

	document.getElementById("loginResult").innerHTML = "";

	// replace with appropriate varaible names
	var payload = '{"username" : "' + userName + '", "password" : "' + password + '"}';

	var xhr = new XMLHttpRequest();
	xhr.open("POST", baseURL + "/Login.php", false);
	xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

	try {
		xhr.send(payload);

		var data = JSON.parse(xhr.responseText);
		userID = data.id;

		if(userID == 0) {
			document.getElementById('loginResult').innerHTML = "Incorrect username/password combination. Please try again.";
			return;
		}

		document.getElementById('form-username').value = "";
		document.getElementById('form-password').value = "";

		// implement when more features complete
		// showElement('access', true);
		showElement('loggedIn-container', true);
		document.getElementById("username").innerHTML = 'Logged in as ' + data.username;

		// this ID only applies to the button
		showElement('login-container', false);
	}
	catch(error) {
		// include result of login in HTML
		document.getElementById('loginResult').innerHTML = error.message;
	}

}

function showElement(id, flag) {

	if(flag) {
		document.getElementById(id).style.visibility = 'visible';
		document.getElementById(id).style.display = 'block';
	}
	else {
		document.getElementById(id).style.visibility = 'hidden';
		document.getElementById(id).style.display = 'none';
	}
}

function doLogout() {

   userID = 0;

   showElement('loggedIn-container', false);
   showElement('login', true);
   showElement('access', false);
}

function addContact() {

   var name = document.getElementById('contactName').value;
   var phone = document.getElementById('contactPhone').value;
   var email = document.getElementById('contactEmail').value;
   var notes = document.getElementById('contactNotes').value;

   var payload = '{"uID" : "' + userID + '", "name" : "' + name + '", "phoneNumber" : "' + phone + '", "email" : "' + email + '", "notes" : "' + notes + '"}';

   var xhr = new XMLHttpRequest();
   xhr.open("POST", baseURL + "/CreateContact.php", true);
   xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

   try {
      xhr.onreadystatechange = function() {
         // if "OK" status-number, and request finished w/ response ready --> indicate success
         if (xhr.status === XMLHttpRequest.DONE && xhr.response === 4) {
            document.getElementById('addContactResult').innerHTML = "Contact added successfully.";
         }
      };

      xhr.send(payload);

   }
   catch(error) {
      document.getElementById('addContactResult').innerHTML = error.message;
   }
}


function searchContacts() {
   var target = document.getElementById('search-username').value;

   var payload = '{"search" : "' + target + '", "uID" : "' + userID + '"}';

   var xhr = new XMLHttpRequest();
   xhr.open("POST", baseURL + "/SearchContact.php", true);
   xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

   try {
      xhr.onreadystatechange = function() {
         if(xhr.status === XMLHttpRequest.DONE && xhr.response === 4) {
            showElement('contactList', true);

            document.getElementById('contactSearchResult').innerHTML = "Contacts retrieved.";

            var data = JSON.parse(xhr.responseText);

            var i;
            for(i = 0; i < data.results.length; i++) {
		var strArray = list.results[i].split(" | ");
		var contactID = strArray[0];

		var contactTable = document.getElementById('search-table');
		var row = contactTable.insertRow(0);

		var nameRow = row.insertCell(0);
		nameRow.innerHTML = strArray[1];

		var phoneRow = row.insertCell(1);
		phoneRow.innerHTML = strArray[2];

		var emailRow = row.insertCell(2);
		emailRow.innerHTML = strArray[3];

		var notesRow = row.insertCell(3);
		notesRow.innerHTML = strArray[4];
            }
         }
      };

      xhr.send(payload);
   }
   catch(error) {
      document.getElementById('contactSearchResult').innerHTML = error.message;
   }
}

function deleteContact(contactID) {

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url + "/DeleteContact.php", true);
	xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

	try {
		xhr.onreadystatechange = function() {
			var payload = '{"userID" : "' + userID + '", "contactID" : "' + contactID + '"}';

			var index = contactID.rowIndex;
			document.getElementById('search-table').deleteRow(index);
		};
		xhr.send(payload);
	}
	catch(error) {
		alert(error.message);
	}

}

function addUser() {

	var userName = document.getElementById("form-username").value;

	var password = md5(document.getElementById("form-password").value);
	var passwordConfirm = md5(document.getElementById("form-password-confirm").value);
	if (password !== passwordConfirm) {
		document.getElementById('passwordCompareAndCreateResult').innerHTML = "Your passwords do not match. Please try again.";
		return;
	}

	password = md5(password);

	document.getElementById("passwordCompareAndCreateResult").innerHTML = "";

	// replace with appropriate varaible names
	var payload = '{"username" : "' + userName + '", "password" : "' + password + '"}';

	var xhr = new XMLHttpRequest();
	xhr.open("POST", baseURL + "/AddUser.php", false);
	xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

	try {
		xhr.send(payload);

		var data = JSON.parse(xhr.responseText);
		error = data.error;

		if(error !== "") {
			document.getElementById('passwordCompareAndCreateResult').innerHTML = "There was an error. Please try again.";
			return;
		}

		// return the to login page
		window.location.href = "http://cop4331-2.com/";
	}
	catch(error) {
		// include result of creation in HTML
		document.getElementById('passwordCompareAndCreateResult').innerHTML = error.message + " Please try again.";
	}

}
