<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Aluno</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Script do Bootstrap JS e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php
        include '../config.php';

        // Cria a conexão
        $conn = new mysqli($servername, $username, $password, $database);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['ID'])) {
            $ID = intval($_GET['ID']); // Garante que o ID é um número inteiro

            $ID_return = "SELECT idCurso FROM turma WHERE ID = ?";
            $stmtID_return = $conn->prepare($ID_return);
            $stmtID_return->bind_param("i", $ID);
            $stmtID_return->execute();
            $result = $stmtID_return->get_result();
            $ID_returnrow = $result->fetch_assoc();

            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Inicia uma transação
                $conn->begin_transaction();

                try {
                    $sql_del_d = "DELETE FROM disciplina WHERE idTurma = ?";
                    $stmt_d = $conn->prepare($sql_del_d);
                    $stmt_d->bind_param("i", $ID); // Usando bind_param para evitar SQL Injection
                    $stmt_d->execute();

                    // Exclua os registros de turma
                    $sql_del_t = "DELETE FROM turma WHERE ID = ?";
                    $stmt_t = $conn->prepare($sql_del_t);
                    $stmt_t->bind_param("i", $ID); // Usando bind_param para evitar SQL Injection
                    $stmt_t->execute();

                    // Se tudo correu bem, confirma a transação
                    $conn->commit();

                    // Redireciona para a página anterior após a exclusão
                    echo "<script>
                            alert('Registro excluído com sucesso!');
                            window.location.href = 'pag_turma.php?ID=" . $ID_returnrow['idCurso'] . "'; // Redireciona para a página anterior
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
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'pag_turma.php?ID='. $ID_returnrow['idCurso'] . '\'">Cancelar</button>
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

        // Fecha a conexão
        $conn->close();
        ?>
    </div>
</body>
</html>
