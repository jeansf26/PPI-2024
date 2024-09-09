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
 <title>Cadastro de Setores</title>

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


.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
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

<form action="cadastro_set.php" method="post">
  <div class="container">
    <h1>Cadastro de Setores</h1>
    <hr>

    <label for="name"><b>Nome</b></label>
    <input type="text" placeholder="Enter name" name="name" id="name" required>

    <label for="mail"><b>Email</b></label>
    <input type="text" placeholder="Enter email" name="mal" id="mal" required>
	
	<label for="psw"><b>Senha</b></label>
    <input type="password" placeholder="Enter password" name="psw" id="psw" required>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container" style="background-color:#f1f1f1">
    <button onclick="goBack()" class="cancelbtn">Cancel</button>
	
	<script>
    function goBack() {
      window.history.back();
    }
  </script>
  
</form>

</html>
