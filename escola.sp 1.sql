Delimiter $$

Drop Procedure if exists listarUsuarios$$
Create Procedure listarUsuarios(pTipo int)
begin
	if (pTipo = 0) Then
		Select u.nm_email, u.nm_usuario, u.cd_tipo_usuario, tu.nm_tipo_usuario
		from usuario u join tipo_usuario tu on (u.cd_tipo_usuario =  tu.cd_tipo_usuario)
		order by u.nm_usuario;
    else
    	Select u.nm_email, u.nm_usuario, u.cd_tipo_usuario, tu.nm_tipo_usuario
		from usuario u join tipo_usuario tu on (u.cd_tipo_usuario =  tu.cd_tipo_usuario)
		where u.cd_tipo_usuario = pTipo
		order by u.nm_usuario;
    end if;

end$$

/*
Drop Procedure if exists listarUsuarios$$
Create Procedure listarUsuarios()
begin
	Select u.nm_email, u.nm_usuario, u.cd_tipo_usuario, tu.nm_tipo_usuario
	from usuario u join tipo_usuario tu on (u.cd_tipo_usuario =  tu.cd_tipo_usuario)
	order by u.nm_usuario;
end$$

Drop Procedure if exists listarProfessores$$
Create Procedure listarProfessores()
begin
	Select u.nm_email, u.nm_usuario, u.cd_tipo_usuario, tu.nm_tipo_usuario
	from usuario u join tipo_usuario tu on (u.cd_tipo_usuario =  tu.cd_tipo_usuario)
	where u.cd_tipo_usuario = 2 order by u.nm_usuario;
end$$

Drop Procedure if exists listarAlunos$$
Create Procedure listarAlunos()
begin
	Select u.nm_email, u.nm_usuario, u.cd_tipo_usuario, tu.nm_tipo_usuario
	from usuario u join tipo_usuario tu on (u.cd_tipo_usuario =  tu.cd_tipo_usuario)
	where u.cd_tipo_usuario = 3 order by u.nm_usuario;
end$$
*/

Drop Procedure if exists criarUsuario$$
Create Procedure criarUsuario(pEmail varchar(200), pNome varchar(200), pSenha varchar(15), pTipo int)
begin
    Declare qtd int default 0;
    
	Select  count(*) into qtd from usuario where nm_email = pEmail;
    
    if (qtd = 1) Then
		signal sqlstate '45000' set message_text = 'E-mail já cadastrado.';
	else
	Insert into usuario values (pEmail, pNome, md5(pSenha), pTipo);
    end if;
end$$

Drop Procedure if exists alterarDadosUsuario$$
Create Procedure alterarDadosUsuario(pEmail varchar(200), pNome varchar(200), pSenha varchar(64))
begin
	Declare qtd int default 0;
	Select  count(*) into qtd from usuario where nm_email = pEmail;
    
    if (qtd = 0) Then
		signal sqlstate '45000' set message_text = 'Usuário não existe. Não é possível alterar.';
	else
    Update usuario
		set nm_usuario =pNome, nm_senha = md5(pSenha)
			where nm_email = pEmail;
	end if;
end$$

Drop Procedure if exists excluirUsuario$$
Create Procedure excluirUsuario(pEmail varchar(200))
begin
	Declare qtd int default 0;
	Select  count(*) into qtd from usuario where nm_email = pEmail;
    
     if (qtd = 0) Then
		signal sqlstate '45000' set message_text = 'Usuário não existe. Não é possível excluir.';
	else
		Delete from usuario where nm_email = pEmail;
	end if;

end$$
Delimiter ;