<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
// Inicia a sessão
session_start();

// Destroi todas as variáveis de sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login ou outra página desejada
header("Location: f_logina.php");
exit();
?>