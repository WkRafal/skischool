<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use app\forms\PersonSearchForm;

class PersonListCtrl {

    private $form; //dane formularza wyszukiwania
    private $records; //rekordy pobrane z bazy danych

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new PersonSearchForm();
    }

    public function validate() {
  
        $this->form->surname = ParamUtils::getFromRequest('sf_surname');

        return !App::getMessages()->isError();
    }
    
    public function action_home() {
        App::getSmarty()->display('Home.tpl');
    }

    public function action_personList() {

        $this->validate();

        $search_params = []; 
        if (isset($this->form->surname) && strlen($this->form->surname) > 0) {
            $search_params['last_name[~]'] = $this->form->surname . '%'; 
        }

        $num_params = sizeof($search_params);
        if ($num_params > 1) {
            $where = ["AND" => &$search_params];
        } else {
            $where = &$search_params;
        }
        //dodanie frazy sortującej po nazwisku
        $where ["ORDER"] = "last_name";
        //wykonanie zapytania

        try {
            $this->records = App::getDB()->select("users", [
                "user_id",
                "username",
                "role",
                "first_name",
                "last_name",
                "email",
                "phone",
                    ], $where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }

        $this->generateView();
    }
    
//    public function action_personList() {
//
//        $this->validate();
//        
//        
//        // Parametry stronicowania
//        $items_per_page = 10;
//        
////        if (ParamUtils::getFromCleanURL('page',false,"błąd1") != '') {
////            $page = ParamUtils::getFromCleanURL('page',true,"błąd2");
////        } else {
////            $page = 1;
////        }
//        
//        //$page = isset(ParamUtils::getFromGet('page')) ? ParamUtils::getFromGet('page') : 1;
//        $page = ParamUtils::getFromCleanURL('page') ?? 1;
//        $offset = ($page - 1) * $items_per_page;
//
//        $search_params = []; 
//        if (isset($this->form->surname) && strlen($this->form->surname) > 0) {
//            $search_params['last_name[~]'] = $this->form->surname . '%'; 
//        }
//        
//        $num_params = sizeof($search_params);
//        if ($num_params > 1) {
//            $where = ["AND" => &$search_params];
//        } else {
//            $where = &$search_params;
//        }
//        //dodanie frazy sortującej po nazwisku
//        $where ["ORDER"] = "last_name";
//        //wykonanie zapytania
//        $where ['LIMIT'] = [$offset, $items_per_page];
//        try {
//            $this->records = App::getDB()->select("users", [
//                "user_id",
//                "username",
//                "role",
//                "first_name",
//                "last_name",
//                "email",
//                "phone",
//                    ],$where );
//        } catch (\PDOException $e) {
//            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
//            if (App::getConf()->debug)
//                Utils::addErrorMessage($e->getMessage());
//        }
//        
//        // Pobieranie całkowitej liczby użytkowników
//        $total_users = App::getDB()->count('users');
//        // Obliczanie całkowitej liczby stron
//        $total_pages = ceil($total_users / $items_per_page); 
//        
//        App::getSmarty()->assign('total_pages', $total_pages);
//         App::getSmarty()->assign('page', $page);
//        
//         $this->generateView();
//    }
//    
    public function action_teacherList() {

        $this->validate();

        $search_params = []; //przygotowanie pustej struktury (aby była dostępna nawet gdy nie będzie zawierała wierszy)
        if (isset($this->form->surname) && strlen($this->form->surname) > 0) {
            $search_params['last_name[~]'] = $this->form->surname . '%'; // dodanie symbolu % zastępuje dowolny ciąg znaków na końcu
        }
        
        $search_params['role'] = 'instruktor';

        $num_params = sizeof($search_params);
        if ($num_params > 1) {
            $where = ["AND" => &$search_params];
        } else {
            $where = &$search_params;
        }
        //dodanie frazy sortującej po nazwisku
        $where ["ORDER"] = "last_name";
        //wykonanie zapytania

        try {
            $this->records = App::getDB()->select("users", [
                "user_id",
                "username",
                "role",
                "first_name",
                "last_name",
                "email",
                "phone",
                    ], $where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }
        
        $this->generateView();
    }
    
       public function action_studentList() {

        $this->validate();

        $search_params = []; //przygotowanie pustej struktury (aby była dostępna nawet gdy nie będzie zawierała wierszy)
        if (isset($this->form->surname) && strlen($this->form->surname) > 0) {
            $search_params['last_name[~]'] = $this->form->surname . '%'; // dodanie symbolu % zastępuje dowolny ciąg znaków na końcu
        }
        
        $search_params['role'] = 'uczeń';

        $num_params = sizeof($search_params);
        if ($num_params > 1) {
            $where = ["AND" => &$search_params];
        } else {
            $where = &$search_params;
        }
        //dodanie frazy sortującej po nazwisku
        $where ["ORDER"] = "last_name";
        //wykonanie zapytania

        try {
            $this->records = App::getDB()->select("users", [
                "user_id",
                "username",
                "role",
                "first_name",
                "last_name",
                "email",
                "phone",
                    ], $where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }
        
        $this->generateView();

    }
    
    public function generateView() {
        
         App::getSmarty()->assign('page_header','Strona Domowa');
         App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        
        App::getSmarty()->assign('searchForm', $this->form); // dane formularza (wyszukiwania w tym wypadku)
        App::getSmarty()->assign('users', $this->records);  // lista rekordów z bazy danych
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('PersonList.tpl');
    }

}
