<?php
session_start();
session_destroy();
header("Location: login"); // Redirecting To Home Page

?>