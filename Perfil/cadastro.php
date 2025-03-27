<?php
include("../Conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Hash da senha

    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Este email já está cadastrado. Tente outro.";
    } else {
        // Usando prepared statements para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Feira Green</title>
    <link rel="stylesheet" type="text/css" href="../css/Login.css">
    
</head>
<body>
    <div class="formulario-Cadastro">
        <div class="container">
            <div class="centralizar">
                <div class="imgen">
                </div>
                <form method="post" action="cadastro.php">
                    <label for="nome" class="local-senha"><b>Nome</b></label>
                    <input type="text" placeholder="Insira seu nome" name="nome" required>
                    
                    <label for="email" class="local-senha"><b>Email</b></label>
                    <input type="email" placeholder="Insira seu email" name="email" required>

                    <label for="senha" class="local-senha"><b>Senha</b></label>
                    <input type="password" placeholder="Crie uma senha" name="senha" required>
                    
                    <button type="submit">Cadastrar</button>
                </form>
                <a href="login.php">Já tem uma conta? Faça login</a>
            </div>
        </div>
    </div>
</body>
</html>