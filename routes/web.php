<?php
require_once 'config/database.php';

// Lấy thông tin controller và action từ URL, mặc định dashboard
$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Tạo kết nối DB
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Include controller tương ứng
switch($controllerName) {
    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController($db);
        switch($action) {
            case 'index': $controller->index(); break;
        }
        break;

    case 'khachhang':
        require_once 'controllers/KhachHangController.php';
        $controller = new KhachHangController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'phanloai':
        require_once 'controllers/PhanLoaiController.php';
        $controller = new PhanLoaiController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'hanghoa':
        require_once 'controllers/HangHoaController.php';
        $controller = new HangHoaController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'dongiaban':
        require_once 'controllers/DonGiaBanController.php';
        $controller = new DonGiaBanController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;
    case 'thuoctinh':
        require_once 'controllers/ThuocTinhController.php';
        $controller = new ThuocTinhController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'chungtumua':
        require_once 'controllers/ChungTuMuaController.php';
        $controller = new ChungTuMuaController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'chungtuban':
        require_once 'controllers/ChungTuBanController.php';
        $controller = new ChungTuBanController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
            // case 'create': $controller->create(); break;
            // case 'edit': $controller->edit(); break;
        }
        break;

    case 'chungtuban_ct':
        require_once 'controllers/ChungTuBanCTController.php';
        $controller = new ChungTuBanCTController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'detail': $controller->detail(); break;
            case 'delete': $controller->delete(); break;
        }
        break;

    case 'home':
    require_once 'controllers/HomeController.php';
    $controller = new HomeController($db);
    switch($action) {
        case 'index': $controller->index(); break;
        default: echo "404 Page Not Found"; break;
    }
    break;

    case 'user':
        require_once 'controllers/UserController.php';
        $controller = new UserController($db);
        switch($action) {
            case 'login': $controller->login(); break;
            case 'register': $controller->register(); break;
            case 'profile': $controller->profile(); break;
            case 'orders': $controller->orders(); break;
            case 'logout': $controller->logout(); break;
            case 'editProfile': $controller->editProfile(); break;
            default: echo "404 Page Not Found"; break;
        }
        break;

    case 'product':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController($db);
        switch($action) {
            case 'list': $controller->list(); break;
            case 'detail': $controller->detail(); break;
            default: echo "404 Page Not Found"; break;
        }
        break;

    case 'cart':
        require_once 'controllers/CartController.php';
        $controller = new CartController($db);
        switch($action) {
            case 'index': $controller->index(); break;
            case 'checkout': $controller->checkout(); break;
            // case 'add': $controller->add(); break;
            default: echo "404 Page Not Found"; break;
        }
        break;

    default:
        echo "404 Page Not Found";
        break;
}



