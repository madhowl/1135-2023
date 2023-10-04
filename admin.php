<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
include_once 'function.php';





function login()
{
    if (!isset($_POST['btnLogin'])) {
        //echo showForm();
        include 'template/backend/partials/login.php';
    } else {
        if (checkLogin($_POST['username'], $_POST['password'])) {
            $_SESSION['user'] = 'admin';
            //echo 'Вы залогинелись';
            goUrl('admin.php');
        }else{
            goUrl('admin.php');
        };

    }
}

function checkLogin(string $login, string $password): bool
{
    if ($login == 'admin' and $password == '123') {
        return true;
    } else {
        return false;
    }
}


function dashboard()
{
    if (isset($_SESSION['user']) and $_SESSION['user'] = 'admin') {
        include 'template/backend/partials/header.php';
        include 'template/backend/partials/sidebar.php';
        $action = '';
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
        switch ($action ) {
            case 'article-list':
                include 'template/backend/pages/article-list.php';
                break;
            case 'article-add':
                $id = $_GET['id'];
                include 'template/backend/pages/article-form.php';
                break;
            case 'article-edit':
                $id = $_GET['id'];
                $article = getArticleById($id);

                include 'template/backend/pages/article-form.php';
                break;
            case 'article-update':
                $id = $_GET['id'];
                include 'template/backend/pages/article-form.php';
                break;
            case 'logout':
                session_destroy();
                goUrl('admin.php');
                break;
            default:
                /// ??????????????????????????
                include 'template/backend/partials/dashboard.php';
        }
        //include 'template/backend/partials/dashboard.php';

    } else {
        login();
    }
}

function logout()
{
    $_SESSION['user']='3';
    //unset($_SESSION['user']);
}



dashboard();

include 'template/backend/partials/footer.php';
