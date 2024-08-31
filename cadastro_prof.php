<?php
session_start(); //veremos depois

//include "functions.php"; //veremos depois


// Insere o arquivo de configuracao de acesso ao Banco MYSQL
    include ('config.php');


// Puxa os dados do formulário via método POST

	 $nom = $_POST["name"];
	 $ema = $_POST["mal"];
	 $sen = $_POST["psw"];
	 $mat = $_POST["mat"];
	 $tipo = "prof";


//----------------------------------------------------------------------------------------
?>	

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


//faz o INSERT na tabela "usuario" no BANCO "progweb" 

else{

		$senha_encriptada = md5($sen);

			$sql = "INSERT INTO usuario_setor_professor_administrador (Nome,Email,Senha,Tipo_usuario,ID) VALUES('{$nom}','{$ema}','{$senha_encriptada}','{$tipo}','{$mat}')" or die( mysql_error() );

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
