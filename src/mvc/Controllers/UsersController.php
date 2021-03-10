<?php


namespace mvc\Controllers;


use exceptions\InvalidArgumentException;
use mvc\Models\Users\User;

/**
 * Class UsersController
 * @package mvc\Controllers
 */
class UsersController extends CoreController
{
    public function signUp()
    {
        if(!empty($_POST))
        {
            // TODO: User SignUp
        } else {
            return $this->view->template('auth/signUp', [], 200);
        }
        
    }

    public function login()
    {
        // TODO: User Login
    }
}