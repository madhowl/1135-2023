<?php
// Включаем строгую типизацию
declare(strict_types=1);

/**
 * @param $some
 * отладочная функция
 */
function dd($some)
{
    echo '<pre>';
    print_r($some);
    echo '</pre>';
}

/**
 * @param $url
 * редирект на указаный URL
 */
function goUrl(string $url)
{
    echo '<script type="text/javascript">location="';
    echo $url;
    echo '";</script>';
}

/**
 * функция возвращает масив статей
 * @return array
 */
function getArticles(): array
{
    return json_decode(file_get_contents('db/articles.json'), true);
}

/**
 * функция возвращает статью  в виде масива по id
 * @param int $id
 * @return array
 */
function getArticleById(int $id): array
{
    $articleList = getArticles();
    $curentArticle = [];
    if (array_key_exists($id, $articleList)) {
        $curentArticle = $articleList[$id];
    }
    return $curentArticle;
}

function main(): string
{
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $article = getArticleById($id);
    } else {
        $article = '';
    }

    if (empty($article)) {
        $content = blogEntrysList();
    } else {
        $content = blogEntryWrapper($article, true);
    }
    return $content;
}

function blogEntrysList(): string
{
    $articles = getArticles();
    $blog_entrys_list = '';
    foreach ($articles as $article) {
        $blog_entrys_list .= blogEntryWrapper($article);
    }
    return $blog_entrys_list;
}

function blogEntryWrapper(array $article, $single = false): string
{
    $wraped_article = '<article class="entry">
    <div class="entry-img">
        <img src="' . $article['image'] . '" alt="" class="img-fluid">
    </div>
    <h2 class="entry-title">
        <a href="index.php?id=' . $article['id']
        . '">' . $article['title'] . '</a>
    </h2>
    <div class="entry-meta">
        <ul>
            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">Admin</a></li>
        </ul>
    </div>
    <div class="entry-content">';
    if ($single == true) {
        $wraped_article .= '<p>' . $article['content'] . '</p>';
    } else {

        $wraped_article .= '<div class="read-more">
            <a href="index.php?id=' . $article['id']
            . '">Read More</a>
        </div>';
    }
    $wraped_article .= '</div></article>';
    return $wraped_article;
}

// admin function

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

function listOfWrappedArticles():string
{
    $articles = getArticles();
    $list = '';
    foreach ($articles as $article) {

        $list .= listArticleWrapper($article);
    }
    return $list;
}

function listArticleWrapper(array $article): string
{
    $wrapped_list = '
        <tr>
            <th scope="row">' . $article['id'] . '</th>
            <td>' . $article['title'] . '</td>
            <td>
                <img src="' . $article['image'] . '" alt="" class="img-fluid">
            </td>
            <td>
                <div class="btn-group" role="group" >
                <a class="btn btn-success" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                    href="admin.php?action=article-edit&id='
                    . $article['id'] .
                    '"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-danger" 
                    data-bs-toggle="modal" data-bs-target="#modal-'. $article['id'] .'"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                    href="admin.php?action=article-delete&id='
                    . $article['id'] .
                    '"><i class="bi bi-trash3"></i></a>
                    <div class="modal fade" id="modal-'. $article['id'] .'" tabindex="-1" data-bs-backdrop="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Удаление</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Вы уверены что хотите удалить статью с ID '. $article['id'] .'
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                      <a  href="admin.php?action=article-delete&id=' . $article['id'] . '" class="btn btn-primary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div><!-- End Disabled Backdrop Modal-->
              </div>
            </td>
        </tr>';

    return $wrapped_list;
}

function makeArticleForm(string $action, array $article =[], string $method = 'get'):string
{
    $id = '';
    $title = '';
    $image = '';
    $content = '';
    if (!empty($article)){
        $id = $article['id'];
        $title = $article['title'];
        $image = $article['image'];
        $content = $article['content'];
    }
    $form = '<div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Статья</h5>
                            <form action="admin.php" method="' . $method .'">
                            <div class="row g-3">
                                <div class="col-12">
                                  <label for="inputText" class="col-sm-2 col-form-label"> Заголовок </label>
                                  <input class="form-control" type="text" name="title" value="' . $title .'">
                                </div>
                            <div class="col-12">
                              <label for="inputText" class="col-sm-2 col-form-label">Изоброжение</label>
                              <input class="form-control" type="text" name="image" value="' . $image .'">
                            </div>
                            <div class="col-12">
                            <input type="hidden" name="id" value="' . $id .'">
                            <input type="hidden" name="action" value="' . $action .'">
                            <label for="inputText" class="col-sm-2 col-form-label">Изоброжение</label>
                        <!-- TinyMCE Editor -->
                        <textarea class="tinymce-editor " name="content">
                            ' . $content .'
                        </textarea><!-- End TinyMCE Editor -->
                        </div>
                        </div>                        
                        <div class="text-center p-3">
                          <input type="submit" class="btn btn-primary" value="Сохранить">
                          <a href="admin.php?action=article-list"  class="btn btn-secondary">Закрыть</a>
                        </div>
                            </form>
                    </div>
                </div>';
    return $form;
}

function pageTitleWrapper(string $page_title):string
{
    return '<div class="pagetitle">
        <h1>Form Editors</h1>
        <nav>
            <ol class="breadcrumb">// TODO : breadcrumb in function
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item">Статьи</li>
                <li class="breadcrumb-item active">'.$page_title.'</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->';
}

function pageWrapper(string $title, string $content):string
{
    $page =  '<main id="main" class="main">';
    $page .= pageTitleWrapper($title);
    $page .= '<section class="section"><div class="row"><div class="col-lg-12">';
    $page .= $content ;
    $page .= '</div></div></section></main>';
    return $page;
}

function getLastArticleId():int
{
    $articles = getArticles();
    $lastId =(int) end($articles)['id'];
    return $lastId;
}

function articleCreate() : bool{
    $articleFields = checkFields( $_POST, articleFields ());
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

function articleDelete(int $id) : bool{
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

function articleFields():array
{
  return [
      'id' ,
      'title' ,
      'image' ,
      'content'
  ];
}

function checkFields(array $target, array $fields, bool $html=true):array
{
    $checkedFields = array();
    foreach ($fields as $name){
        if(isset($target[$name]) && $html == false) {
            $checkedFields[$name] = trim($target[$name]);
        }elseif (isset($target[$name]) && $html == true) {
            $checkedFields[$name] = htmlspecialchars(string: trim($target[$name]));
        }
    }
    return $checkedFields;

}

function articleUpdate()
{
    $articleItem = checkFields( $_POST, articleFields ());
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

function dashboard()
{
    if (isset($_SESSION['user']) and $_SESSION['user'] = 'admin') {
        include 'template/backend/partials/header.php';
        include 'template/backend/partials/sidebar.php';
        $action = '';
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        }
        switch ($action ) {
            case 'article-list':
                include 'template/backend/pages/article-list.php';
                break;
            case 'article-add':
                $content = makeArticleForm('article-create',[],'post');
                $title = 'Create';
                echo pageWrapper($title,$content);
                break;
            case 'article-create':
                if (articleCreate ()) {
                    goUrl('admin.php?action=article-list');
                }else{
                    $title = 'Error!!!';
                    $content = 'Что-то пошло не по плану';
                    echo pageWrapper($title,$content);
                };
                break;
            case 'article-edit':
                $id =(int) $_GET['id'];
                $article = getArticleById($id);
                $content = makeArticleForm('article-update',$article,'post');
                $title = 'Edit';
                echo pageWrapper($title,$content);
                break;
            case 'article-update':
                if (articleUpdate ()) {
                    goUrl('admin.php?action=article-list');
                }else{
                    $title = 'Error!!!';
                    $content = 'Что-то пошло не по плану';
                    echo pageWrapper($title,$content);
                };
                break;
            case 'article-delete':
                $id =(int) $_GET['id'];
                articleDelete ($id);
                goUrl('admin.php?action=article-list');
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
