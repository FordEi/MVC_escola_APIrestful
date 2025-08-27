<?php class Banco
 {
 	private $conexao = null;
 	private $cSQL = null;
 	public function __construct() {}
	private function Conectar()
 	{
 		try {
 			$this->conexao = new PDO('mysql:dbname=escola;host=localhost;', 'root', 'root');
 			$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conexao->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
		} catch (PDOException $Erro) {
			throw new Exception('Erro ao conectar ao Servidor. Tente novamente.');
		}
	}

	
	protected function Desconectar()
	{
		try {
			$this->conexao = null;
		} catch (PDOException $Erro) {
			throw new Exception('Não foi possível fechar a conexão.');
		}
	}

	protected function Consultar($nomeProcedure, $parametros = [])
	{
		try {
			$this->Conectar();

			$listaNomesParametros = [];
			foreach ($parametros as $chave => $valor) {
				$listaNomesParametros[] = ':' . $chave;
			}

			$comando = 'CALL ' . $nomeProcedure;
			if (count($listaNomesParametros) > 0) {
				$comando .= '(' . implode(', ', $listaNomesParametros) . ')';
			}

			$this->cSQL = $this->conexao->prepare($comando);

			foreach ($parametros as $chave => $valor) {
				$this->cSQL->bindValue(':' . $chave, $valor);
			}

			$this->cSQL->execute();
			$dados = $this->cSQL->fetchAll(PDO::FETCH_ASSOC);
			$this->Desconectar();
			return $dados;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	protected function Executar($nomeProcedure, $parametros = [])
	{
		try {
			$this->Conectar();

			$listaNomesParametros = [];
			foreach ($parametros as $chave => $valor) {
				$listaNomesParametros[] = ':' . $chave;
			}

			$comando = 'CALL ' . $nomeProcedure;
			if (count($listaNomesParametros) > 0) {
				$comando .= '(' . implode(', ', $listaNomesParametros) . ')';
			}

			$this->cSQL = $this->conexao->prepare($comando);

			foreach ($parametros as $chave => $valor) {
				$this->cSQL->bindValue(':' . $chave, $valor);
			}

			$this->cSQL->execute();
			$this->Desconectar();
		} catch (PDOException $e) {
			throw $e;
		}
	}
}
?>