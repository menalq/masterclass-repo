<?php
namespace MOOP\Model;

use PDO;

class Comment {
	
	private $db;

	public function __construct(PDO $pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db = $pdo;
    }
	
	public function addComment($params) {
		$sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
	}
}