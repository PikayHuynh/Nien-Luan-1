<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
define('ROOT', __DIR__);

// Đăng ký Exception Handler để hiển thị trang 500
set_exception_handler(function($e) {
    // Ghi log lỗi vào server để dev kiểm tra sau này
    error_log("Uncaught Exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    
    // Trả về HTTP Status 500
    http_response_code(500);
    
    // Hiển thị giao diện trang 500
    if (file_exists(ROOT . '/views/error/500.php')) {
        include ROOT . '/views/error/500.php';
    } else {
        echo "<h1>500 Internal Server Error</h1>";
    }
    exit;
});

require 'config/database.php';  // tạo $conn
require 'routes/web.php';       // load routes