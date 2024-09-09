
<?php
session_start();  // Inicia a session


//Pega os dados enviados pelo formulário de login
$email = $_POST['email'];
$senha = $_POST['senha'];


//Verifica se tudo foi preenchido
if((!$email) || (!$senha)){

	echo "<script>alert('Por favor, todos campos devem ser preenchidos!')</script>;";
	
	include "f_login.php";

}
else{

	 $senha_encriptada = md5($senha); //Encriptando senha (Mudar mais tarde)


//Verifica se o usuário existe no banco de dados (Ainda não é seguro contra sql injection eu acho, talvez nem o resto, veremos)
include "config.php";

	$sql = mysqli_query($conn, "SELECT * FROM usuario_setor_professor_administrador WHERE Email='{$email}' AND Senha='{$senha_encriptada}'");
	
	$login_check = mysqli_num_rows($sql);

	if($login_check > 0){

		while($row = mysqli_fetch_array($sql)){

			foreach( $row AS $key => $val ){

				$$key = stripslashes( $val );

			}

//Sessão do usuario

			$_SESSION['email'] = $email;

			
//Vai pro index

			header("Location: index.php");

		}

	}
	else{
		//Informações erradas

		echo "<script>alert('Você não pode logar-se! Este usuário e/ou senha não são válidos! Por favor tente novamente ou contate o adminstrador do sistema!')</script>;";

		include "f_login.php";

	}
}

?>