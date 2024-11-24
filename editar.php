<?php
session_start();

if (empty($_SESSION['id'])) {
    echo "<script>alert('Faça login para acessar esta página!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $novoNome = $_POST['nome'];
        $novoEmail = $_POST['email'];

        $sql = $pdo->prepare("UPDATE `clientes_cadastro` SET nome = ?, email = ? WHERE id = ?");
        $sql->execute([$novoNome, $novoEmail, $_SESSION['id']]);

        $_SESSION['nome'] = $novoNome;
        $_SESSION['email'] = $novoEmail;

        echo "<script>alert('Dados atualizados com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.html'>";
        exit;
    }

    $sql = $pdo->prepare("SELECT * FROM `clientes_cadastro` WHERE id = ?");
    $sql->execute([$_SESSION['id']]);
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<script>alert('Usuário não encontrado!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.html'>";
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Dados</h2>
        <form method="POST" action="editar.php">
            <div class="form-group mb-3">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" class="form-control" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Salvar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
