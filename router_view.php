<?php
	require 'vendor/autoload.php';
	
	session_start();
	
	//Usaremos "$_GET['isclient']" quando for tratar a funcionalidade da tela de chamados quando o usuário for o cliente!
	
	if (isset($_GET['objeto'])){
		if ($_GET['objeto'] == 'sis' && $_GET['view'] == 'index'){
			$_SESSION['acessou'] = "S";
			$_SESSION['userid'] = $_GET['id'];
						
			$SisController = new App\controllers\SisController;
			$SisController->index($_GET['id']);
		}
		else if ($_GET['objeto'] == 'sis' && $_GET['view'] == 'sair'){
			$_SESSION['acessou'] = "";
			
			$SisController = new App\controllers\SisController;
			$SisController->index(0);
		}		
		else if ($_GET['objeto'] == 'user'){			
			if ($_GET['view'] == 'index'){
				$UserController = new App\controllers\UserController;
				$UserController->index($_SESSION['userid']);
			}
			else if ($_GET['view'] == 'create'){
				$UserController = new App\controllers\UserController;
				$UserController->create();
			}
			else if ($_GET['view'] == 'remove'){
				$id = $_GET['id'];
				$UserController = new App\controllers\UserController;
				$UserController->remove($id);
			}
			else if ($_GET['view'] == 'edit'){
				$id = $_GET['id'];
				$UserController = new App\controllers\UserController;
				$UserController->edit($id);				
			}
		}
		else if ($_GET['objeto'] == 'acesso'){
			if ($_GET['view'] == 'index'){
				$AcessoController = new App\controllers\AcessoController;
				$AcessoController->index($_SESSION['userid']);
			}
			else if ($_GET['view'] == 'defineacesso'){
				$id = $_GET['id'];				
				$AcessoController = new App\controllers\AcessoController;
				$AcessoController->defineacesso($id);
			}
		}
		else if ($_GET['objeto'] == 'chamado'){
			if ($_GET['view'] == 'cliente'){
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->cliente($_SESSION['userid']);
			}
			else if ($_GET['view'] == 'lido'){
				$id = $_GET['idchamado'];
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->lido($id);
			}			
			else if ($_GET['view'] == 'create'){
				$iduser = $_GET['clienteid'];
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->create($iduser);
			}
			else if ($_GET['view'] == 'funcionario'){				
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->funcionario($_SESSION['userid']);				
			}
			else if ($_GET['view'] == 'inicioatendimento'){
				$idchamado = $_GET['idchamado'];
				$idfuncionario = $_SESSION['userid'];
				
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->iniciarAtendimento($idchamado,$idfuncionario);
			}
			else if ($_GET['view'] == 'concluiratendimento'){
				$idchamado = $_GET['idchamado'];				
				$ChamadoController = new App\controllers\ChamadoController;
				$ChamadoController->fecharAtendimento($idchamado);
			}			
		}
	}
?>


