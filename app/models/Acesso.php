<?php 

	namespace App\models;
	
	use \App\Connection as Connection;
	
	use \App\Models\Menu;
	
	class Acesso {
		
		public static function select($usuario, $role)
		{
			if (empty($usuario) || empty($role)){
				return false;
			}
			
			try {
				$sql = "SELECT distinct a.codigoobjeto, a.userid, a.rolesid, a.allowinsert, a.allowupdate, a.allowdelete, a.allowread,
						u.nomeobjeto, u.descricaoobjeto, r.name
						FROM adm.acesso a
						left join adm.objeto u on
						a.codigoobjeto = u.codigoobjeto
						left join adm.roles r on
						a.rolesid = r.id
						WHERE a.userid = :usuario
						AND a.rolesid = :roles";						
				
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, \PDO::PARAM_INT);
				$stmt->bindParam(':roles', $role, \PDO::PARAM_INT);
				
				$stmt->execute();
				
				$acesso = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $acesso;				
				
			} catch (\PDOException $e){
				echo $e->getMessage();
			}
		}
		
		public static function getUsersRoles(){
			
			try {
				$sql = "select distinct u.userid,u.username,a.rolesid,b.name rolesname
						from adm.user u
						left join adm.acesso a on
						u.userid = a.userid
						left join adm.roles b on
						a.rolesid = b.id
						order by u.username";
						
				$pdo = Connection::get()->connect();
				
				$stmt = $pdo->prepare($sql);
				
				$stmt->execute();
				
				$userroles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				
				return $userroles;
				
			} catch(\PDOException $e){
				echo $e->getMessage();
			}
		}
		
		public static function gravandoAcesso($id,$rolesid,$name)
		{
			/*
			$menu = Menu::getCodigoMenu('administrativo');
			$codigomenu = 0;
			foreach ($menu as $men):
				$codigomenu = $men['codigomenu'];
			endforeach;
			*/
			$sql = "";
			$sql2 = "";
			$transacao_ok = false;
			
			try {
				//Limpando as permissões anteriores caso existam
				$sql = "delete from adm.acessomenu 
						where userid = :userid";
						
				$sql2 = "delete from adm.acesso
						 where userid = :userid ";
						 
				$pdo = Connection::get()->Connect();
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
									
				if ($stmt->execute()){
					$transacao_ok = true;
				}
					
				$pdo = Connection::get()->Connect();
				$stmt = $pdo->prepare($sql2);
				$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					
				if ($stmt->execute()){
					$transacao_ok = true;
				}					
				
				//Verificando o tipo de perfil para adequar aos menus
				if ($name == 'ADMIN'){
					//ADMIN-> tem acesso aos menus "Administrativo" e "Cadastros"
					$menu = Menu::getCodigoMenu('administrativo');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";						
					endforeach;
					
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}
					
					$menu = Menu::getCodigoMenu('cadastros');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";
					endforeach;
					
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}				

					$menu = Menu::getCodigoMenu('acessos');					
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";		

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,0)";
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}

					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
					
					$menu = Menu::getCodigoMenu('usuários');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";			

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,0)";								
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}
					
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
				}
				else if ($name == 'CLIENTE'){
					//CLIENTE-> tem acesso aos menus "Cadastros" e "Clientes"
					$menu = Menu::getCodigoMenu('cadastros');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";						
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
					
					$menu = Menu::getCodigoMenu('clientes');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					

					$menu = Menu::getCodigoMenu('Usuários');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";	

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,0)";								
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}

					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
					
					$menu = Menu::getCodigoMenu('Chamados');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";		

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,1)";								
					endforeach;					
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}

					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}				
				}
				else if ($name == 'FUNCIONARIO'){
					$menu = Menu::getCodigoMenu('cadastros');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";						
					endforeach;		
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
					
					$menu = Menu::getCodigoMenu('Funcionários');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";						
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					

					$menu = Menu::getCodigoMenu('Usuários');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";	

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,0)";								
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}

					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
					
					$menu = Menu::getCodigoMenu('Atendimentos');
					foreach ($menu as $men):
						$sql = "insert into adm.acessomenu (codigomenu,userid,rolesid)
								values (".$men['codigomenu'].",:userid,:rolesid)";		

						$sql2 = "insert into adm.acesso (codigoobjeto,userid,rolesid,isclient)
									  values (".$men['codigoobjeto'].",:userid,:rolesid,0)";								
					endforeach;
					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}

					$pdo = Connection::get()->Connect();
					$stmt = $pdo->prepare($sql2);
					$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
					$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);
					
					if ($stmt->execute()){
						$transacao_ok = true;
					}					
				}				
				
				/*
				$pdo = Connection::get()->Connect();
				$stmt = $pdo->prepare($sql);
					
				$stmt->bindParam(':userid',$id, \PDO::PARAM_INT);
				$stmt->bindParam(':rolesid',$rolesid, \PDO::PARAM_INT);

				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}*/

				return $transacao_ok;
					
			} catch (\PDOException $e){
				echo $e->getMessage();
			}			
		}
	
		public static function save($objeto, $usuario, $roles, $insert, $update, $delete)
		{
			if (empty($objeto) || empty($usuario) || empty($roles) || empty($insert) || empty($update) || empty($delete)){
				return false;
			}
			
			try {
				$sql = "INSERT INTO adm.acesso (codigoobjeto,userid,rolesid,allowinsert,allowupdate,allowdelete) 
						values (:objeto, :usuario, :roles, :insert, :update, :delete)";
						
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':objeto', $objeto, \PDO::PARAM_INT);
				$stmt->bindParam(':usuario',$usuario, \PDO::PARAM_INT);
				$stmt->bindParam(':roles',$roles, \PDO::PARAM_INT);
				$stmt->bindParam(':insert',$insert,\PDO::PARAM_INT);
				$stmt->bindParam(':update',$update,\PDO::PARAM_INT);
				$stmt->bindParam(':delete', $delete,\PDO::PARAM_INT);
				
				if ($stmt->execute()){
					return true;
				}
				else {
					return false;
				}				
			}
			catch (\PDOException $e){
				echo $e->getMessage();
			}
		}
		
		public static function remove ($objeto, $usuario, $roles)
		{
			if (empty($objeto) || empty($usuario) || empty($roles)){
				exit;
			}
			
			try {
				$sql = "DELETE FROM adm.acesso
						WHERE codigoobjeto = :objeto
						AND userid = :usuario
						AND rolesid = :roles";
						
				$pdo = Connection::get()->connect();
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':objeto', $objeto, \PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, \PDO::PARAM_INT);
				$stmt->bindParam(':roles', $roles,\PDO::PARAM_INT);
				
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