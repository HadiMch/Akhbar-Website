<?php
require './config/constants.php';
//we will destroy all sessions and redirect user to home page
session_destroy();
header('location: ' . ROOT_URL);
die();