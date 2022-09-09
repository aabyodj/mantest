<?php

$_SESSION = array();
setcookie(session_name(), '', time() - 42000);
session_destroy();

header('Location: /');
