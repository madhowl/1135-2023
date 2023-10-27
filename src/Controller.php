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

    /**
     *
     */
    public function index()
    {
        //echo 'index method';
        $result = $this->db->from ( 'categories' )
            ->select ()
            ->fetchAssoc ()
            ->all ();


        var_dump ( $result );
        echo $this->view->render ( 'blog-single' , ['name' => 'John Doe'] );
    }

    public function show($id)
    {
        //echo 'index method';
        $result = $this->db->from ( 'products' )
            ->where ( 'id' )->is ( $id )
            ->select()
            ->fetchAssoc ()
            ->first ();


        var_dump ( $result );
        echo $this->view->render ( 'blog-single' , ['name' => 'John Doe'] );
    }


}