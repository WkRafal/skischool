<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use core\Validator;
use app\forms\PersonEditForm;

class PersonEditCtrl {

    private $form; //dane formularza

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new PersonEditForm();
    }

    // Walidacja danych przed zapisem (nowe dane lub edycja).
    public function validateSave() {
        //0. Pobranie parametrów z walidacją
        $this->form->id = ParamUtils::getFromRequest('id', true, 'Błędne wywołanie aplikacji');
        $this->form->firstName = ParamUtils::getFromRequest('firstName', true, 'Błędne wywołanie aplikacji');
        $this->form->lastName = ParamUtils::getFromRequest('lastName', true, 'Błędne wywołanie aplikacji');
        $this->form->userName = ParamUtils::getFromRequest('userName', true, 'Błędne wywołanie aplikacji');
        $this->form->role = ParamUtils::getFromRequest('role', true, 'Błędne wywołanie aplikacji');
        $this->form->password = ParamUtils::getFromRequest('password', true, 'Błędne wywołanie aplikacji');
        $this->form->email = ParamUtils::getFromRequest('email', true, 'Błędne wywołanie aplikacji');
        $this->form->phone = ParamUtils::getFromRequest('phone', true, 'Błędne wywołanie aplikacji');


        if (App::getMessages()->isError())
            return false;

        // 1. sprawdzenie czy wartości wymagane nie są puste
        if (empty(trim($this->form->firstName))) {
            Utils::addErrorMessage('Wprowadź imię');
        }
        if (empty(trim($this->form->lastName))) {
            Utils::addErrorMessage('Wprowadź nazwisko');
        }
                if (empty(trim($this->form->userName))) {
            Utils::addErrorMessage('Wprowadź login');
        }
                if (empty(trim($this->form->password))) {
            Utils::addErrorMessage('Wprowadź hasło');
        }
                if (empty(trim($this->form->role))) {
            Utils::addErrorMessage('Wprowadź role');
        }
        if (empty(trim($this->form->email))) {
            Utils::addErrorMessage('Wprowadź email');
        }
        if (empty(trim($this->form->phone))) {
            Utils::addErrorMessage('Wprowadź telefon');
        }

        if (App::getMessages()->isError())
            return false;

        return !App::getMessages()->isError();
    }

    //validacja danych przed wyswietleniem do edycji
    public function validateEdit() {

        $this->form->id = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        return !App::getMessages()->isError();
    }

    public function action_personNew() {
        $this->generateView();
    }
    
    public function action_registerPerson() {

        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->assign('form',unserialize($_SESSION['form']));
        App::getSmarty()->display('PersonEdit.tpl');
    }    

    //wysiweltenie rekordu do edycji wskazanego parametrem 'id'
    public function action_personEdit() {
        // 1. walidacja id osoby do edycji
        if ($this->validateEdit()) {
            try {
                // 2. odczyt z bazy danych osoby o podanym ID (tylko jednego rekordu)
                $record = App::getDB()->get("users", "*", [
                    "user_id" => $this->form->id
                ]);
                // 2.1 jeśli osoba istnieje to wpisz dane do obiektu formularza
                $this->form->id = $record['user_id'];
                $this->form->firstName = $record['first_name'];
                $this->form->lastName = $record['last_name'];
                $this->form->userName = $record['username'];
                $this->form->role = $record['role'];
                $this->form->password = $record['password'];
                $this->form->email = $record['email'];
                $this->form->phone = $record['phone'];

            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }

        // 3. Wygenerowanie widoku
        $this->generateView();
    }
    
    

    public function action_personDelete() {
        // 1. walidacja id osoby do usuniecia
        if ($this->validateEdit()) {

            try {
                // 2. usunięcie rekordu
                App::getDB()->delete("users", [
                    "user_id" => $this->form->id
                ]);
                Utils::addInfoMessage('Pomyślnie usunięto rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas usuwania rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }

        // 3. Przekierowanie na stronę listy osób
        App::getRouter()->forwardTo('personList');
    }

    public function action_personSave() {

        // 1. Walidacja danych formularza (z pobraniem)
        if ($this->validateSave()) {
            // 2. Zapis danych w bazie
            try {

                //2.1 Nowy rekord
                if ($this->form->id == '') {

                        App::getDB()->insert("users", [
                            "first_name" => $this->form->firstName,
                            "last_name" => $this->form->lastName,
                            "username" => $this->form->userName,
                            "role" => $this->form->role,
                            "password" => $this->form->password,
                            "email" => $this->form->email,
                            "phone" => $this->form->phone
                        ]);
                } else {
                    //2.2 Edycja rekordu o danym ID
                    App::getDB()->update("users", [
                            "first_name" => $this->form->firstName,
                            "last_name" => $this->form->lastName,
                            "username" => $this->form->userName,
                            "role" => $this->form->role,
                            "password" => $this->form->password,
                            "email" => $this->form->email,
                            "phone" => $this->form->phone
                            ], [
                        "user_id" => $this->form->id
                    ]);
                }
                Utils::addInfoMessage('Pomyślnie zapisano rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }

            // 3b. Po zapisie przejdź na stronę listy osób (w ramach tego samego żądania http)
            App::getRouter()->forwardTo('personList');
        } else {
            // 3c. Gdy błąd walidacji to pozostań na stronie
            $this->generateView();
        }
    }

    public function generateView() {
        App::getSmarty()->assign('form', $this->form); // dane formularza dla widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        //App::getSmarty()->assign('form',unserialize($_SESSION['form']));
        App::getSmarty()->display('PersonEdit.tpl');
    }

}
