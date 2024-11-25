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

 
    $sql = $pdo->prepare("DELETE FROM `clientes_cadastro` WHERE email = ?");
    $sql->execute([$email]);

 
    $_SESSION['erro'] = "<div class='alert alert-success' role='alert'>Conta excluída com sucesso!</div>";
    echo "<meta http-equiv='refresh' content='0; url=index.html'>";
} catch (PDOException $e) {
    $_SESSION['erro'] = "<div class='alert alert-danger' role='alert'>Erro ao excluir conta: " . $e->getMessage() . "</div>";
    echo "<meta http-equiv='refresh' content='0; url=index.html'>";
}
?>
