<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\RoleUtils;
use core\ParamUtils;
use app\forms\LoginForm;
use app\transfer\User;

class LoginCtrl {

    private $form;
    private $records;

    public function __construct() {

        $this->form = new LoginForm();

    }

    public function validate() {
        $this->form->login = ParamUtils::getFromRequest('login');
        $this->form->pass = ParamUtils::getFromRequest('pass');

        //nie ma sensu walidować dalej, gdy brak parametrów
        if (!isset($this->form->login))
            return false;

        // sprawdzenie, czy potrzebne wartości zostały przekazane
        if (empty($this->form->login)) {
            Utils::addErrorMessage('Nie podano loginu');
        }
        if (empty($this->form->pass)) {
            Utils::addErrorMessage('Nie podano hasła');
        }

        //nie ma sensu walidować dalej, gdy brak wartości
        if (App::getMessages()->isError())
            return false;

      
        try {
            $this->records = App::getDB()->get("users", [
	"password",
	"role",], [
	"username" => $this->form->login]);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());        
        }        
        
        if ($this->records && $this->form->pass == $this->records['password']) {
        
        $user = new User();
        $user->login = $this->form->login; 
        $user->role = $this->records['role'];
            $_SESSION['user'] = serialize($user);
            RoleUtils::addRole($user->role);  
        } else if ($this->form->login == "admin" && $this->form->pass == "admin") {
            $user = new User(); 
            $user->login = $this->form->login;
            $user->role = 'admin';
            $_SESSION['user'] = serialize($user);
            RoleUtils::addRole('admin');
        } else {
            Utils::addErrorMessage('Niepoprawny login lub hasło');
        }

        return !App::getMessages()->isError();
    }

    public function action_loginShow() {
        $this->generateView();
    }

    public function action_login() {
        if ($this->validate()) {

            Utils::addErrorMessage('Poprawnie zalogowano do systemu');

               App::getRouter()->redirectTo("home");

        } else {

            $this->generateView();
        }
    }

    public function action_logout() {
        // 1. zakończenie sesji
        session_destroy();
        // 2. idź na stronę główną - system automatycznie przekieruje do strony logowania
        App::getRouter()->redirectTo('login');
    }

    public function generateView() {
        
        App::getSmarty()->assign('page_header','Strona logowania');
      
        App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        App::getSmarty()->assign('form', $this->form); // dane formularza do widoku
        App::getSmarty()->display('LoginView.tpl');
    }

}
