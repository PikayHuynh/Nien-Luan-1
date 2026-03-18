<?php
require_once ROOT . '/models/Kho.php';

class KhoController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new Kho($db);
    }

    public function index()
    {
        require_once ROOT . '/utils/pagination.php';

        $page = paginate($this->model, [
            'limit' => 10,
            'pageParam' => 'page',
            'maxPages' => 5,
            'getMethod' => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        $data = $page['items'];
        $totalPages = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $startPage = $page['startPage'];
        $endPage = $page['endPage'];

        include ROOT . '/views/admin/kho/list.php';
    }
}
