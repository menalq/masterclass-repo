<?php
namespace MOOP\Controller;

use MOOP\Model\Comment as CommentModel;

class Comment {
	
	private $model;
    
    public function __construct(CommentModel $model) {
		$this->model = $model;
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        $this->model->addComment(array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}