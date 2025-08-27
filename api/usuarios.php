<?php
	require_once('config.php');
	header('Content-Type: application/json');
	$metodo = $_SERVER['REQUEST_METHOD'];

	$controller = new UsuarioController();

	switch ($metodo) {
		case 'GET':
			$tipo = 0;
			$supostoLogin = null;
			$supostaSenha = null;
			if(isset($_GET['t']) && $_GET['t'] != ''){
				$tipo = $_GET['t'];
			}

			if((isset($_GET['l']) && $_GET['l'] != '') && (isset($_GET['s']) && $_GET['s'] != '')){
				$supostoLogin = $_GET['l'];
				$supostaSenha = $_GET['s'];
			}

			try{
				if($supostoLogin && $supostaSenha) {
					$dados = $controller->VerificarAcesso($supostoLogin, $supostaSenha);
				}else{
					$dados = $controller->Listar($tipo);
				}
				http_response_code(200);
				echo json_encode($dados);
			}
			catch (Exception $erro){
				http_response_code(500);
				echo json_encode(['mensagem'=>$erro->getMessage()]);
			}
			break;
		case 'POST':
			$corpo = json_decode(file_get_contents('php://input'), true);
			if (!validaCorpoRequisicao($corpo)){
				return;
			}
			$chaves = ['email', 'nome', 'senha', 'tipo'];
			if (!validaChaves($corpo, $chaves)){
				return;
			}
			try{
				$usuario = new Usuario($corpo['email'], $corpo['nome'], $corpo['senha'], $corpo['tipo']);
				$controller->Criar($usuario);
				http_response_code(200);
				echo json_encode(['mensagem'=>'Usuário criado com sucesso']);
			}
			catch (Exception $erro){
				http_response_code(500);
				echo json_encode(['mensagem'=>$erro->getMessage()]);
			}
			break;
		case 'PUT':

			$email = null;
			if(isset($_GET['email']) && $_GET['email'] != ''){
				$email = $_GET['email'];
			}
			else{
				http_response_code(400);
				echo json_encode(['mensagem'=>'E-mail é obrigatório']);
			}

			$corpo = json_decode(file_get_contents('php://input'), true);
			if (!validaCorpoRequisicao($corpo)){
				return;
			}
			$chaves = ['nome', 'senha'];
			if (!validaChaves($corpo, $chaves)){
				return;
			}
			try{
				$usuario = new Usuario($email, $corpo['nome'], $corpo['senha']);
				$controller->Alterar($usuario);
				http_response_code(200);
				echo json_encode(['mensagem'=>'Usuário alterado com sucesso']);
			}
			catch (Exception $erro){
				http_response_code(500);
				echo json_encode(['mensagem'=>$erro->getMessage()]);
			}
			break;
		case 'DELETE':
			$email = null;
			if(isset($_GET['email']) && $_GET['email'] != ''){
				$email = $_GET['email'];
			}
			else{
				http_response_code(400);
				echo json_encode(['mensagem'=>'E-mail é obrigatório']);
			}
			try{
				$controller->Excluir($email);
				http_response_code(200);
				echo json_encode(['mensagem'=>'Usuário excluído com sucesso']);
			}
			catch(Exception $erro){
				http_response_code(500);
				echo json_encode(['mensagem'=>$erro->getMessage()]);
			}
			break;
		default:
			http_response_code(400);
			echo json_encode(['mensagem'=>'Método Inválido']);
			break;
	}
	function validaCorpoRequisicao($corpo) {
		if (is_null($corpo))
		{
			http_response_code(400);
			echo json_encode(['mensagem'=>'Dados Inváidos!']);
			return false;
		}
		return true;
	}
	function validaChaves($corpo, $campos) {
		for ($i=0; $i < count($campos); $i++) { 
			if (!array_key_exists($campos[$i], $corpo))
			{
				http_response_code(400);
				echo json_encode(['mensagem'=>'Dados incorretos. Verifique a documentação da API e tente novamente!']);
				return false;
			}
			if ($corpo[$campos[$i]] == ''){
				http_response_code(400);
				echo json_encode(['mensagem'=>'Dados incorretos. Verifique a documentação da API e tente novamente!']);
				return false;
			}
		}
		return true;
	}
?>