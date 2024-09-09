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
	 $cpf = $_POST["cpf"];
	 $mat = $_POST["mat"];
	 $mail = $_POST["mail"];
	 $gen = $_POST["gen"];
	 $data = $_POST["dat"];
	 $cidade = $_POST["cty"];
	 $uf = $_POST["uf"];
	 $rep = $_POST["rep"];
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



?>	

<?php		



//faz o INSERT na tabela


		$sql = "INSERT INTO aluno (CPF, Acompanhamento, Email, Nome, Aux_permanencia, Cidade, Genero, Reprovacoes, Apoio_psic, Cotista, Data_nasc, UF, Estagio, Interno, Matricula, Acomp_saude, Proj_pesq, Proj_ext, Proj_ens) VALUES('{$cpf}','{$acomp}','{$mail}','{$nom}','{$aux_perm}','{$cidade}','{$gen}','{$rep}','{$ap_psic}','{$cot}','{$data}','{$uf}','{$estag}','{$inter}','{$mat}','{$acomp_saude}','{$proj_pesq}', '{$proj_ext}', '{$proj_ens}')" or die( mysql_error() );

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

	

?>
