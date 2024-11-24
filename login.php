<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = $pdo->prepare("SELECT * FROM `clientes_cadastro` WHERE nome = ? AND email = ?");
    $sql->execute([$nome, $email]);
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        echo "<script>alert('Login realizado com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.html'>"; 
        exit;
    } else {
        $erro = "Nome ou email inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Login</h2>
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $erro; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group mb-3">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite seu nome" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
