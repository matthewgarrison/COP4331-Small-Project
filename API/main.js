var baseURL = "http://www.cop4331-2.com/API"

var userID = 0;
var firstName = "";
var lastName = "";

function doLogin() {
	userID = 0;
	firstName = "";
	lastName = "";

	// replace with element id's from HTML file
	var userName = document.getElementById("userName").value;
	var password = document.getElementById("password").value;

	document.getElementById("loginResult").innerHTML = "";

	// replace with appropriate varaible names
	var payload = '{"login" : "' + userName + '", "password" : "' + password'"}';
	var url = baseURL + "/Login.php";

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json");

	try {
		xhr.send();

		// XMLHttpRequest.response vs. XMLHttpRequest.responseText?
		var data = JSON.parse(xhr.responseText);
		userID = data.id;

		if(userID == 0) {
			// update HTML content to display message
			document.getElementById('loginResult').innerHTML = "Incorrect username/password combination. Please try again.";
			return;
		}

		firstName = data.firstName;
		lastName = data.lastName;

		// confirm ID from HTML file
		document.getElementById('displayName').innerHTML = firstName + " " + lastName;

		// confirm username and password IDs in HTML file
		document.getElementById('userName').value = "";
		document.getElementById('password').value = "";

		// update to element ID from HTML file
		showElement('accessUI', false);
		showElement('loggedIn', false);
		showElement('login', true);
	}
	catch(error) {
		// confirm HTML IDs
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

function searchContacts() {
	document.getElementById("searchContacts").innerHTML = "";
}
