<?php
namespace MOOP\Model;

use MOOP\Dbal\AbstractDb;

class Story {
	
	private $db;

	public function __construct(AbstractDb $db) {
        $this->db = $db;
    }
	
	public function getStories() {
		$sql = 'SELECT s.*, count(*) as cnt '
                . 'FROM story s '
                . 'LEFT JOIN comment c ON s.id = c.story_id '
                . 'GROUP BY s.id '
                . 'ORDER BY s.created_on DESC';
        return $this->db->fetchAll($sql);
	}
	
	public function getStory($id) {
		$sql = 'SELECT * FROM story WHERE id = ?';
        return $this->db->fetchOne($sql, [$id]);
	}
	
	public function getStoryComments($id) {
		$sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->db->fetchAll($sql, [$id]);
	}
	
	public function addStory($params) {
		$sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $this->db->execute($sql, [$headline, $url, $created_by]);
		return $this->db->lastInsertId();
	}
}