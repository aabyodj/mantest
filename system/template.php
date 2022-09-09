<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Manao test</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="style.css">
		<script src="javascript.js"></script>
	</head>
	<body>
		<header>
			<h1>Manao test</h1>
			<p>The task is <a href="https://docs.google.com/document/d/1JIRIzYE2xmrPrG6vrbSpDF2FIUNng_J5Gv4GewluB3o/">here</a>
		</header>
		<main>
			<?php if (isset($_SESSION['user'])): ?>
				<p>Hello <?php echo $_SESSION['user']->getName(); ?></p>
				<button id="logout-button" type="button">Log out</button>
			<?php else: ?>
				<p>Hello! You are not logged in.
			<?php endif; ?>
		</main>
		<aside>
			<form id="login-form" method="POST" style="display: none">
				<ul>
					<li>
						<label for="lf-login">Login</label>
						<input id="lf-login" name="login" type="text" required>
					</li>
					<li>
						<label for="lf-password">Password</label>
						<input id="lf-password" name="password" type="password" required>
					</li>
				</ul>
				<button type="submit">Log in</button>
				or <a href="" id="signup-link">Sign up</a>
			</form>
			<form id="signup-form" method="POST" style="display: none">
				<h1>Sign up</h1>
				<p>The login is intentionally not checked for spaces because the task does not specify
					that the login should not contain spaces.
				<ul>
					<li>
						<label for="sf-login">Login</label>
						<input id="sf-login" name="login" type="text" minlength=<?php echo LOGIN_LENGTH; ?> required>
						<p class="hint">Login must contain at least <?php echo LOGIN_LENGTH; ?> characters
					</li>
					<li>
						<label for="sf-password">Password</label>
						<input id="sf-password" name="password" type="password" minlength=<?php echo PASSWORD_LENGTH; ?> required>
						<p class="hint">Passwords must contain at least <?php echo PASSWORD_LENGTH; ?> characters, 
							only letters and digits are allowed, both are required
					</li>
					<li>
						<label for="sf-confirm-password">Confirm password</label>
						<input id="sf-confirm-password" name="confirm_password" type="password" minlength=<?php echo PASSWORD_LENGTH; ?> required>
					</li>
					<li>
						<label for="sf-email">Email</label>
						<input id="sf-email" name="email" type="email" required>
					</li>
					<li>
						<label for="sf-name">Name</label>
						<input id="sf-name" name="name" type="text" minlength=<?php echo NAME_LENGTH; ?> required>
						<p class="hint">Name must comprise only letters and be at least <?php echo NAME_LENGTH; ?> characters long
					</li>
				</ul>
				<button type="submit">Sign up</button>
				or <a href="" id="login-link">Log in</a>
			</form>
			<noscript>
				<p>JavaScript support is required. Please enable JavaScript in your browser.
			</noscript>
		</aside>
	</body>
</html>
