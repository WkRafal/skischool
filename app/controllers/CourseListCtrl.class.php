<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use app\forms\CourseEditForm;
use app\transfer\User;

class CourseListCtrl {

    private $form; 
    private $records; 
    private $where;

    public function __construct() {
        $this->form = new CourseEditForm();
    }

    public function validate() {
    
        $this->form->surname = ParamUtils::getFromRequest('sf_surname');

        return !App::getMessages()->isError();
    }

   
    public function action_courseList() {

        $this->validate();
        
        $this->where = '';
        $search_params = [];
        $search_params['username'] = ParamUtils::getFromCleanURL(1,false);
        if ($search_params['username'] != ''){
            $this->where = &$search_params;
        }
        
        try {
            $this->records = App::getDB()->select('courses', [
            '[>]users' => ['user_id' => 'user_id']
            ], [
            'courses.course_id',
            'courses.name',
            'courses.level',
            'courses.start_date',
            'courses.end_date',
            'users.first_name',
            'users.last_name',
            'users.phone'
            ], $this->where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }
        $this->generateView();
    }
    
    public function action_courseTeacherList() {

        $this->validate();
        
        $user = unserialize($_SESSION['user']);
        
        $search_params = [];
        $search_params['users.username'] = $user->login;
        
        $where = &$search_params;
        
        
        try {
            $this->records = App::getDB()->select('courses', [
            '[>]users' => ['user_id' => 'user_id']
            ], [
            'courses.course_id',
            'courses.name',
            'courses.level',
            'courses.start_date',
            'courses.end_date',
            'users.username',
            'users.first_name',
            'users.last_name',
            'users.phone'
            ],$where);
        } catch (\PDOException $e) {
            Utils::addErrorMessage('Wystąpił błąd podczas pobierania rekordów');
            if (App::getConf()->debug)
                Utils::addErrorMessage($e->getMessage());
        }

        $this->generateView();
    }
    
    public function generateView() {
        App::getSmarty()->assign('page_header','Dostępne kursy');
        App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        
        App::getSmarty()->assign('searchForm', $this->form); // dane formularza (wyszukiwania w tym wypadku)
        App::getSmarty()->assign('courses', $this->records);  // lista rekordów z bazy danych
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('CourseList.tpl');
    }

}
