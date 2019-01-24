<?php

require_once dirname(__DIR__) . '/common.php';

session_start();

$name = $_SESSION['name'];
$id   = $_SESSION['user_id'];

include dirname(__DIR__) . '/view/hello.phtml';


