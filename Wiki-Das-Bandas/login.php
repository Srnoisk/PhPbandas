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
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans&display=swap" rel="stylesheet"> <!-- https://fonts.google.com/specimen/Kumbh+Sans -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">  <!-- https://fontawesome.com/-->  
    <link rel="stylesheet" href="css/magnific-popup.css">       <!-- https://dimsemenov.com/plugins/magnific-popup/ -->
    <link rel="stylesheet" href="css/tooplate-vertex.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
        
        <a href="./index.html" class="tm-btn" style="display: flex; justify-content: center; align-items: center; width: 80px; height: 50px; padding: 0; margin: 0; text-decoration: none;">voltar</a>



            <div class="col-md-6">
                <h2 class="text-center">Login</h2>
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $erro; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="login.php" class="tm-contact-form tm-mb-200">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control rounded-0" id="nome" placeholder="Digite seu nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control rounded-0" id="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="form-group tm-text-right">
                            <button type="submit" class="tm-btn">Enviar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
