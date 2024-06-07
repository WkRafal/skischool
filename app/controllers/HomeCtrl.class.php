<?php

namespace app\controllers;

use core\App;
use app\forms\PersonEditForm;

class HomeCtrl {

    private $form; //dane formularza

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new PersonEditForm();
    }


    public function action_home() {
        $this->generateView();
    }


    public function generateView() {
        
         App::getSmarty()->assign('page_header','Strona Domowa');
         App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        
        App::getSmarty()->assign('form', $this->form); // dane formularza dla widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        //App::getSmarty()->assign('form',unserialize($_SESSION['form']));
        App::getSmarty()->display('Home.tpl');
    }

}
