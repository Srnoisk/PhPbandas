<?php
session_start();


if (empty($_SESSION['email'])) {
    echo "<script>alert('Usuário não logado! Faça o login...')</script>";
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    exit;
}

$email = $_SESSION['email'];

try {
   
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');

   
    $sql = $pdo->prepare("SELECT * FROM `clientes_cadastro` WHERE email = ?");
    $sql->execute([$email]);
    $cliente = $sql->fetch(PDO::FETCH_ASSOC);


    if (!$cliente) {
        echo "<script>alert('Cliente não encontrado!')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.html'>";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Exclusão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Confirmar Exclusão de Dados</h2>
        <div class="alert alert-warning" role="alert">
            <strong>ATENÇÃO!</strong> Você está prestes a excluir permanentemente os dados abaixo.
        </div>
        
     
        <div class="mb-3">
            <strong>Nome:</strong> <?php echo htmlspecialchars($cliente['nome']); ?>
        </div>
        <div class="mb-3">
            <strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?>
        </div>

       
        <form action="excluir_cliente.php" method="POST">
            <button type="submit" class="btn btn-danger">Excluir Permanentemente</button>
            <a href="index.html" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
