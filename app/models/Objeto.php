<?php

	namespace App\Models;
	
	use \App\Connection as Connection;
	
	class Objeto {
			
		public static function selectAll($id = null) 
		{
			$where = '';
			
			if (!empty($id)){
				$where = "WHERE codigoobjeto = :id";				
			}
			
			$sql = sprintf("SELECT codigoobjeto, nomeobjeto, descricaoobjeto from adm.objeto %s ORDER BY nomeobjeto ASC", $where);
			
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				if (!empty($where)){
					$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				}
				$stmt->execute();
				
				$objeto = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $objeto;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function save($nome,$descricao)
		{
			if (empty($nome) || empty($descricao)){
				return false;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "insert into adm.objeto (codigoobjeto,nomeobjeto,descricaoobjeto) values (nextval('adm.objeto_codigoobjeto_seq'), :nome, :descricao)";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':nome',$nome);
				$stmt->bindParam(':descricao',$descricao);
				
				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}				
				
			} catch (\PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		public static function update($id, $nome, $descricao)
		{
			if (empty($nome) || empty($descricao)){
				return false;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "update adm.objeto set nomeobjeto = :nome, descricaoobjeto = :descricao where codigoobjeto = :id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':nome', $nome);
				$stmt->bindParam(':descricao', $descricao);
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				
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
		
		public static function remove ($id)
		{
			if (empty($id)){
				exit;
			}
			
			try {
				$pdo = Connection::get()->connect();
				$sql = "DELETE FROM adm.objeto where codigoobjeto = :id";
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				
				if ($stmt->execute(){
					return true;
				}
				else {
					return false;
				}
				
			} catch(\PDOException $e){
				echo $e->getMessage();
			}			
		}		
	}
	