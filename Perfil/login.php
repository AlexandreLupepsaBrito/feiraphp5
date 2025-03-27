<?php
session_start();
include("../Conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["nome"] = $row["nome"];
            header("Location: ../home.php"); // Redireciona para o painel
        } else {
            echo "<p class='error'>Senha incorreta!</p>";
        }
    } else {
        echo "<p class='error'>Usuário não encontrado!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Feira Green</title>
    <link rel="stylesheet" href="../css/Login.css">
    
</head>
<body>
    <div class="formulario-login">
        <div class="container">
            <div class="centralizar">
                <div class="imgen">
                <img src="../imagens/LogoFeiraGreen.png">
                </div>
                <form method="post" action="login.php">
                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Insira seu email" name="email" required>
                    
                    <label for="senha" class="local-senha"><b>Senha</b></label>
                    <input type="password" placeholder="Insira sua senha" name="senha" required>
                    
                    <button type="submit">Entrar</button>
                </form>
                <a href="#">Esqueceu a senha?</a>
                <a href="cadastro.php">Criar uma conta</a>
            </div>
        </div>
    </div>
</body>
</html>