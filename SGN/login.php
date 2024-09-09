<?php
session_start();  // Inicia a session



$email = $_POST['email'];
$senha = $_POST['senha'];


if((!$email) || (!$senha)){

	echo "<script>alert('Por favor, todos campos devem ser preenchidos!')</script>;";
	
	include "f_login.php";

}
else{

	 $senha_encriptada = md5($senha);



include "config.php";

	$sql = mysqli_query($conn, "SELECT * FROM usuario_setor_professor_administrador WHERE Email='{$email}' AND Senha='{$senha_encriptada}'");
	
	$login_check = mysqli_num_rows($sql);

	if($login_check > 0){

		while($row = mysqli_fetch_array($sql)){

			foreach( $row AS $key => $val ){

				$$key = stripslashes( $val );

			}

//ainda não abordaremos as sessoes no PHP!

			$_SESSION['email'] = $email;

			
//REDIRECIONAMENTO PARA A PAGINA DE LOGADO NO SISTEMA

			header("Location: index.php");

		}

	}
	else{

		echo "<script>alert('Você não pode logar-se! Este usuário e/ou senha não são válidos! Por favor tente novamente ou contate o adminstrador do sistema!')</script>;";

		include "f_login.php";

	}
}

?>