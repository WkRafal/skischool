<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use core\Validator;
use app\forms\EnrollmentEditForm;
use app\transfer\User; 


class EnrollmentEditCtrl {

    private $form; //dane formularz
    private $record;
    private $user;

    public function __construct() {
        
        $this->form = new EnrollmentEditForm();
        $this->user = new User();
    }
 
    public function validateSave() {
        //0. Pobranie parametrów z walidacją
        $this->form->id = ParamUtils::getFromRequest('id', true, 'Błędne wywołanie aplikacji');
        $this->form->price = ParamUtils::getFromRequest('price', true, 'Błędne wywołanie aplikacji');
        $this->form->status = ParamUtils::getFromRequest('status', true, 'Błędne wywołanie aplikacji');
        $this->form->course = ParamUtils::getFromRequest('course', true, 'Błędne wywołanie aplikacji');
        $this->form->student = ParamUtils::getFromRequest('student', true, 'Błędne wywołanie aplikacji');
       
        if (App::getMessages()->isError())
            return false;

        // 1. sprawdzenie czy wartości wymagane nie są puste
        if (empty(trim($this->form->name))) {
            Utils::addErrorMessage('Wybierz rodzaj lekcji');
        }
        if (empty(trim($this->form->level))) {
            Utils::addErrorMessage('Wybierz swój poziom');
        }
        if (empty(trim($this->form->startDate))) {
            Utils::addErrorMessage('Wprowadź date rozpoczęcia');
        }
        if (empty(trim($this->form->endDate))) {
            Utils::addErrorMessage('Wprowadź datę zakończenia');
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
    
    public function action_enrollmentAdd() {
        //$user = new User('nowy','uczeń');
        $this->user = unserialize($_SESSION['user']);
        //$this->user = SessionUtils::loadObject('user', $keep = false);
        $this->form->student = App::getDB()->get("users", "user_id", [
                    "username" => $this->user->login
                ]);
        $this->form->price = 0;
        $this->form->status = 'niezatwierdzony';
        $this->form->course = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        
        try {

                if ($this->form->id == '') {

                        App::getDB()->insert("enrollments", [
                            "status" => $this->form->status,
                            "price" => $this->form->price,
                            "user_id" => $this->form->student,
                            "course_id" => $this->form->course,
                           
                            ]);

                } else {
                    //2.2 Edycja rekordu o danym ID
                    App::getDB()->update("enrollments", [
                            "status" => $this->form->status,
                            "price" => $this->form->price,
                            "user_id" => $this->form->student,
                            "course_id" => $this->form->course,
                            ], [
                        "enrollment_id" => $this->form->id
                    ]);
                }
                Utils::addInfoMessage('Pomyślnie zapisano rekord');
        } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
        }
        App::getRouter()->redirectTo("home");
    }


    
        public function action_enrollmentDelete() {
        
        if ($this->validateEdit()) {

            try {
                // 2. usunięcie rekordu
                App::getDB()->delete("enrollments", [
                    "enrollment_id" => $this->form->id
                ]);
                Utils::addInfoMessage('Pomyślnie usunięto rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas usuwania rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }

        // 3. Przekierowanie na stronę listy osób
        App::getRouter()->forwardTo('home');
    }

    
        public function action_enrollmentOK() {
           
            if ($this->validateEdit()) {
            try {
                $newStatus = 'OK';
                App::getDB()->update("enrollments",[
                    "status" => $newStatus,
                    ], ['enrollment_id' => $this->form->id
                ]);
      
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }

        App::getRouter()->forwardTo('enrollmentTeacherList');
    }
    
    public function action_priceSet() {
            $id = ParamUtils::getFromCleanURL(1, true, 'Błędne2 wywołanie aplikacji');
            $price = ParamUtils::getFromRequest('price', true, 'Błędne wywołanie aplikacji');
            
            try {
                              
                App::getDB()->update("enrollments",[
                   
                    "price" => $price
                ], ['enrollment_id' => $id]);
              
          
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
                     
            
            
            App::getRouter()->forwardTo('enrollmentTeacherList');
    }

public function generateView() {
        App::getSmarty()->assign('form', $this->form); // dane formularza dla widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        //App::getSmarty()->assign('form',unserialize($_SESSION['form']));
        App::getSmarty()->display('EnrollmentEdit.tpl');
    }

}
