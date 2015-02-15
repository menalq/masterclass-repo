<?php
namespace MOOP\Controller;

use MOOP\Model\User as UserModel;

class User {
    
    private $model;
    
    public function __construct(UserModel $model) {
		$this->model = $model;
    }
    
    public function create() {
        $error = null;
        
        // Do the create
        if(isset($_POST['create'])) {
            if(empty($_POST['username']) || empty($_POST['email']) ||
               empty($_POST['password']) || empty($_POST['password_check'])) {
                $error = 'You did not fill in all required fields.';
            }
            
            if(is_null($error)) {
                if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }
            
            if(is_null($error)) {
                if($_POST['password'] != $_POST['password_check']) {
                    $error = "Your passwords didn't match.";
                }
            }
            
            if(is_null($error)) {
				$user = $this->model->getUserByUsername($_POST['username']);
                if($user) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }
            
            if(is_null($error)) {
				$this->model->addUser(array(
					$_POST['username'],
					$_POST['email'],
					md5($_POST['username'] . $_POST['password']),
				));
                header("Location: /user/login");
                exit;
            }
        }
        // Show the create form
        
        $content = '
            <form method="post" action="/user/create/save">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';
        
        require_once '../layout.phtml';
        
    }
    
    public function account() {
        $error = null;
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        if(isset($_POST['updatepw'])) {
            if(empty($_POST['password']) || empty($_POST['password_check']) ||
               $_POST['password'] != $_POST['password_check']) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            } else {
				$this->model->changePassword(array(
                   md5($_SESSION['username'] . $_POST['password']), // THIS IS NOT SECURE. 
                   $_SESSION['username'],
                ));
                $error = 'Your password was changed.';
            }
        }
        
		$details = $this->model->getUserByUsername($_SESSION['username']);
        
        $content = '<p style="color:red">
        ' . $error . '</p>
        
        <label>Username:</label> ' . $details['username'] . '<br />
        <label>Email:</label>' . $details['email'] . ' <br />
        
         <form method="post" action="/user/account/save">
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';
        
        require_once '../layout.phtml';
    }
    
    public function login() {
        $error = null;
        // Do the login
        if(isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
			$data = $this->model->getUserByUsernameAndPassword($username, $password);
            if(!empty($data)) {
               session_regenerate_id();
               $_SESSION['username'] = $data['username'];
               $_SESSION['AUTHENTICATED'] = true;
               header("Location: /");
               exit;
            } else {
                $error = 'Your username/password did not match.';
            }
        }
        
        $content = '
            <form method="post" action="/user/login/check">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';
        
        require_once('../layout.phtml');
        
    }
    
    public function logout() {
        // Log out, redirect
        session_destroy();
        header("Location: /");
    }
}