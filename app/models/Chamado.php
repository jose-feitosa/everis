<?php

	namespace App\models;
	
	use \App\Connection as Connection;
	
	class Chamado {
		
		public static function selectRolesClientes($cliente)
		{
			$sql = "SELECT c.chamadoid, c.descricao, c.comentariocliente, c.status, c.clienteid, 
					c.funcionarioid, c.comentariofuncionario, c.solucaofuncionario,
					case when c.status = 'S' then 'Concluído' else 'Aberto' end as situacao_chamado,
					u.username as atendente
					from adm.chamado c
					left join adm.user u on
					c.funcionarioid = u.userid
					WHERE c.clienteid = :cliente
					AND c.lido <> 1";
			
			try {
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':cliente', $cliente, \PDO::PARAM_INT);
				$stmt->execute();
				
				$chamados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $chamados;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function chamadoFull($idchamado)
		{
				$sql = "SELECT distinct c.*,a.username as solicitante, b.username as atendente
						from adm.chamado c
						left join adm.user a on 
						c.clienteid = a.userid
						left join adm.user b on
						c.funcionarioid = b.userid
						WHERE c.chamadoid = :chamado";			
			try {
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':chamado', $idchamado, \PDO::PARAM_INT);
				$stmt->execute();
				
				$chamados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $chamados;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function selectRolesFuncionario($funcionario)
		{
			$sql = "SELECT c.*,u.username as solicitante, case when c.status = 'S' then 'Concluído' else 'Aberto' end as situacao_chamado
					from adm.chamado c
					left join adm.user u on
					c.clienteid = u.userid
					WHERE c.funcionarioid is null
					AND c.status <> 'S'
										
					UNION

					SELECT c.*,u.username as solicitante, case when c.status = 'S' then 'Concluído' else 'Aberto' end as situacao_chamado
					from adm.chamado c
					left join adm.user u on
					c.clienteid = u.userid
					WHERE c.funcionarioid = :funcionario
					AND c.status <> 'S'";
					
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':funcionario', $funcionario, \PDO::PARAM_INT);
				$stmt->execute();
				
				$chamados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $chamados;				
				
			} catch(\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function save($descricao,$comentario,$cliente)
		{
			if (empty($descricao) || empty($comentario) || empty($cliente)){
				return false;
			}
			
			try {
				$sql = "INSERT INTO adm.chamado (chamadoid, descricao, comentariocliente, clienteid) 
						values (nextval('adm.chamado_chamadoid_seq'), :descricao, :comment, :cliente)";
						
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':descricao',$descricao);
				$stmt->bindParam(':comment',$comentario);
				$stmt->bindParam(':cliente', $cliente, \PDO::PARAM_INT);
				
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
		
		public static function iniciaatendimento($comentario,$funcionario, $chamado) 
		{
			if (empty($comentario) || empty($funcionario) || empty($chamado)){
				return false;
			}
			
			try {
				$sql = "UPDATE adm.chamado SET status = 'A', comentariofuncionario = :comment, funcionarioid = :funcionario
						WHERE chamadoid = :id";
				
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':comment',$comentario);
				$stmt->bindParam(':funcionario', $funcionario, \PDO::PARAM_INT);
				$stmt->bindParam(':id', $chamado, \PDO::PARAM_INT);
				
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
		
		public static function fechaatendimento($solucao,$chamado)
		{
			if (empty($solucao) || empty($chamado)){
				return false;
			}
			
			try {
				$sql = "UPDATE adm.chamado set solucaofuncionario = :solucao, status = 'S' 
						WHERE chamadoid = :id";
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':solucao',$solucao);
				$stmt->bindParam(':id',$chamado, \PDO::PARAM_INT);
				
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
		
		public static function marcaComoLido($chamado)
		{
			try {
				$sql = "UPDATE adm.chamado set lido = 1
						WHERE chamadoid = :id";
						
				$pdo = Connection::get()->Connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':id',$chamado,\PDO::PARAM_INT);
				
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	