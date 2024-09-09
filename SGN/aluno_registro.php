<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>

<html>

<head>
 <title>Cadastrar alunos</title>

 <!-- CCS, entendo pouco mas esta aí (Se possível até o final trocamos tudo por bootstrap) -->

<style>

* {box-sizing: border-box}

.container {
  padding: 16px;
}

input[type=text], input[type=password], input[type=date] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

.sendbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.sendbtn:hover {
  opacity:1;
}

a {
  color: dodgerblue;
}

.signin {
  background-color: #f1f1f1;
  text-align: center;
}
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

</style>



</head>

<!-- Formulário de cadastro -->

<form enctype="multipart/form-data" action="cadastro_aluno.php"  method="POST">
  <div class="container">
    <h1>Cadastrar alunos</h1>
    <hr>

    <label for="name"><b>Nome</b></label>
    <input type="text" placeholder="Digite o nome" name="name" id="name" required>

    <label for="cpf"><b>CPF</b></label>
    <input type="text" placeholder="Digite aqui" name="cpf" id="cpf" required>

    <label for="mat"><b>número de matrícula</b></label>
    <input type="text" placeholder="Digite aqui" name="mat" id="mat" required>
	
	<label for="mail"><b>e-mail</b></label>
    <input type="text" placeholder="Digite aqui" name="mail" id="mail" required>
	
	<label for="gen"><b>gênero</b></label>
    <input type="text" placeholder="Digite aqui" name="gen" id="gen" required>
	
	<label for="dat"><b>Data de nascimento</b></label>
    <input type="date" placeholder="Digite aqui" name="dat" id="dat" required>
	
	<label for="cty"><b>Cidade</b></label>
    <input type="text" placeholder="Digite aqui" name="cty" id="cty" required>
	
	<label for="uf"><b>UF</b></label>
    <input type="text" placeholder="Digite aqui" name="uf" id="uf" required>
	
	<label for="rep"><b>reprovações</b></label>
    <input type="number" placeholder="Digite aqui" name="rep" id="rep" required>

    <br><br>
  <label for="acomp"><b>Acompanhamento:</b></label>
    <input type="radio" id="acomp_sim" name="acomp" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="acomp_nao" name="acomp" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="aux_per"><b>Auxilio permanencia</b></label>
    <input type="radio" id="aux_per_sim" name="aux_per" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="aux_per_nao" name="aux_per" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label>Apoio Psicológico:</label>
    <input type="radio" id="psicologico_sim" name="ap_psic" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="psicologico_nao" name="ap_psic" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="cot"><b>Cotista</b></label>
    <input type="radio" id="cot_sim" name="cot" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="cot_nao" name="cot" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="estag"><b>Estagio</b></label>
    <input type="radio" id="estag_sim" name="estag" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="estag_nao" name="estag" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="inter"><b>Interno</b></label>
    <input type="radio" id="inter_sim" name="inter" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="inter_nao" name="inter" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>

	<label for="acomp_saude"><b>Acompanhamento de saúde</b></label>
    <input type="radio" id="acomp_saude_sim" name="acomp_saude" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="acomp_saude_nao" name="acomp_saude" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>

  <label for="proj_pesq"><b>Projeto de pesquisa</b></label>
    <input type="radio" id="proj_pesq_sim" name="proj_pesq" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="proj_pesq_nao" name="proj_pesq" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="proj_ext"><b>Projeto de extensão</b></label>
    <input type="radio" id="proj_ext_sim" name="proj_ext" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="proj_ext_nao" name="proj_ext" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>
	
	<label for="proj_ens"><b>Projeto de ensino</b></label>
    <input type="radio" id="proj_ens_sim" name="proj_ens" value="1">
    <label for="psicologico_sim">Sim</label>
    <input type="radio" id="proj_ens_nao" name="proj_ens" value="0" checked>
    <label for="psicologico_nao">Não</label><br><br>

    <button type="submit" class="sendbtn">Enviar</button>
  </div>

</form> 
 
  <div class="container" style="background-color:#f1f1f1">
    <button onclick="goBack()" class="cancelbtn">Cancel</button>
	
	<script>
    function goBack() {
      window.history.back();
    }
  </script>
  


</html>


