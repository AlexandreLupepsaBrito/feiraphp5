<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php"); 
    exit();
}

include("../Conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];
    $descricao = $_POST["descricao"];

    // Upload da imagem
    $imagem = $_FILES["imagem"];
    $imagemNome = uniqid() . "-" . basename($imagem["name"]);
    $imagemDestino = "uploads/" . $imagemNome;

    if (move_uploaded_file($imagem["tmp_name"], $imagemDestino)) {
        $sql = "INSERT INTO produtos (nome, preco, categoria, descricao, imagem) 
                VALUES ('$nome', '$preco', '$categoria', '$descricao', '$imagemNome')";

        if ($conn->query($sql) === TRUE) {
            echo "Produto adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar produto: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/produtos.css">
    <link rel="stylesheet" type="text/css" href="../css/defalt.css">
</head>
<header>
    <div class="logo">
        <a href="../home.php"><img src="../imagens/logoverde.png" alt="" width="200"></a>
    </div>
    <div id="area-menu">
        <a href="">Frutas</a>
        <a href="">Verduras</a>
        <a href="">Hortaliças</a>
        <a href="">Legumes</a>
        <a href="">Outros</a>
    </div>
    <nav>
        <img src="../imagens/pesquisa.png" alt="" width="20">
    <a href="/Perfil/perfil.php"><img src="../imagens/usuario.png" alt="" width="20"></a>
    <a href=""><img src="../imagens/carrinho-carrinho.png" alt="" width="20"></a>
    </nav>
</header>
<div class="line"></div>
<body>
    <div class="container">
    
    <h2>Adicionar Produto</h2>
    <form action="addproduto.php" method="post" enctype="multipart/form-data">

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" accept="image/*"><br>

        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" required><br><br>

        <label for="preco">Preço:</label>
        <input type="number" name="preco" step="0.01" required><br><br>

        <label for="categoria">Categoria:</label>
        <select name="categoria" required>
            <option value="" disabled selected>Selecione uma categoria</option>
            <option value="frutas">Frutas</option>
            <option value="verduras">Verduras</option>
            <option value="hortalicas">Hortaliças</option>
            <option value="legumes">Legumes</option>
            <option value="outros">Outros</option>
        </select><br><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" rows="4" required></textarea><br><br>

        <div class="btn-container">
            <button type="submit">Adicionar Produto</button><br><br>
            <a href="produtos.php">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>
</div>
</body>
<footer>
            <div class="footer-top">
                <div class="footer-top--left">
                    <a href="#">Contato</a>
                    <a href="#">Termos de Serviço</a>
                    <a href="#">Política de Privacidade</a>
                    <a href="#">Cancelamento, Troca e Reembolso</a>
                </div>
                <div class="footer-top--right">
                    <span>Boletim de Notícias</span>
                    <div class="footer-news-letter">
                        <input class="footer-input" type="email" placeholder="Digite o seu e-mail">
                        <button class="footer-button" type="button">Inscrever</button>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom--left">
                    <a href="#"><img class="footer-image" src="assets/imagens/instagram.png" alt=""></a>
                    <a href="#"><img class="footer-image" src="assets/imagens/facebook.png" alt=""></a>
                </div>
                <div>
                        &copy; 2024 FeiraGreen. Todos os direitos reservados.
                </div>
                <div class="footer-bottom--right">
                    <img class="footer-image" src="assets/imagens/mastercard.png" alt="">
                    <img class="footer-image" src="assets/imagens/paypal.png" alt="">
                    <img class="footer-image" src="assets/imagens/visa.png" alt="">
                </div>
            </div>
        </footer>
</html>