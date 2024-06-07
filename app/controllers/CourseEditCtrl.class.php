<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use core\Validator;
use app\forms\CourseEditForm;
use app\forms\PersonEditForm;

class CourseEditCtrl {

    private $form; //dane formularz
    private $record;

    public function __construct() {
        //stworzenie potrzebnych obiektów
        $this->form = new CourseEditForm();
        $this->formP = new PersonEditForm();
    }

    // Walidacja danych przed zapisem (nowe dane lub edycja).
    public function validateSave() {
        //0. Pobranie parametrów z walidacją
        $this->form->id = ParamUtils::getFromRequest('id', true, 'Błędne wywołanie aplikacji');
        $this->form->name = ParamUtils::getFromRequest('nazwa', true, 'Błędne wywołanie aplikacji');
        $this->form->level = ParamUtils::getFromRequest('level', true, 'Błędne wywołanie aplikacji');
        $this->form->startDate = ParamUtils::getFromRequest('startDate', true, 'Błędne wywołanie aplikacji');
        $this->form->endDate = ParamUtils::getFromRequest('endDate', true, 'Błędne wywołanie aplikacji');
        $this->form->teacher = ParamUtils::getFromRequest('teacher', true, 'Błędne wywołanie aplikacji');

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

    public function validateEdit() {

        $this->form->id = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        return !App::getMessages()->isError();
    }   
    
    public function action_addCourse() {
        $username = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        $this->form->teacher = App::getDB()->get("users", "user_id", [
                    "username" => $username
                ]);
        $this->generateView();
    }

    public function action_courseSave() {

        if ($this->validateSave() ) {

            try {

                if ($this->form->id == '') {

                        App::getDB()->insert("courses", [
                            "name" => $this->form->name,
                            "level" => $this->form->level,
                            "start_date" => $this->form->startDate,
                            "end_date" => $this->form->endDate,
                            "user_id" => $this->form->teacher
                            ]);

                } else {
         
                    App::getDB()->update("courses", [
                            "name" => $this->form->name,
                            "level" => $this->form->level,
                            "start_date" => $this->form->startDate,
                            "end_date" => $this->form->endDate,
                            "user_id" => $this->form->teacher
                            ], [
                        "course_id" => $this->form->id
                    ]);
                }
                Utils::addInfoMessage('Pomyślnie zapisano rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }

            App::getRouter()->forwardTo('home');
        } else {
 
            $this->generateView();
        }
    }
    
        public function action_courseDelete() {
        
        if ($this->validateEdit()) {

            try {

                App::getDB()->delete("courses", [
                    "course_id" => $this->form->id
                ]);
                Utils::addInfoMessage('Pomyślnie usunięto rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas usuwania rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }


        App::getRouter()->forwardTo('courseList');
    }
    
    public function action_courseEdit() {

        if ($this->validateEdit()) {
            try {
      
                $record = App::getDB()->get("courses", "*", [
                    "course_id" => $this->form->id
                ]);
    
                $this->form->id = $record['course_id'];
                $this->form->name = $record['name'];
                $this->form->level = $record['level'];
                $this->form->startDate = $record['start_date'];
                $this->form->endDate = $record['end_date'];
                $this->form->teacher = $record['user_id'];
          
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }

        $this->generateView();
    }

public function generateView() {
        App::getSmarty()->assign('form', $this->form); // dane formularza dla widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));

        App::getSmarty()->display('CourseEdit.tpl');
    }

}
