<html>

<head>
 <title>Sign up</title>

<style>

* {box-sizing: border-box}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* Full-width input fields */
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

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit/register button */
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

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

</style>
<?php 

  $ID = $_GET['ID'];

?>


</head>

<form action="cadastro_turma.php" method="post">
  <div class="container">
    <h1>Cadastro de turmas</h1>
    <hr>
    <input type="hidden" name="ID" value="<?php echo $ID; ?>">

    <label for="name"><b>Nome</b></label>
    <input type="text" placeholder="Enter name" name="name" id="name" required>

    <label for="data-de-entrega"><b>Data de entrega de notas:</b></label>
    <input type="date" placeholder="" name="entrega" id="entrega">
	

    <button type="submit" class="registerbtn">Enviar</button>
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