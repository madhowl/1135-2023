<?php


namespace App;


use Jenssegers\Blade\Blade;
use Opis\Database\Database as Database;

class Controller
{
    public Blade $view;
    public Database $db;

    /**
     * Controller constructor.
     */
    public function __construct( $db)
    {
        $this->db = $db;
        $this->view = new Blade( 'template/frontend' , 'cache' );
    }

    public function index()
    {


    }

    public function show($id)
    {
    }


}