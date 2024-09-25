<?php
session_start();

$host = 'localhost';
$dbname = 'Teste_sistema';
$username = 'root';
$password = '06082006Gwas!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$isLoggedIn = isset($_SESSION['id_usuario']) && isset($_SESSION['tipo_usuario']);

$cliente = null;
$empresa = null;

if ($isLoggedIn) {
    if ($_SESSION['tipo_usuario'] == 'cliente') {
        $stmt = $pdo->prepare("SELECT nm_cliente FROM cliente WHERE id_cliente = :id");
        $stmt->execute(['id' => $_SESSION['id_usuario']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($_SESSION['tipo_usuario'] == 'empresa') {
        $stmt = $pdo->prepare("SELECT nm_empresa FROM empresa WHERE id_empresa = :id");
        $stmt->execute(['id' => $_SESSION['id_usuario']]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>LociMerx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/ADMIN/Css/index.css">
    <link rel="icon" href="http://localhost/ADMIN/Docs/Images/logo.png" style="border-radius: 24px;">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="http://localhost/public/Home/Php/index.php">
                <img src="http://localhost/ADMIN/Docs/Images/logo.png" alt="Logo LociMerx">
                <h1>LociMerx</h1>
            </a>
        </div>
        <div class="search-container">
            <form action="" class="search-form">
                <input type="text" id="search" name="search" class="search-input" placeholder="Pesquisar">
                <button type="submit" class="search-button"><i class="fi fi-rr-search"></i></button>
            </form>
        </div>
        <nav class="profile">
            <?php if ($isLoggedIn): ?>
                <a href="http://localhost/Public/Private/Php/perfil.php">
                    <p>
                        <?php
                            if (isset($cliente['nm_cliente'])) {
                                echo htmlspecialchars($cliente['nm_cliente']);
                            } elseif (isset($empresa['nm_empresa'])) {
                                echo htmlspecialchars($empresa['nm_empresa']);
                            } else {
                                echo "Usuário";
                            }
                        ?>
                    </p>
                    <i class="fi fi-rr-user"></i>
                </a>
            <?php else: ?>
                <a href="http://localhost/Public/Log/php/login.php" class="login">Login</a>
                <span>|</span>
                <a href="http://localhost/Public/Log/php/cadastro.php" class="register">Cadastrar</a>
                <i class="fi fi-rr-user"></i>
            <?php endif; ?>
        </nav>
        <div class="car">
            <a href="">
                <i class="fi fi-rr-shopping-cart"></i>
            </a>
        </div>
    </header>

    <section>
        <div class="carousel">
            <nav class="horizontal-nav">
                <ul>
                <li><a href="">Alimentos e Bebidas</a></li>
                    <li><a href="">Artigos de Cozinha</a></li>
                    <li><a href="">Artigos de Esporte</a></li>
                    <li><a href="">Artigos para Animais de Estimação</a></li>
                    <li><a href="">Automotivos</a></li>
                    <li><a href="">Beleza e Cuidados Pessoais</a></li>
                    <li><a href="">Bebês e Crianças</a></li>
                    <li><a href="">Brinquedos</a></li>
                    <li><a href="">Colecionáveis e Hobbies</a></li>
                    <li><a href="">Decoração</a></li>
                    <li><a href="">Eletrodomésticos</a></li>
                    <li><a href="">Eletrônicos</a></li>
                    <li><a href="">Ferramentas</a></li>
                    <li><a href="">Informática e Acessórios</a></li>
                    <li><a href="">Instrumentos Musicais</a></li>
                    <li><a href="">Jardim e Exterior</a></li>
                    <li><a href="">Joias e Relógios</a></li>
                    <li><a href="">Livros e Mídias</a></li>
                    <li><a href="">Moda Fitness</a></li>
                    <li><a href="">Papelaria e Escritório</a></li>
                    <li><a href="">Produtos de Limpeza</a></li>
                    <li><a href="">Produtos para Casa</a></li>
                    <li><a href="">Roupas e Acessórios</a></li>
                    <li><a href="">Saúde e Bem-Estar</a></li>
                    <li><a href="">Viagem e Lazer</a></li>
                </ul>
            </nav>
        </div>
    </section>

    <div class="topo">
        <h1>Controle do Sistema</h1>
        <div class="card">
            <a href="http://localhost/ADMIN/Php/moderacao.php">
                <div class="moderacao">
                    <i class="fi fi-rr-lock"></i>
                    <h3>Moderação</h3>
                </div>
            </a>
            <a href="http://localhost/ADMIN/Php/contas.php">
                <div class="contas">
                    <i class="fi fi-rr-users"></i>
                    <h3>Contas</h3>
                </div>
            </a>
            <a href="">
                <div class="produtos">
                    <i class="fi fi-rr-basket-shopping-simple"></i>
                    <h3>Produtos</h3>
                </div>
            </a>
        </div>
    </div>


<script src="http://localhost/ADMIN/Js/rolagem_segmento.js"></script>
    
</body>
</html>