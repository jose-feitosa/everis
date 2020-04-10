<?php

	namespace App\models;
	
	use \App\Connection as Connection;
	
	class Roles {

		public static function selectAll($id = null) { 
		
			$where = ''; 
			if (!empty($id)) 
			{ 
				$where = 'WHERE id = :id'; 
			} 
			$sql = sprintf("SELECT id, name from adm.roles %s ORDER BY name ASC", $where);

			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				if (!empty($where)){
					$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				}
				$stmt->execute();
				
				$roles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $roles;
				
			} catch (\PDOException $e) {
				echo $e->getMessage();
			}			
		}

		public static function getRoles()
		{
			$sql = "select * from adm.roles
					order by name";
			
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->execute();				
				$roles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $roles;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}		
		
	
		public static function save($name)
		{
			if (empty($name)){
				return false;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "insert into adm.roles (id,name) values (nextval('adm.roles_id_seq'), :name)";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':name', $name);
				
				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}
				
			} catch(\PDOException $e){
				echo $e->getMessage();				
			}			
		}
		
		public static function update($id,$name){
		
			if (empty($name)){
				return false;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "UPDATE adm.roles set name = :name where id = :id";
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':name',$name);
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				
				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}		
		}	
		
		public static function remove($id)
		{
			if (empty($id)){
				exit;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "DELETE FROM adm.roles where id = :id";
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				
				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}
		}		
	}	
	