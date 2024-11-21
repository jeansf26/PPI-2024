<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>
<?php

    include ('config.php');


// Puxa os dados do formulário via método POST

	 $nom = $_POST["name"];
	 $ema = $_POST["mal"];
	 $sen = $_POST["psw"];
	 $tipo = "setor";
	 $g_prof = isset($_POST['g_prof']) ? $_POST['g_prof'] : 0;
	 $g_aluno = isset($_POST['g_aluno']) ? $_POST['g_aluno'] : 0;
	 $g_emiss = isset($_POST['g_emiss']) ? $_POST['g_emiss'] : 0;
	 $g_data = isset($_POST['g_data']) ? $_POST['g_data'] : 0;
	 $g_orient = isset($_POST['g_orient']) ? $_POST['g_orient'] : 0;
	 $g_obs = isset($_POST['g_obs']) ? $_POST['g_obs'] : 0;
	 $g_nota = isset($_POST['g_nota']) ? $_POST['g_nota'] : 0;
	 $g_falta = isset($_POST['g_falta']) ? $_POST['g_falta'] : 0;



?>	

<!-- Verifica se os dados enviados não estão vazios -->
<?php
if($nom==""){
		?>
		<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
		alert ("ERRO!\n\n Voce deve digitar um nome de usuario! \n\n \n\n")
		</SCRIPT>
		<SCRIPT language="JavaScript">window.history.go(-1);</SCRIPT>
		<?php		
}


if($ema==""){
		?>
		<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> alert ("ERRO!\n\n Voce deve digitar um e-mail de usuario! \n\n \n\n")</SCRIPT>
		<SCRIPT language="JavaScript">window.history.go(-1);</SCRIPT>
		<?php		
}


if($sen==""){
		?>
		<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> alert ("ERRO!\n\n Voce deve digitar uma senha segura para o usuario! \n\n \n\n")</SCRIPT>
		<SCRIPT language="JavaScript">window.history.go(-1);</SCRIPT>
		<?php		
}


//faz o INSERT na tabela

else{

		$senha_encriptada = md5($sen);

			$sql = "INSERT INTO usuario_setor_professor_administrador (Nome,Email,Senha,Tipo_usuario, Alt_list_prof, G_alunos, G_emiss, G_datas, G_orient, G_obs, G_notas, G_faltas) VALUES('{$nom}','{$ema}','{$senha_encriptada}','{$tipo}','{$g_prof}','{$g_aluno}','{$g_emiss}','{$g_data}','{$g_orient}','{$g_obs}','{$g_nota}','{$g_falta}')" or die( mysql_error() );

			$salvar = mysqli_query($conn, $sql);





						if (!$sql){

							echo "Ocorreu algum erro ao realizar o cadastro!";

						}
				

					else{
						

							?>
							<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
							alert ("\n\n Cadastrado realizado com sucesso! \n\n")</SCRIPT>

							<SCRIPT language="JavaScript">window.history.go(-2);</SCRIPT>

							<?php	
						}

	}

?>
