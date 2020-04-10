<?php 
	
	namespace App\models; 
	
	use \App\Connection as Connection; 
	
	class User { /** * Busca usuários * * Se o ID não for passado, busca todos. Caso contrário, filtra pelo ID especificado. */ 

	public static function selectAll($id = null) { $where = ''; if (!empty($id)) { $where = 'WHERE userid = :id'; } $sql = sprintf("SELECT userid,username,password FROM adm.user %s ORDER BY username ASC", $where); 
	
		try {
			$pdo = Connection::get()->connect();
			
			$stmt = $pdo->prepare($sql);
		
			if (!empty($where)){
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			}
			$stmt->execute();
			
			$users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
			return $users;
		
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}	
    }
 
 
    /**
     * Salva no banco de dados um novo usuário
     */	 
	 
    public static function save($username, $password)
    {
        if (empty($username) || empty($password))
        {
            echo "Você precisa preencher todos os campos!";
            return false;
        }
         
		try {
			$pdo = Connection::get()->connect();
			
			$sql = "insert into adm.user (userid, username, password) values (nextval('adm.user_userid_seq'), :username, :password)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);

			if ($stmt->execute()) {
				return true;
			}
			else {
				echo "Erro ao cadastrar Usuário";
				print_r($stmt->errorInfo());
				return false;
			}		
		
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
    }
 
    /**
     * Altera no banco de dados um usuário
     */
    public static function update($id, $username, $password)
    {
        // validação (bem simples, só pra evitar dados vazios)
        if (empty($username) || empty($password))
        {
            echo "Favor preencher todos os campos!";
            return false;
        }
		
		try {
			$pdo = Connection::get()->connect();
			
			$sql = "update adm.user set username = :username, password = :password where userid = :userid";
			$stmt = $pdo->prepare($sql);
			
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':userid', $id, \PDO::PARAM_INT);
			
			if ($stmt->execute()) {
				return true;
			}
			else {
				echo "Erro ao atualizar o Usuário";
				print_r($stmt->errorInfo());
				return false;
			}			
		
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
    } 
 
    public static function remove($id)
    {
        // valida o ID
        if (empty($id))
        {
            echo "ID não informado";
            exit;
        }
		
		try {
			$pdo = Connection::get()->connect();
			
			$sql = "delete from adm.user where userid = :userid";
			$stmt = $pdo->prepare($sql);
			
			$stmt->bindParam(':userid', $id, \PDO::PARAM_INT);
			
			if ($stmt->execute()) {
				return true;
			}
			else {
				echo "Erro ao excluir o Usuário";
				print_r($stmt->errorInfo());
				return false;
			}			
		
		} catch (\PDOException $e) {
			echo $e->getMessage();
		} 
    }
	
	public static function login($username,$password)
	{		
		try {
			
			$sql = "select userid, username, password 
					from adm.user
					WHERE lower(username) = lower(:username)
					AND lower(password) = lower(:password)";
				
			$pdo = Connection::get()->connect();
			
			$stmt = $pdo->prepare($sql);
			
			$stmt->bindParam(':username',$username);
			$stmt->bindParam(':password',$password);
			
			$stmt->execute();
			
			$users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
			return $users;
		
		} catch (\PDOException $e){
			echo $e->getMessage();
		}
	}
}

















