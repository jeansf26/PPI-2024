<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: ../f_login.php");
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
        //Seleciona o usuário logado, conecta e tals
        include '../config.php';

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['ID'])) {
            $ID = intval($_GET['ID']); // Garante que o ID é um número inteiro

            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Inicia uma transação
                $conn->begin_transaction();

                try {
                    //Pega o ID da turma
                    $sqlGetIDturma = "SELECT ID FROM turma WHERE idCurso = ?";
                    $stmtGetIDturma = $conn->prepare($sqlGetIDturma);
                    $stmtGetIDturma->bind_param("i", $ID);
                    $stmtGetIDturma->execute();
                    $result = $stmtGetIDturma->get_result();
                    
                    //Checa se foi um resultado válido, se sim armazena em uma variável
                    if ($result->num_rows > 0) {
                        $IDturmarow = $result->fetch_assoc();
                        $IDturma = $IDturmarow['ID'];

                        //Deleta as disciplinas que estão nas turmas correspondentes ao curso escolhido(Usando o ID da tuma pego antes)
                        $sql_del_d = "DELETE FROM disciplina WHERE idTurma = ?";
                        $stmt_d = $conn->prepare($sql_del_d);
                        $stmt_d->bind_param("i", $IDturma);
                        $stmt_d->execute();
                    }

                    //Deleta o curso e as turmas correspondentes
                    $sql_del_t = "DELETE FROM turma WHERE idCurso = ?";
                    $stmt_t = $conn->prepare($sql_del_t);
                    $stmt_t->bind_param("i", $ID);
                    $stmt_t->execute();

                    $sql_del_c = "DELETE FROM curso WHERE ID = ?";
                    $stmt_c = $conn->prepare($sql_del_c);
                    $stmt_c->bind_param("i", $ID);
                    $stmt_c->execute();

                    // Se tudo correu bem, confirma a transação
                    $conn->commit();

                    // Redireciona para a página anterior após a exclusão
                    echo "<script>
                            alert('Registro excluído com sucesso!');
                            window.location.href = 'pag_curso.php'; // Redireciona para a página anterior
                          </script>";
                    exit();
                } catch (Exception $e) {
                    // Se algo deu errado, desfaz a transação
                    $conn->rollback();
                    echo 'Erro ao excluir o registro: ' . $e->getMessage();
                }
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
                                <p>Tem certeza que deseja excluir este registro?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'pag_curso.php\'">Cancelar</button>
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
            echo 'ID do registro não fornecido.';
        }

        ?>
    </div>
</body>
</html>
