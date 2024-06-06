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

        // 2. sprawdzenie poprawności przekazanych parametrów

//        $d = \DateTime::createFromFormat('Y-m-d', $this->form->birthdate);
//        if ($d === false) {
//            Utils::addErrorMessage('Zły format daty. Przykład: 2015-12-20');
//        }

        return !App::getMessages()->isError();
    }

    //validacja danych przed wyswietleniem do edycji
    public function validateEdit() {

        $this->form->id = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        return !App::getMessages()->isError();
    }   
    
    public function action_addCourse() {
        $this->form->teacher = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        $this->generateView();
    }

    public function action_courseSave() {

        // 1. Walidacja danych formularza (z pobraniem)
        if ($this->validateSave()) {
            // 2. Zapis danych w bazie
            try {

                if ($this->form->id == '') {

                        App::getDB()->insert("courses", [
                            "name" => $this->form->name,
                            "level" => $this->form->level,
                            "start_date" => $this->form->startDate,
                            "end_date" => $this->form->endDate,
                            "user_id" => $this->form->teacher
                            ]);
//                    } else { //za dużo rekordów
//                        // Gdy za dużo rekordów to pozostań na stronie
//                        Utils::addInfoMessage('Ograniczenie: Zbyt dużo rekordów. Aby dodać nowy usuń wybrany wpis.');
//                        $this->generateView(); //pozostań na stronie edycji
//                        exit(); //zakończ przetwarzanie, aby nie dodać wiadomości o pomyślnym zapisie danych
//                    }
                } else {
                    //2.2 Edycja rekordu o danym ID
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

            // 3b. Po zapisie przejdź na stronę listy osób (w ramach tego samego żądania http)
            App::getRouter()->forwardTo('courseList');
        } else {
            // 3c. Gdy błąd walidacji to pozostań na stronie
            $this->generateView();
        }
    }
    
        public function action_courseDelete() {
        
        if ($this->validateEdit()) {

            try {
                // 2. usunięcie rekordu
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

        // 3. Przekierowanie na stronę listy osób
        App::getRouter()->forwardTo('courseList');
    }
    
    public function action_courseEdit() {
        // 1. walidacja id osoby do edycji
        if ($this->validateEdit()) {
            try {
                // 2. odczyt z bazy danych osoby o podanym ID (tylko jednego rekordu)
                $record = App::getDB()->get("courses", "*", [
                    "course_id" => $this->form->id
                ]);
                // 2.1 jeśli osoba istnieje to wpisz dane do obiektu formularza
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

        // 3. Wygenerowanie widoku
        $this->generateView();
    }

public function generateView() {
        App::getSmarty()->assign('form', $this->form); // dane formularza dla widoku
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        //App::getSmarty()->assign('form',unserialize($_SESSION['form']));
        App::getSmarty()->display('CourseEdit.tpl');
    }

}
