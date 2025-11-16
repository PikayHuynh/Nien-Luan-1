<?php
session_start();
define('ROOT', __DIR__);
require 'config/database.php';  // tạo $conn
require 'routes/web.php';       // load routes