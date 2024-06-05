<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\RoleUtils;
use core\ParamUtils;
use app\forms\LoginForm;
use app\PersonEditForm;
use app\transfer\User;

class RegisterCtrl {

    private $form;
    private $reppass;

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new \app\forms\PersonEditForm();
    }

public function validateSave() {
        //0. Pobranie parametrów z walidacją
        $this->form->userName = ParamUtils::getFromRequest('login');
        $this->form->password = ParamUtils::getFromRequest('pass');
        $this->reppass = ParamUtils::getFromRequest('replaypass');

        //nie ma sensu walidować dalej, gdy brak parametrów
        if (!isset($this->form->userName))
            return false;

        // sprawdzenie, czy potrzebne wartości zostały przekazane
        if (empty($this->form->userName)) {
            Utils::addErrorMessage('Nie podano loginu');
        }
        if (empty($this->form->password)) {
            Utils::addErrorMessage('Nie podano hasła');
        }
        if (empty($this->reppass)) {
            Utils::addErrorMessage('Nie potwierdzono hasła');
        }


        if (App::getMessages()->isError())
            return false;



        // 2. sprawdzenie poprawności przekazanych parametrów

        if ($this->form->password != $this->reppass) {
            Utils::addErrorMessage('hasła się różńią');
       }

        return !App::getMessages()->isError();
    }
    
    public function action_newLogin() {

       
         $this->form->role = 'uczeń';
         $this->generateView();
        
    }

    public function action_register() {

        if ($this->validate()) {
            RoleUtils::addRole('uczeń');
            Utils::addErrorMessage('Poprawnie wprowadzono login i hasło');
            App::getRouter()->redirectTo("personNew");
        } else {
            //niezalogowany => pozostań na stronie logowania
            $this->generateView();
        }
         
 
    }

    

    public function generateView() {
        
        App::getSmarty()->assign('page_description','Dodano routing');
        App::getSmarty()->assign('page_header','Rejstracja');
        
        
		
        App::getSmarty()->assign('page_title','Rejstracja');
        App::getSmarty()->assign('form', $this->form); // dane formularza do widoku
        App::getSmarty()->display('RegisterView.tpl');
    }

}
