<?php
namespace MOOP\Model;

use PDO;

class User {
	
	private $db;

	public function __construct(PDO $pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db = $pdo;
    }
	
	public function getUserByUsername($username) {
		$sql = 'SELECT * FROM user WHERE username = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($username));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getUserByUsernameAndPassword($username, $password) {
		$sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($username, $password));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function addUser($params) {
		$sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
	}
	
	public function changePassword($params) {
		$sql = 'UPDATE user SET password = ? WHERE username = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
	}
}