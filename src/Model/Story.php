<?php
namespace MOOP\Model;

use PDO;

class Story {
	
	private $db;

	public function __construct($dbconfig) {
		$dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	
	public function getStories() {
		$sql = 'SELECT s.*, count(*) as cnt FROM story s INNER JOIN comment c ON s.id = c.story_id GROUP BY s.id ORDER BY s.created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
	}
	
	public function getStory($id) {
		$sql = 'SELECT * FROM story WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getStoryComments($id) {
		$sql = 'SELECT * FROM comment WHERE story_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetchAll();
	}
	
	public function addStory($params) {
		$sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		return $this->db->lastInsertId();
	}
}