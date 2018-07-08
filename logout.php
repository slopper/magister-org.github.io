<?php
	session_start();

	unset($_SESSION['uId']);
	header("Location: /");