<?php

require_once __DIR__ . '/BaseController.php';
require_once  __DIR__ . '/../libs/dao/BoardDao.php';

class IndexController extends BaseController {

    // 読み込むテンプレートファイルを設定
    protected $template = 'index.tpl';

    // ログイン必須でなくす
    protected $isLogin = false;

    protected function main()
    {
        // 掲示板情報を取得しsmarty変数に値を受け渡す
        $boardDao = new BoardDao();
        $this->smarty->assign('boardList', $boardDao->findAll());
    }
}
