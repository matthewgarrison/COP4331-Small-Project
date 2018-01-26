var baseURL = "http://www.cop4331-2.com/API"

var userID = 0;
//var firstName = "";
//var lastName = "";

function doLogin() {

	userID = 0;
	//firstName = "";
	//lastName = "";

	var userName = document.getElementById("form-username").value;
	var password = document.getElementById("form-password").value;

	document.getElementById("loginResult").innerHTML = "";

	// replace with appropriate varaible names
	var payload = '{"username" : "' + userName + '", "password" : "' + password'"}';

	var xhr = new XMLHttpRequest();
	xhr.open("POST", baseURL + "/Login.php", false);
	xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

	try {
		xhr.send(payload);

		var data = JSON.parse(xhr.responseText);
		userID = data.id;

		if(userID == 0) {
			// update when result is implemented
			document.getElementById('loginResult').innerHTML = "Incorrect username/password combination. Please try again.";
			return;
		}

		document.getElementById('form-username').value = "";
		document.getElementById('form-password').value = "";

		// implement when more features complete
		showElement('access', true);
		showElement('loggedIn-container', true);

		// this ID only applies to the button; ask to update to ID for the entire form
		showElement('form-login', false);
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

   var payload = '{"uID" : "' + userID + '", "name" : "' + name + '", "phoneNumber" : "' + phone + '", "email" : "' + email + '", "notes" : "' + notes'"}';

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
   var target = document.getElementById('targetName').value;
	document.getElementById("searchContacts").innerHTML = "";

   var contactList = document.getElementById('contactList');
   contactList.innerHTML = "";

   var payload = '{"search" : "' + target + '", "uID" : "' + userID'"}';

   var xhr = new XMLHttpRequest();
   xhr.open("POST", baseURL + "/SearchContact.php", true);
   xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");

   try {
      xhr.onreadystatechange = function() {
         if(xhr.status === XMLHttpRequest.DONE && xhr.response === 4) {
            showElement('contactList', true);

            document.getElementById('contactSearchResult').innerHTML = "Contacts retrieved.";

            var data = JSON.parse(xhr.responseText);

			var list = document.createElement('ul');

            var i;
            for(i = 0; i < data.results.length; i++) {
			   var opt = document.createElement('option');
			   var strArray = list.results[i].split(" | ");
			   var key = strArray.shift();
			   var map = new Map();
			   map.set(key, strArray);

			   var contactTable = document.getElementById('search-table');
			   var row = contactTable.insertRow(0);

			   var idRow = row.insertCell(0);
			   idRow.innerHTML = strArray[0];

			   var
            }
         }
      };

      xhr.send(payload);
   }
   catch(error) {
      document.getElementById('contactSearchResult').innerHTML = error.message;
   }
}

// todo
function deleteContacts() {

}
