<?php

require_once __DIR__ . '/../library/smarty/Smarty.class.php';
require_once __DIR__ . '/../libs/dao/UserDao.php';
require_once __DIR__ . '/../libs/entity/UserEntity.php';

abstract class BaseController
{
    protected $smarty;

    protected $template = '';

    /** @var UserDao */
    protected $userDao;

    /** @var UserEntity */
    protected $user;

    /** @var Boolean ログイン必須か */
    protected $isLogin = true;

    public function __construct()
    {
        // smartyの読み込みと定義
        $this->smarty = new Smarty();
        $this->smarty->escape_html = true;
        $this->smarty->setTemplateDir(__DIR__ . '/../template');
        $this->smarty->setCompileDir(__DIR__ . '/../template_c');
        $this->userDao = new UserDao();
    }

    public function execute()
    {
        try {
            $this->beforeMain();
            // ログイン処理
            session_start();
            $email = empty($_SESSION['email']) ? '' : $_SESSION['email'];
            $this->user = $this->userDao->findByEmail($email);
            // ログイン必須でログインしていなかったらログインページに遷移する
            if ($this->isLogin && empty($this->user)) {
                header('Location: ./login.php');
                exit();
            }
            $this->smarty->assign('user', $this->user);
            $this->main();
            $this->smarty->display($this->template);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        $this->afterMain();
    }

    protected function beforeMain()
    {
    }

    protected function main()
    {
    }

    protected function afterMain()
    {
    }
}
