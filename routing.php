<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('login'); #default action
App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('loginShow',            'LoginCtrl');
Utils::addRoute('login',                'LoginCtrl');
Utils::addRoute('logout',               'LoginCtrl');
Utils::addRoute('personList',           'PersonListCtrl',       ['admin']);
Utils::addRoute('personNew',            'PersonEditCtrl',       ['uczeń','admin']);
Utils::addRoute('personEdit',           'PersonEditCtrl',       ['uczeń','admin']);
Utils::addRoute('personSave',           'PersonEditCtrl',       ['uczeń','admin']);
Utils::addRoute('personDelete',         'PersonEditCtrl',       ['admin']);
Utils::addRoute('newLogin',             'RegisterCtrl');
Utils::addRoute('register',             'RegisterCtrl');
Utils::addRoute('registerPerson',       'PersonEditCtrl');
Utils::addRoute('home',                 'HomeCtrl',             ['uczeń','admin','instruktor']);
Utils::addRoute('teacherList',          'PersonListCtrl',       ['admin']);
Utils::addRoute('teacherEdit',          'PersonEditCtrl',       ['admin']);
Utils::addRoute('addCourse',            'CourseEditCtrl',       ['instruktor']);
Utils::addRoute('courseSave',           'CourseEditCtrl',       ['instruktor','admin']);
Utils::addRoute('courseList',           'CourseListCtrl',       ['uczeń','instruktor','admin']);
Utils::addRoute('courseTeacherList',    'CourseListCtrl',       ['uczeń','instruktor']);
Utils::addRoute('courseDelete',         'CourseEditCtrl',       ['instruktor','admin']);
Utils::addRoute('courseEdit',           'CourseEditCtrl',       ['instruktor','admin']);
Utils::addRoute('enrollmentAdd',        'EnrollmentEditCtrl',   ['uczeń']);
Utils::addRoute('studentList',          'PersonListCtrl',       ['admin']);
Utils::addRoute('enrollmentStudentList','EnrollmentListCtrl',   ['uczeń']);
Utils::addRoute('enrollmentTeacherList','EnrollmentListCtrl',   ['uczeń','instruktor']);
Utils::addRoute('enrollmentDelete',     'EnrollmentEditCtrl',   ['uczeń','instruktor']);
Utils::addRoute('enrollmentOK',         'EnrollmentEditCtrl',   ['instruktor']);
Utils::addRoute('priceSet',             'EnrollmentEditCtrl',   ['instruktor']);
