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

/**
 * функция генерирует список <li> из Json
 * и формирует ссылки вида URI index.php?id=1
 *
 * @return string
 */
function getArticleList(): string
{
    $articles = getArticles();
    $link = '';
    foreach ($articles as $article) {
        $link .= '<li class="nav-item"><a class="nav-link" href="index.php?id=' . $article['id']
            . '">' . $article['title'] . '</a></li>';
    }
    return $link;
}

function content(): string
{
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $article = getArticleById($id);
    } else {
        $article = '';
    }

    if (empty($article)) {
        $content = '<h2> Выберите статью для просмотра</h2>';
    } else {
        $content = '<div class="card">
  <img src="' . $article['image'] . '" class="card-img-top">
  <div class="card-body">
    <h5 class="card-title">' . $article['title'] . '</h5>
    <p class="card-text">
        ' . $article['content'] . '
    </p>
  </div>
</div>';
    }
    return $content;
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

function listOfWrappedArticles()
{
    $articles = getArticles();
    $list = '';
    foreach ($articles as $article) {

        $list .= listArticleWrapper($article);
    }
    return $list;
}

function listArticleWrapper(array $article, $single = false): string
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
                      <a  href="admin.php?action=article_delete&id=' . $article['id'] . '"class="btn btn-primary">Удалить</a>
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

function showArticleForm()
{
    echo makeArticleForm('article-edit',getArticleById(2));
}
