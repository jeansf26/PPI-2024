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

	 $nom = mysqli_real_escape_string($conn, $_POST["name"]);
	$cpf = mysqli_real_escape_string($conn, $_POST["cpf"]);
	$mat = mysqli_real_escape_string($conn, $_POST["mat"]);
	$mail = mysqli_real_escape_string($conn, $_POST["mail"]);
	$gen = mysqli_real_escape_string($conn, $_POST["gen"]);
	$data = mysqli_real_escape_string($conn, $_POST["dat"]);
	$cidade = mysqli_real_escape_string($conn, $_POST["cty"]);
	$uf = mysqli_real_escape_string($conn, $_POST["uf"]);
	$rep = mysqli_real_escape_string($conn, $_POST["rep"]);
	$turma = mysqli_real_escape_string($conn, $_POST["turma"]);
	$acomp = isset($_POST['acomp']) ? $_POST['acomp'] : 0;
	$aux_perm = isset($_POST['aux_per']) ? $_POST['aux_per'] : 0;
	$ap_psic = isset($_POST['ap_psic']) ? $_POST['ap_psic'] : 0;
	$cot = isset($_POST['cot']) ? $_POST['cot'] : 0;
	$estag = isset($_POST['estag']) ? $_POST['estag'] : 0;
	$inter = isset($_POST['inter']) ? $_POST['inter'] : 0;
	$acomp_saude = isset($_POST['acomp_saude']) ? $_POST['acomp_saude'] : 0;
	$proj_pesq = isset($_POST['proj_pesq']) ? $_POST['proj_pesq'] : 0;
	$proj_ext = isset($_POST['proj_ext']) ? $_POST['proj_ext'] : 0;
	$proj_ens = isset($_POST['proj_ens']) ? $_POST['proj_ens'] : 0;

	// Consulta para obter ID da turma
	$id_turma_query = "SELECT ID FROM turma WHERE Nome = '{$turma}'";
	$result_turma = mysqli_query($conn, $id_turma_query);
	$row_turma = mysqli_fetch_assoc($result_turma);
	$id_turma = $row_turma['ID'];  

	// Inserção na tabela aluno
	$sql = "INSERT INTO aluno (CPF, Acompanhamento, Email, Nome, Aux_permanencia, Cidade, Genero, Reprovacoes, Apoio_psic, Cotista, Data_nasc, UF, Estagio, Interno, Matricula, Acomp_saude, Proj_pesq, Proj_ext, Proj_ens)
	        VALUES ('{$cpf}', '{$acomp}', '{$mail}', '{$nom}', '{$aux_perm}', '{$cidade}', '{$gen}', '{$rep}', '{$ap_psic}', '{$cot}', '{$data}', '{$uf}', '{$estag}', '{$inter}', '{$mat}', '{$acomp_saude}', '{$proj_pesq}', '{$proj_ext}', '{$proj_ens}')";

	$salvar = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	// Inserção na tabela turma_aluno
	$sql2 = "INSERT INTO turma_aluno (ID, CPF) VALUES ('{$id_turma}', '{$cpf}')";
	$salvar2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

	// Seleção de dados das disciplinas da turma para cadastrar na tabela disciplina_aluno depois
	$sql_disciplinas = "SELECT ID FROM disciplina WHERE idTurma = {$id_turma}";
	$result_disciplinas = mysqli_query($conn, $sql_disciplinas);

	if ($result_disciplinas && mysqli_num_rows($result_disciplinas) > 0) {
	    while ($row = mysqli_fetch_assoc($result_disciplinas)) {
	        $sql3 = "INSERT INTO disciplina_aluno (PPI, MC, AIA, Observacoes, AIS, Faltas, Nota1, Nota2, CPF, ID, parcial1, parcial2)
	                 VALUES ('', '', '', '', '', '', '', '', '{$cpf}', '{$row['ID']}', '', '')";
	        $salvar3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
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

	

?>
