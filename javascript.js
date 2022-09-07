function hideLoginForm() {
	document.getElementById('login-form').style.display = 'none';
}

function hideSignupForm() {
	document.getElementById('signup-form').style.display = 'none';
}

function showLoginForm() {
	hideSignupForm();
	document.getElementById('login-form').style.display = '';
}

function showSignupForm() {
	hideLoginForm();
	document.getElementById('signup-form').style.display = '';
}

function removeSignupMessage() {
	let signupResult = document.getElementById('signup-message');
	if (signupResult != null) {
		signupResult.remove();
	}	
}

function showSignupMessage(user) {
	removeSignupMessage();
	let message = document.createElement("p");
	message.innerHTML = 'Successfully signed up user <b>' + user.name + '</b> with login <b>' + user.login + '</b>';
	message.className = 'success';
	message.id = 'signup-message';
	let container = document.querySelector('main + aside');
	container.insertBefore(message, container.children[0]);
}

function collectFormValues(form) {
	return Object.values(form).reduce(
		(obj, field) => { 
			obj[field.name] = field.value; 
			return obj;
		}, 
		{});
}

function login(event) {
	event.preventDefault();
	removeSignupMessage();
	let login = document.getElementById('lf-login').value;
	hideLoginForm();
	document.getElementById('login-form').reset();	
	document.querySelector('main').innerHTML = '<p>Hello ' + login + '</p><button id="logout-button" type="button">Log out</button>';
	document.getElementById('logout-button').addEventListener('click', logout);
}

function logout() {
	document.querySelector('main').innerHTML = '<p>Hello! You are not logged in.';
	showLoginForm();
}

async function signup(event) {
	event.preventDefault();
	removeSignupMessage();
	let signupForm = document.getElementById('signup-form');
	let user = collectFormValues(signupForm);
	let response = await fetch('signup.php', {
		method: 'POST',
		headers: {'Content-Type': 'application/json;charset=utf-8'},
		body: JSON.stringify(user)
	});
	let result = await response.json();
	console.log(result);
	hideSignupForm();
	signupForm.reset();
	showSignupMessage(user);
	showLoginForm();
}

function initEventListeners() {
	let logoutButton = document.getElementById('logout-button');
	if (logoutButton != null) {
		logoutButton.addEventListener('click', logout);
	} else {
		showLoginForm();
	}
	document.getElementById('login-form').addEventListener('submit', login);
	document.getElementById('signup-form').addEventListener('submit', signup);
	document.getElementById('login-link').addEventListener('click', event => {
		event.preventDefault();
		showLoginForm();
	});
	document.getElementById('signup-link').addEventListener('click', event => {
		event.preventDefault();
		showSignupForm();
	});
}

document.addEventListener('DOMContentLoaded', initEventListeners);
