<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use app\forms\CourseEditForm;
use app\transfer\User;

class EnrollmentListCtrl {

    private $form; //dane formularza wyszukiwania
    private $records; //rekordy pobrane z bazy danych
    //private $where;
    private $user;

    public function __construct() {
        $this->form = new CourseEditForm();
        $this->user = new User();
    }

    public function validate() {
    
        $this->form->surname = ParamUtils::getFromRequest('sf_surname');

        return !App::getMessages()->isError();
    }

   
    public function action_enrollmentStudentList() {

        $this->validate();
        
        
        $this->user = unserialize($_SESSION['user']);
        
        $search_params = []; 
        
       $search_params['enrollments.user_id'] = App::getDB()->get('users', 'user_id',[
            'username' => $this->user->login ]);
        
        //$search_params['username'] = $this->user->login;
        $where = &$search_params;
        
        
        try {
            $this->records = App::getDB()->select('enrollments', [
            '[>]courses' => ['course_id' => 'course_id'],
            '[>]users' => ['courses.user_id' => 'user_id']
            ], [
            'enrollments.enrollment_id',
                'enrollments.user_id',
            'enrollments.price',
            'enrollments.status',
            'courses.name',
            'courses.level',
            'courses.start_date',
            'courses.end_date',
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
    
    public function action_enrollmentTeacherList() {

        $this->validate();
        
        
        $this->user = unserialize($_SESSION['user']);
        
        $search_params = []; 
        
       $search_params['courses.user_id'] = App::getDB()->get('users', 'user_id',[
            'username' => $this->user->login ]);
        
        //$search_params['username'] = $this->user->login;
        $where = &$search_params;
        
        
        try {
            $this->records = App::getDB()->select('enrollments', [
            '[>]courses' => ['course_id' => 'course_id'],
            '[>]users' => ['enrollments.user_id' => 'user_id']
            ], [
            'enrollments.enrollment_id',
            'enrollments.user_id',
            'enrollments.price',
            'enrollments.status',
            'courses.user_id',
            'courses.name',
            'courses.level',
            'courses.start_date',
            'courses.end_date',
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
        App::getSmarty()->assign('page_header','Moje kursy');
        App::getSmarty()->assign('page_title','Szkoła Sportów zimowych');
        
        App::getSmarty()->assign('searchForm', $this->form); // dane formularza (wyszukiwania w tym wypadku)
        App::getSmarty()->assign('enrollments', $this->records);  // lista rekordów z bazy danych
        App::getSmarty()->assign('user',unserialize($_SESSION['user']));
        App::getSmarty()->display('EnrollmentList.tpl');
    }

}
