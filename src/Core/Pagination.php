<?php


namespace App\Core;


trait Pagination
{
    protected $baseURL = '/page/';
    protected $totalRows = '';
    protected $perPage = 10;
    protected $numLinks = 2;
    protected $currentPage = 1;
    protected $firstLink = 'Первая';
    protected $nextLink = 'Следующая &raquo;';
    protected $prevLink = '&laquo; Предыдущая';
    protected $lastLink = 'Последняя';
    protected $fullTagOpen = '';
    protected $fullTagClose = '';
    protected $firstTagOpen = '<li>';
    protected $firstTagClose = '</li>';
    protected $lastTagOpen = '<li>';
    protected $lastTagClose = '</li></ul>';
    protected $curTagOpen = '<li class="active">';
    protected $curTagClose = '</li>';
    protected $nextTagOpen = '<li>';
    protected $nextTagClose = '</li>';
    protected $prevTagOpen = '<li>';
    protected $prevTagClose = '</li>';
    protected $numTagOpen = '<li>';
    protected $numTagClose = '</li>';
    protected $showCount = false;
    public $currentOffset = 0;
    protected $queryStringSegment = '';


    function initialize($params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    /**
     * Генерируем ссылки на страницы
     */
    function createLinks()
    {
        // Если общее количество записей 0, не продолжать
        if ($this->totalRows == 0 || $this->perPage == 0) {
            return '';
        }
        // Считаем общее количество страниц
        $numPages = ceil($this->totalRows / $this->perPage);
        // Если страница только одна, не продолжать
        if ($numPages == 1) {
            if ($this->showCount) {
                $info = 'Showing : ' . $this->totalRows;
                return $info;
            } else {
                return '';
            }
        }

        // Определяем строку запроса
        //$query_string_sep = (strpos($this->baseURL, '?') === FALSE) ? '?page=' : '&amp;page=';
        $query_string_sep = '';
        $this->baseURL = $this->baseURL . $query_string_sep;

        // Определяем текущую страницу
        //$this->currentPage = $_GET[$this->queryStringSegment];

        if (!is_numeric($this->currentPage) || $this->currentPage == 0) {
            $this->currentPage = 1;
        }

        // Строковая переменная вывода контента
        $output = '';

        // Отображаем сообщение о ссылках на другие страницы
        if ($this->showCount) {
            $this->currentOffset = ($this->currentPage > 1) ? ($this->currentPage - 1) * $this->perPage : $this->currentPage;
            $info = 'Показаны элементы с ' . $this->currentOffset . ' по ';

            if (($this->currentOffset + $this->perPage) < $this->totalRows)
                $info .= $this->currentPage * $this->perPage;
            else
                $info .= $this->totalRows;

            $info .= ' из ' . $this->totalRows . ' | ';

            $output .= $info;
        }

        $this->numLinks = (int)$this->numLinks;

        // Если номер страницы больше максимального значения, отображаем последнюю страницу
        if ($this->currentPage > $this->totalRows) {
            $this->currentPage = $numPages;
        }

        $uriPageNum = $this->currentPage;

        // Рассчитываем первый и последний элементы
        $start = (($this->currentPage - $this->numLinks) > 0) ? $this->currentPage - ($this->numLinks - 1) : 1;
        $end = (($this->currentPage + $this->numLinks) < $numPages) ? $this->currentPage + $this->numLinks : $numPages;

        // Выводим ссылку на первую страницу
        if ($this->currentPage > $this->numLinks) {
            $firstPageURL = str_replace($query_string_sep, '', $this->baseURL);
            $output .= $this->firstTagOpen . '<a href="' . $firstPageURL . '1">' . $this->firstLink . '</a>' . $this->firstTagClose;
        }
        // Выводим ссылку на предыдущую страницу
        if ($this->currentPage != 1) {
            $i = ($uriPageNum - 1);
            if ($i == 0) $i = '';
            $output .= $this->prevTagOpen . '<a href="' . $this->baseURL . $i . '">' . $this->prevLink . '</a>' . $this->prevTagClose;
        }
        // Выводим цифровые ссылки
        for ($loop = $start - 1; $loop <= $end; $loop++) {
            $i = $loop;
            if ($i >= 1) {
                if ($this->currentPage == $loop) {
                    $output .= $this->curTagOpen . '<a href="' . $this->baseURL . $i . '">' . $loop . '</a>' . $this->curTagClose;
                } else {
                    $output .= $this->numTagOpen . '<a href="' . $this->baseURL . $i . '">' . $loop . '</a>' . $this->numTagClose;
                }
            }
        }
        // Выводим ссылку на следующую страницу
        if ($this->currentPage < $numPages) {
            $i = ($this->currentPage + 1);
            $output .= $this->nextTagOpen . '<a href="' . $this->baseURL . $i . '">' . $this->nextLink . '</a>' . $this->nextTagClose;
        }
        // Выводим ссылку на последнюю страницу
        if (($this->currentPage + $this->numLinks) < $numPages) {
            $i = $numPages;
            $output .= $this->lastTagOpen . '<a href="' . $this->baseURL . $i . '">' . $this->lastLink . '</a>' . $this->lastTagClose;
        }
        // Удаляем двойные косые
        $output = preg_replace("#([^:])//+#", "\1/", $output);
        // Добавляем открывающий и закрывающий тэги блока
        $output = $this->fullTagOpen . $output . $this->fullTagClose;

        return $output;
    }

}