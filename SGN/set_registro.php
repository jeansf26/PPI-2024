<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet">

 <title>Cadastro de professores</title>
</head>
<body>
<!-- Barra lateral -->

            <div class="sidebar">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <span class="icone"></span>
                            <span class="titulo">SGN</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php">
                            <span class="icone bi bi-house"></span>
                            <span class="titulo">Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="CTD/pag_curso.php">
                            <span class="icone bi bi-collection"></span>
                            <span class="titulo">Cursos</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_prof.php">
                            <span class="icone bi bi-person-circle"></span>
                            <span class="titulo">Professores</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_aluno.php">
                            <span class="icone bi bi-globe"></span>
                            <span class="titulo">Alunos</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_set.php">
                            <span class="icone bi bi-calendar-week"></span>
                            <span class="titulo">Setores</span>
                        </a>
                    </li>
                    <li>
                        <a href="confirm_logout.php">
                            <span class="icone bi bi-box-arrow-left"></span>
                            <span class="titulo">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>

<h2 style="margin-left: 210px !important;">Cadastro de Setores:</h2>
<br>


<div class="container" style="margin-left: 210px !important; font-size: 1.3rem; width: 80%;">
        <form action="cadastro_set.php" method="post">
            <div class="mb-3">
                <label class="form-label" for="name">Nome:</label>
                <input class="form-control py-1" type="text" id="name" name="name" placeholder="Digite o nome" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="mail">E-mail:</label>
                <input class="form-control py-1" type="text" id="mail" name="mal" placeholder="Digite o email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="psw">Senha:</label>
                <input class="form-control py-1" type="password" id="psw" name="psw" placeholder="Digite a senha" required>
            </div>

            <!-- Radios para opções Sim/Não -->
            <div class="mb-3">
                <label><b>Gerenciar professores:</b></label><br>
                <input type="radio" id="g_prof_sim" name="g_prof" value="1"> <label for="g_prof_sim">Sim</label>
                <input type="radio" id="g_prof_nao" name="g_prof" value="0" checked> <label for="g_prof_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar alunos:</b></label><br>
                <input type="radio" id="g_aluno_sim" name="g_aluno" value="1"> <label for="g_aluno_sim">Sim</label>
                <input type="radio" id="g_aluno_nao" name="g_aluno" value="0" checked> <label for="g_aluno_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Emitir boletins e relatórios:</b></label><br>
                <input type="radio" id="g_emiss_sim" name="g_emiss" value="1"> <label for="g_emiss_sim">Sim</label>
                <input type="radio" id="g_emiss_nao" name="g_emiss" value="0" checked> <label for="g_emiss_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar datas de entrega:</b></label><br>
                <input type="radio" id="g_data_sim" name="g_data" value="1"> <label for="g_data_sim">Sim</label>
                <input type="radio" id="g_data_nao" name="g_data" value="0" checked> <label for="g_data_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar orientador da mostra:</b></label><br>
                <input type="radio" id="g_orient_sim" name="g_orient" value="1"> <label for="g_orient_sim">Sim</label>
                <input type="radio" id="g_orient_nao" name="g_orient" value="0" checked> <label for="g_orient_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar observações:</b></label><br>
                <input type="radio" id="g_obs_sim" name="g_obs" value="1"> <label for="g_obs_sim">Sim</label>
                <input type="radio" id="g_obs_nao" name="g_obs" value="0" checked> <label for="g_obs_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar notas:</b></label><br>
                <input type="radio" id="g_nota_sim" name="g_nota" value="1"> <label for="g_nota_sim">Sim</label>
                <input type="radio" id="g_nota_nao" name="g_nota" value="0" checked> <label for="g_nota_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Gerenciar faltas:</b></label><br>
                <input type="radio" id="g_falta_sim" name="g_falta" value="1"> <label for="g_falta_sim">Sim</label>
                <input type="radio" id="g_falta_nao" name="g_falta" value="0" checked> <label for="g_falta_nao">Não</label>
            </div>
            
            <button type="submit" class="btn btn-primary p-1">Enviar</button>
            <button onclick="goBack()" class="btn btn-danger p-1">Cancel</button>
        </form>
    </div>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>