<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Perfil/login.php"); 
    exit();
}

include("Conexao/conexao.php");

// Busca de produtos da API
$api_url = 'products.json';
$response = file_get_contents($api_url);


// Listando produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);


if ($response === false) {
    $error = "Falha ao acessar o arquivo JSON.";
    $products = null;
} else {
    $products = json_decode($response, true);
    if ($products === null && $response !== 'null') {
        $error = "Conteúdo do arquivo JSON inválido.";
        $products = null;
    }
}

// Filtra produtos para exibir apenas frutas
if (is_array($products)) {
    $promocao = array_filter($products, function($product) {
        return isset($product['type']) && $product['type'] === 'fruta';
    });
} else {
    $promocao = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loja Virtual de Produtos Naturais</title>
    <link rel="stylesheet" href="css/produtos.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <div class="logo">
        <a href="home.php"><img src="imagens/logoverde.png" alt="Logo" width="200"></a>
    </div>
    <div id="area-menu">
        <a href="">Frutas</a>
        <a href="">Verduras</a>
        <a href="">Hortaliças</a>
        <a href="">Legumes</a>
        <a href="">Outros</a>
    </div>
    <nav>
    <form method="GET" action="buscar.php" class="barra-pesquisa">
    <input type="text" name="palavra" placeholder="Buscar produto..." required>
    <button type="submit" class="botao-pesquisa">
        <img src="imagens/pesquisa.png" alt="Pesquisar" width="20">
    </button>
</form>
        <a href="Perfil/perfil.php"><img src="imagens/usuario.png" alt="Usuário" width="20"></a>
        <a href=""><img src="imagens/carrinho-carrinho.png" alt="Carrinho" width="20"></a>
    </nav>
</header>
        <div class="line"></div>
        <section id="home" class="d-flex">
        <?php if (isset($error)) { echo "<div class='error-message'>$error</div>"; } ?>
        <?php include 'carousel.php'; ?>
        </section>
        <div class="line"></div>
        <section class="promocao-header">
            <span class="promocao-header--title">PROMOÇÕES</span>
            <span>Produtos</span>
        </section>

        <div class="line"></div>

        <main class="produto-page">
    <div class="container-principal">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='produto-container-principal'>";
                echo "<div class='produto-principal'>";
                echo "<a href='paginapd.php?id=" . $row['id'] . "' aria-label='Ver detalhes do produto " . htmlspecialchars($row['nome']) . "'>";
                echo "<img src='Produtos/uploads/" . htmlspecialchars($row['imagem']) . "' alt='" . htmlspecialchars($row['nome']) . "' class='img-fluid' onerror=\"this.onerror=null; this.src='/path/to/default/image.jpg';\" />";
                echo "</a>";
                echo "<span>" . htmlspecialchars($row['nome']) . "</span>";
                echo "<span>R$ <span class='price'>" . number_format($row['preco'], 2, ',', '.') . "</span><br>";
                echo "<span class='unit'>" . htmlspecialchars($row['categoria']) . "</span>";
                echo "</div></div>";
            }
        } else {
            echo "<div class='produto-container-principal'><p>Nenhum produto encontrado.</p></div>";
        }
        ?>
    </div>
</main>

        <footer>
            <div class="footer">
                
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
            </div>
        </footer>
</body>
</html>

