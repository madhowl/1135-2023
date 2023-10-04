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
                include 'template/backend/pages/article-form.php';
                break;
            case 'article-edit':
                $id =(int) $_GET['id'];
                $article = getArticleById($id);
                $content = makeArticleForm('article-edit',$article);
                $title = 'Edit';
                echo pageWrapper($title,$content);
                break;
            case 'article-update':
                $id = $_GET['id'];
                include 'template/backend/pages/article-form.php';
                break;
            case 'article-delete':
                $id = $_GET['id'];
                echo '';
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
dd(getLastArticleId());
include 'template/backend/partials/footer.php';

function addArticle(array $articleFields) : bool{
    $articles = getArticles();
    $lastId = end($articles)['id'];
    $id = $lastId + 1;
    $articles[$id] = [
        'id' => $id,
        'title' => $articleFields['title'],
        'image' => $articleFields['image'],
        'content' => $articleFields['content']
    ];
    saveArticles($articles);
    return true;
}

function removeArticle(int $id) : bool{
    $articles = getArticles();
    if(isset($articles[$id])){
        unset($articles[$id]);
        saveArticles($articles);
        return true;
    }
    return false;
}

function saveArticles(array $articles) : bool{
    file_put_contents('db/articles.json', json_encode($articles));
    return true;
}

function editArticle(int $id) : array{
    $articles = getArticles();
    $article =[];
    if(isset($articles[$id])){
        $article = $articles[$id];
    }
    return $article;
}

function updateArticle(array $fields):bool{
    $articleItem = checkFields( $_POST, $fields);
    $articles = getArticles();
    if(isset($articles[$articleItem['id']])) {
        $articles[$articleItem['id']] = [
            'id' => $articleItem['id'],
            'title' => $articleItem['title'],
            'image' => $articleItem['image'],
            'content' => $articleItem['content']
        ];
        saveArticles($articles);
        return true;
    }else{
        return false;
    }
}
function checkFields(array $target, array $fields, bool $html=true):array{
    foreach ($fields as $name){
        if(isset($target[$name]) && $html == false) {
            $checkedFields[$name] = trim($target[$name]);
        }elseif (isset($target[$name]) && $html == true) {
            $checkedFields[$name] = htmlspecialchars(string: trim($target[$name]));
        }
    }
    return $checkedFields;

}
