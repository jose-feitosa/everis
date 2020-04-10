<?php

	namespace App\models;
	
	use \App\Connection as Connection;
	
	class Menu {
		public static function selectAll($id = null) {
			$where = '';
			if (!empty($id)) {
				$where = 'WHERE codigomenu = :id';
			}
			
			$sql = sprintf("SELECT codigomenu,codigomenupai,descricaomenu,codigoobjeto,ordem from adm.menu %s ORDER BY ordem asc", $where);
			
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				if (!empty($where)){
					$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
				}
				$stmt->execute();
				$menu = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $menu;			
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}
		}
		
		public static function getMainMenu($userid)
		{
			$sql = "select m.* from adm.menu m
					inner join adm.acessomenu a on
					m.codigomenu = a.codigomenu
					and a.userid = :userid
					where m.codigomenupai is null order by m.ordem";
			
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':userid', $userid, \PDO::PARAM_INT);
				
				$stmt->execute();				
				$mainmenu = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $mainmenu;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function getSubMenu($userid)
		{
			$sql = "select m.codigomenu,m.codigomenupai,u.descricaoobjeto as descricaomenu,m.codigoobjeto,m.ordem,
					u.nomeobjeto, b.isclient
					from adm.menu m
					left join adm.objeto u on
					m.codigoobjeto = u.codigoobjeto
					inner join adm.acessomenu a on
					m.codigomenu = a.codigomenu
					inner join adm.acesso b on
					m.codigoobjeto = b.codigoobjeto
					and a.userid = b.userid
					and a.rolesid = b.rolesid
					where m.codigomenupai is not null
					and a.userid = :userid
					order by m.codigomenupai, m.ordem";
			
			try {
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':userid',$userid,\PDO::PARAM_INT);
				
				$stmt->execute();				
				$submenu = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $submenu;
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
		
		public static function getCodigoMenu($descricao)
		{
			try {
				$sql = "select codigomenu,codigoobjeto from adm.menu
						where trim(lower(descricaomenu)) = trim(lower(:descricao))";
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':descricao',$descricao);
				
				$stmt->execute();
				
				$menu = $stmt->fetchAll(\PDO::FETCH_ASSOC);
	
				return $menu;				
				
			} catch(\PDOException $e) {
				echo $e->getMessage();
			}
		}		
		
		public static function save($menupai,$descricao,$objeto,$ordem)
		{
			if (empty($descricao)){
				return false;
			}
			
			try {
				$pdo = Connection::get()->connect();
				
				$sql = "insert into adm.menu(codigomenu,";
				
				if (!empty($menupai)){
					$sql = $sql."codigomenupai,";
				}
				
				if (!empty($objeto)){
					$sql = $sql."codigoobjeto,";
				}
				
				$sql = $sql."descricaomenu,ordem) ";
				$sql = $sql."values (nextval('adm.menu_codigomenu_seq'),";
				
				if (!empty($menupai)){
					$sql = $sql.":menupai,";					
				}
				
				if (!empty($objeto)){
					$sql = $sql.":objeto,";
				}
								
				$sql = $sql.":descricao,";
				
				if (empty($menupai)){
					$sql = $sql."(select (coalesce(max(ordem),0)+1) from adm.menu where codigomenupai is null))";
				}
				else {
					$sql = $sql."(select (coalesce(max(ordem),0)+1) from adm.menu where codigomenupai = :menupai))";
				}
				
				$stmt = $pdo->prepare($sql);
				
				if (!empty($menupai)){
					$stmt->bindParam(':menupai', $menupai, \PDO::PARAM_INT);
				}
				
				if (!empty($objeto)){
					$stmt->bindParam(':objeto', $objeto, \PDO::PARAM_INT);
				}
				
				$stmt->bindParam(':descricao', $descricao);
				
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
				
				$sql = "DELETE FROM adm.menu where codigomenu = :id";
				
				$stmt = $pdo->prepare($sql);
				
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
	}
	