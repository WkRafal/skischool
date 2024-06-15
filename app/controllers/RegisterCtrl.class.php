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
    private $record;
   

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new \app\forms\PersonEditForm();
        
    }

public function validate() {
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

        
        try {
            $this->record = App::getDB()->get("users", "username", [
	"username" => $this->form->userName]);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());        
        }        
        
        if ($this->record) {
            Utils::addErrorMessage('login już istnieje');
            return false;
        }
        
        if ($this->form->password != $this->reppass) {
            Utils::addErrorMessage('hasła się różńią');
            return false;
       }
       
        return !App::getMessages()->isError();
    }
    
    public function action_newLogin() {
        $user = new User();
        $_SESSION['user'] = serialize($user);
        $this->generateView();
        
    }

    public function action_register() {

        if ($this->validate()) {
            
            $user = new User();
            $user->login = $this->form->userName;
            $user->role = 'uczeń';
            $_SESSION['user'] = serialize($user);
            RoleUtils::addRole($user->role);
       
            $this->form->role = $user->role;
            Utils::addErrorMessage('Jesteś zarejstrowany uzupełnij dane');
            $_SESSION['form'] = serialize($this->form);
            
            App::getSmarty()->assign('page_header','Zarejstruj się');
            App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
            App::getRouter()->redirectTo("registerPerson");

        } else {
            
            $this->generateView();
        }
         
     }
  

    public function generateView() {
        
        App::getSmarty()->assign('page_header','Zarejstruj się');
        App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->assign('form', $this->form); // dane formularza do widoku
        App::getSmarty()->display('RegisterView.tpl');
    }

}
