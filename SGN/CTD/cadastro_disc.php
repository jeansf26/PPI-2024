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

    include ('../config.php');

	 $nom = $_POST["name"];
	 $ID = $_POST['ID'];
	 $prof = $_POST['prof'];


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
			$sql = "INSERT INTO disciplina (Nome, idTurma) VALUES('{$nom}','{$ID}')" or die( mysql_error() );

			$salvar = mysqli_query($conn, $sql);

			$ID_disc_query = "SELECT ID FROM disciplina WHERE Nome = '$nom' AND idTurma = '$ID' LIMIT 1";
			$result_disc = mysqli_query($conn, $ID_disc_query);

			if ($result_disc && $row_disc = mysqli_fetch_assoc($result_disc)) {
			    $ID_disc = $row_disc['ID'];

			    $sql2 = "INSERT INTO leciona (ID, idProfessor) VALUES('{$ID_disc}','{$prof}')" or die( mysql_error() );

				$salvar2 = mysqli_query($conn, $sql2);

			    $sql_alunoturma = "SELECT CPF FROM turma_aluno WHERE ID = '$ID'";
			    $result_alunoturma = mysqli_query($conn, $sql_alunoturma);

			    if ($result_alunoturma && mysqli_num_rows($result_alunoturma) > 0) {

			        while ($row = mysqli_fetch_assoc($result_alunoturma)) {
			            $sql3 = "INSERT INTO disciplina_aluno (PPI, MC, AIA, Observacoes, AIS, Faltas, Nota1, Nota2, CPF, ID, parcial1, parcial2)
	                 VALUES ('', '', '', '', '', '', '', '', '{$row['CPF']}', '$ID_disc', '', '')";
			            $salvar3 = mysqli_query($conn, $sql3);
			        }
			    }

			}


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
