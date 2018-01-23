var baseURL = "http://www.cop4331-2.com/API"

var userID = 0;
var firstName = "";
var lastName = "";

function doLogin() {
	userID = 0;
	firstName = "";
	lastName = "";

	var userName = document.getElementById("form-username").value;
	var password = document.getElementById("form-password").value;

	document.getElementById("loginResult").innerHTML = "";

	// replace with appropriate varaible names
	var payload = '{"login" : "' + userName + '", "password" : "' + password'"}';

	var xhr = new XMLHttpRequest();
	xhr.open("POST", baseURL + "/Login.php", false);
	xhr.setRequestHeader("Content-type", "application/json");

	try {
		xhr.send();

		// XMLHttpRequest.response vs. XMLHttpRequest.responseText?
		var data = JSON.parse(xhr.responseText);
		userID = data.id;

		if(userID == 0) {
			// update when result is implemented
			document.getElementById('loginResult').innerHTML = "Incorrect username/password combination. Please try again.";
			return;
		}

		// may change when displayname is implemented
		firstName = data.firstName;
		lastName = data.lastName;

		// implement displayName later
		document.getElementById('displayName').innerHTML = firstName + " " + lastName;

		document.getElementById('form-username').value = "";
		document.getElementById('form-password').value = "";

		// implement when more features complete
		// showElement('access', true);
		// showElement('loggedIn', true);
		
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

// todo
function searchContacts() {
	document.getElementById("searchContacts").innerHTML = "";
}
