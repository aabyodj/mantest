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
		</header>
		<main>
			<?php if (isset($user_name)): ?>
				<p>Hello <?php echo $user_name; ?></p>
				<button id="logout-button" type="button">Log out</button>
			<?php else: ?>
				<p>Hello! You are not logged in.
			<?php endif; ?>
		</main>
		<aside>
			<form id="login-form" method="POST" style="display: none">
				<label for="lf-login">Login</label>
				<input id="lf-login" name="login" type="text" required>
				<label for="lf-password">Password</label>
				<input id="lf-password" name="password" type="password" required>
				<button type="submit">Log in</button>
				or <a href="" id="signup-link">Sign up</a>
			</form>
			<form id="signup-form" method="POST" style="display: none">
				<label for="sf-login">Login</label>
				<input id="sf-login" name="login" type="text" minlength=<?php echo LOGIN_LENGTH; ?> required>
				<label for="sf-password">Password</label>
				<input id="sf-password" name="password" type="password" minlength=<?php echo PASSWORD_LENGTH; ?> required>
				<label for="sf-confirm-password">Confirm password</label>
				<input id="sf-confirm-password" name="confirm_password" type="password" minlength=<?php echo PASSWORD_LENGTH; ?> required>
				<label for="sf-email">Email</label>
				<input id="sf-email" name="email" type="email" required>
				<label for="sf-name">Name</label>
				<input id="sf-name" name="name" type="text" minlength=<?php echo NAME_LENGTH; ?> required>
				<button type="submit">Sign up</button>
				or <a href="" id="login-link">Log in</a>
			</form>
			<noscript>
				<p>JavaScript support is required. Please enable JavaScript in your browser.
			</noscript>
		</aside>
	</body>
</html>
