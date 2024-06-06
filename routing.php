<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('login'); #default action
App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('loginShow',     'LoginCtrl');
Utils::addRoute('login',         'LoginCtrl');
Utils::addRoute('logout',        'LoginCtrl');
Utils::addRoute('personList',    'PersonListCtrl');
Utils::addRoute('personNew',     'PersonEditCtrl',	['uczeń','admin']);
Utils::addRoute('personEdit',    'PersonEditCtrl',	['uczeń','admin']);
Utils::addRoute('personSave',    'PersonEditCtrl',	['uczeń','admin']);
Utils::addRoute('personDelete',  'PersonEditCtrl',	['admin']);
Utils::addRoute('newLogin',      'RegisterCtrl');
Utils::addRoute('register',      'RegisterCtrl');
Utils::addRoute('registerPerson','PersonEditCtrl');
Utils::addRoute('studentHome',   'StudentHomeCtrl');
