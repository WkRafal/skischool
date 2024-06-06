<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use app\forms\PersonSearchForm;

class StudentHomeCtrl {

    private $form; //dane formularza wyszukiwania
    private $records; //rekordy pobrane z bazy danych

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new PersonSearchForm();
    }

    public function validate() {
        // 1. sprawdzenie, czy parametry zostały przekazane
        // - nie trzeba sprawdzać
        $this->form->surname = ParamUtils::getFromRequest('sf_surname');

        // 2. sprawdzenie poprawności przekazanych parametrów
        // - nie trzeba sprawdzać

        return !App::getMessages()->isError();
    }
    
    public function action_studentHome() {
        $this->generateView();
    }


    public function generateView() {
        
        App::getSmarty()->assign('page_description','Dodano routing');
        App::getSmarty()->assign('page_header','Logowanie');
        
        
		
        App::getSmarty()->assign('page_title','Strona logowania');
        App::getSmarty()->assign('form', $this->form); // dane formularza do widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('StudentHome.tpl');
    }

}
