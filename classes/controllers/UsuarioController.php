<?php 
class UsuarioController extends Banco {

    public function Listar($tipo = 0){
        try{
            $parametros = ['pTipo'=>$tipo];
            $dados = $this->Consultar("listarUsuarios", $parametros);
            return $dados;
        }
        catch(\Throwable $th){
            throw $th;
        }
    }

    public function Criar($usuario){
        try {
            $parametros = [
                'pEmail'=>$usuario->Email,
                'pNome'=>$usuario->Nome,
                'pSenha'=>$usuario->Senha,
                'pTipo'=>$usuario->Tipo
            ];
            $this->Executar("criarUsuario", $parametros);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function Alterar($usuario){
        try {
            $parametros = [
                'pEmail'=>$usuario->Email,
                'pNome'=>$usuario->Nome,
                'pSenha'=>$usuario->Senha,
            ];
            $this->Executar("AlterarDadosUsuario", $parametros);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function Excluir($email){
        try {
            $parametros = [
                'pEmail'=>$email
            ];
            $this->Executar("excluirUsuario", $parametros);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
?>