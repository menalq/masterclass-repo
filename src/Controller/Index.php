<?php
namespace MOOP\Controller;

use MOOP\Model\Story as StoryModel;
 
class Index {
    
    private $model;
    
	public function __construct(StoryModel $model) {
		$this->model = $model;
    }
    
    public function index() {
        
        $stories = $this->model->getStories();
        
        $content = '<ol>';
        
        foreach($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $story['cnt'] . ' Comments</a> | 
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

