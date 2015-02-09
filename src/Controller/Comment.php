<?php
namespace MOOP\Controller;

use MOOP\Model\Comment as CommentModel;

class Comment {
	
	private $commentModel;
    
    public function __construct($config) {
        $this->commentModel = new CommentModel($config['database']);
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        $this->commentModel->addComment();
        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}