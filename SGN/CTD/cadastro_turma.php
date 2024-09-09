<?php
session_start(); //veremos depois

//include "functions.php"; //veremos depois


// Insere o arquivo de configuracao de acesso ao Banco MYSQL
    include ('../config.php');


// Puxa os dados do formulário via método POST

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
