<?php
namespace MOOP\Model;

use MOOP\Dbal\AbstractDb;

class User {
	
	private $db;

	public function __construct(AbstractDb $db) {
		$this->db = $db;
    }
	
	public function getUserByUsername($username) {
		$sql = 'SELECT * FROM user WHERE username = ?';
		return $this->db->fetchOne($sql, [$username]);
	}
	
	public function getUserByUsernameAndPassword($username, $password) {
		$sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        return $this->db->fetchOne($sql, [$username, $password]);
		/*$stmt = $this->db->prepare($sql);
		$stmt->execute(array($username, $password));
        if ($stmt->rowCount() > 0) {
    		return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }*/
	}
	
	public function addUser($params) {
		$sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
		$this->db->execute($sql, $params);
	}
	
	public function changePassword($params) {
		$sql = 'UPDATE user SET password = ? WHERE username = ?';
		$this->db->execute($sql, $params);
	}
}