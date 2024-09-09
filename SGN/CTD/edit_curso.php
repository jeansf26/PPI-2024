<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Curso</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Script do Bootstrap JS e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        * {box-sizing: border-box}
        .container {padding: 16px;}
        input[type=text], input[type=password] {
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
        hr {border: 1px solid #f1f1f1; margin-bottom: 25px;}
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
        .registerbtn:hover {opacity:1;}
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include '../config.php'; // Inclua seu arquivo de configuração do banco de dados

        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Recebe os dados do formulário
                $name = $_POST['name'];

                // Atualiza os dados no banco de dados
                $sql = "UPDATE curso SET Nome=? WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $ID);

                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Professor atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar professor: ' . $stmt->error . '</div>';
                }
                $stmt->close();
            } else {
                // Carrega os dados atuais do professor
                $sql = "SELECT * FROM curso WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    // Exibe o formulário com os dados do professor
                    echo '
                    <h1>Editar Curso</h1>
                    <p>Atualize as informações do professor abaixo.</p>
                    <hr>
                    <form method="POST" action="">
                        <label for="name"><b>Nome</b></label>
                        <input type="text" placeholder="Digite o nome" name="name" id="name" value="' . htmlspecialchars($row['Nome']) . '" required>
                        <button type="submit" class="registerbtn">Atualizar</button>
                    </form>
                    ';
                } else {
                    echo '<div class="alert alert-danger">Curso não encontrado.</div>';
                }
                $stmt->close();
            }
        } else {
            echo '<div class="alert alert-danger">Matrícula não fornecida.</div>';
        }
        ?>
        <div class="container" style="background-color:#f1f1f1">
            <button onclick="window.location.href='pag_curso.php'" class="cancelbtn">Cancelar</button>
        </div>
    </div>
</body>
</html>
