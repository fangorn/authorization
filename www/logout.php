<?php

require_once dirname(__DIR__) . '/common.php';

unset($_SESSION['user_id']);

header("Location: auth.php");
