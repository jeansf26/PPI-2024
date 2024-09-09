<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Aluno</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php
        include 'config.php';

        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];

            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Execute a lógica de exclusão no banco de dados
                $sql = "DELETE FROM usuario_setor_professor_administrador WHERE ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $ID); // Usando bind_param para evitar SQL Injection

                if ($stmt->execute()) {
                    echo 'Setor excluído com sucesso!';
                    header("Location: pag_set.php");
                } else {
                    echo 'Erro ao excluir o Setor: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                // Exibe o modal de confirmação
                echo '
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmar Exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir este usuario?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'pag_set.php\'">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Sim, Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $("#confirmModal").modal("show");
                    });
                </script>
                ';
            }
        } else {
            echo 'ID do usuario não fornecido.';
        }
        ?>
    </div>
</body>
</html>
