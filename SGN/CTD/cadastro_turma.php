<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: ../f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>

<?php
    //Seleciona o usuário logado, conecta e tals

session_start();

    include ('../config.php');

	 $nom = $_POST["name"];
	 $ID = $_POST['ID'];
	 $dat = $_POST['entrega']


//----------------------------------------------------------------------------------------
?>	

<?php
if($nom==""){
		?>
		<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
		alert ("ERRO!\n\n Voce deve digitar um nome! \n\n \n\n")
		</SCRIPT>
		<SCRIPT language="JavaScript">window.history.go(-1);</SCRIPT>
		<?php		
}

else{
			//Insere os dados no banco de dados
			$sql = "INSERT INTO turma (Data_entrega, Nome, idCurso) VALUES('{$dat}','{$nom}','{$ID}')" or die( mysql_error() );

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
