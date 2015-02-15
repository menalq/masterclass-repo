<?php
namespace MOOP\Model;

use MOOP\Dbal\AbstractDb;

class Comment {
	
	private $db;

	public function __construct(AbstractDb $db) {
		$this->db = $db;
    }
	
	public function addComment($username, $storyId, $comment) {
		$sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $this->db->execute($sql, [$username, $storyId, $comment]);
	}
}