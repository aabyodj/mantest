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

function hideErrorHints(form) {
	form.querySelectorAll('.error + .hint.dynamic').forEach(elem => {
		elem.remove();
	});
	form.querySelectorAll('.error').forEach(elem => {
		elem.className = '';
	});
}

function createErrorHint(controlId, message) {
	let elem = document.createElement('p');
	elem.className = 'hint dynamic';
	elem.innerText = message;
	let control = document.getElementById(controlId);
	control.insertAdjacentElement('afterend', elem);
	control.className = 'error';
	return elem;
}

function collectFormValues(form) {
	return Object.values(form).reduce(
		(obj, field) => { 
			obj[field.name] = field.value; 
			return obj;
		}, 
		{});
}

function hideLoginError() {
	let elem = document.getElementById('login-error');
	if (elem != null) {
		elem.remove();
	}
}

function showLoginError() {
	let elem = document.createElement('p');
	elem.className = 'error';
	elem.id = 'login-error';
	elem.innerText = 'Login or password is incorrect';
	let submitBtn = document.querySelector('#login-form button[type="submit"]');
	submitBtn.insertAdjacentElement('beforeBegin', elem);
	return elem;
}

async function postJson(request, url) {
	let response = await fetch(url, {
		method: 'POST',
		headers: {'Content-Type': 'application/json;charset=utf-8'},
		body: JSON.stringify(request)
	});
	return await response.json();	
}

async function login(event) {
	event.preventDefault();
	removeSignupMessage();
	hideLoginError();
	let loginForm = document.getElementById('login-form');
	let credentials = collectFormValues(loginForm);
	let result = await postJson(credentials, 'login.php');
	if (!result.success) {
		showLoginError();
		return;
	}
	let user = result.user;
	hideLoginForm();
	loginForm.reset();	
	document.querySelector('main').innerHTML = '<p>Hello ' + user.name + '</p><button id="logout-button" type="button">Log out</button>';
	document.getElementById('logout-button').addEventListener('click', logout);
}

function logout() {
	document.querySelector('main').innerHTML = '<p>Hello! You are not logged in.';
	showLoginForm();
}

function showSignupErrors(errors) {
	if (errors.login !== undefined) {
		if (errors.login !== true) {
			createErrorHint('sf-login', errors.login);
		} else {
			document.getElementById('sf-login').className = 'error';			
		}
	}
	if (errors.password !== undefined) {
		document.getElementById('sf-password').className = 'error';	
	}
	if (errors.confirmPassword !== undefined) {
		createErrorHint('sf-confirm-password', errors.confirmPassword);		
	}
	if (errors.email !== undefined) {
		createErrorHint('sf-email', errors.email);
	}
	if (errors.name !== undefined) {
		document.getElementById('sf-name').className = 'error';
	}
}

function checkUser(user) {
	let result = {success: true};
	let errors = {};
	const passwordPattern = /^[0-9]+[0-9a-z]*[a-z]+$|^[a-z]+[0-9a-z]*[0-9]+$/i;
	if (!passwordPattern.test(user.password)) {
		errors.password = 'Password must contain both and only digits and latin letters';
		result.success = false;
	}
	if (user.password != user.confirm_password) {
		errors.confirmPassword = 'Passwords don\'t match';
		result.success = false;
	}
	const namePattern = /^[a-zа-я]+$/i;
	if (!namePattern.test(user.name)) {
		errors.name = 'Name must comprise only letters';
		result.success = false;
	}
	if (!result.success) {
		result.errors = errors;
	}
	return result;
}

async function signup(event) {
	event.preventDefault();
	removeSignupMessage();
	let signupForm = document.getElementById('signup-form');
	hideErrorHints(signupForm);
	let user = collectFormValues(signupForm);
	let result = checkUser(user);
	if (!result.success) {
		showSignupErrors(result.errors);
		return;
	}
	result = await postJson(user, 'signup.php');
	if (!result.success) {
		showSignupErrors(result.errors);
		return;
	}
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
