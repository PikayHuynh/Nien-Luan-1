
<?php

/**
 * ==========================
 *  LOAD CONFIG & MODEL
 * ==========================
 */
require_once 'config/database.php';
require_once 'models/KhachHang.php';

/**
 * ==========================
 *  KẾT NỐI DATABASE
 * ==========================
 */
try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Lỗi kết nối DB: ' . $e->getMessage());
}

/**
 * ==========================
 *  LẤY CONTROLLER & ACTION
 * ==========================
 */
$controllerName = $_GET['controller'] ?? 'home';
$action         = $_GET['action'] ?? 'index';

/**
 * ==========================
 *  KIỂM TRA USER / ADMIN
 * ==========================
 */
$khModel = new KhachHang($db);

$userId  = $_SESSION['user_id'] ?? null;
$isAdmin = false;

if ($userId !== null) {
    $isAdmin = $khModel->isAdmin($userId);
}

/**
 * ==========================
 *  ROUTE HỢP LỆ
 * ==========================
 */
$routes = [
    'dashboard'     => ['index', 'notifications'],

    'khachhang'     => ['index', 'create', 'edit', 'detail', 'delete'],
    'phanloai'      => ['index', 'create', 'edit', 'detail', 'delete'],
    'hanghoa'       => ['index', 'create', 'edit', 'detail', 'delete'],
    'dongiaban'     => ['index', 'create', 'edit', 'detail', 'delete'],
    'thuoctinh'     => ['index', 'create', 'edit', 'detail', 'delete'],
    'kho'           => ['index'],

    'chungtumua'    => ['index', 'create', 'edit', 'detail', 'delete'],
    'chungtuban'    => ['index', 'create', 'edit', 'detail', 'delete'],
    'chungtuban_ct' => ['index', 'create', 'edit', 'detail', 'delete'],

    'home'          => ['index'],

    'user' => [
        'login',
        'register',
        'profile',
        'orders',
        'orderDetail',
        'logout',
        'editProfile',
        'notifications',
        'mark_read'
    ],

    'product' => ['list', 'detail'],
    'cart'    => ['index', 'checkout', 'add', 'remove', 'update']
];

/**
 * ==========================
 *  CONTROLLER CHỈ ADMIN
 * ==========================
 */
$adminControllers = [
    'dashboard',
    'khachhang',
    'phanloai',
    'hanghoa',
    'dongiaban',
    'thuoctinh',
    'chungtumua',
    'chungtuban',
    'chungtuban_ct',
    'kho'
];

/**
 * ==========================
 *  KIỂM TRA ROUTE HỢP LỆ
 * ==========================
 */
if (!isset($routes[$controllerName])) {
    http_response_code(404);
    // exit('404 Controller Not Found');
    require_once 'views/error/404.php';
    exit;
}

if (!in_array($action, $routes[$controllerName], true)) {
    http_response_code(404);
    require_once 'views/error/404.php';
    exit;
}

/**
 * ==========================
 *  CHECK QUYỀN ADMIN
 * ==========================
 */
if (in_array($controllerName, $adminControllers, true)) {

    // Chưa đăng nhập
    if ($userId === null) {
        header('Location: index.php?controller=user&action=login');
        exit;
    }

    // Không phải admin
    if (!$isAdmin) {
        http_response_code(403);
        require_once 'views/error/403.php';
        exit;
    }
}

/**
 * ==========================
 *  LOAD CONTROLLER
 * ==========================
 */
$controllerFile = 'controllers/' . ucfirst($controllerName) . 'Controller.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    require_once 'views/error/404.php';
    exit;
}

require_once $controllerFile;

$controllerClass = ucfirst($controllerName) . 'Controller';
$controller      = new $controllerClass($db);

/**
 * ==========================
 *  GỌI ACTION
 * ==========================
 */
if (!method_exists($controller, $action)) {
    http_response_code(404);
    require_once 'views/error/404.php';
    exit;
}

$controller->$action();
