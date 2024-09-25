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

// Inicializa variáveis
$isLoggedIn = false;
$cliente = null;
$empresa = null;

// Verifica se o usuário está logado e se os dados da sessão existem
if (isset($_SESSION['tipo_usuario']) && isset($_SESSION['id_usuario'])) {
    $isLoggedIn = true;
    if ($_SESSION['tipo_usuario'] === 'cliente') {
        $stmt = $pdo->prepare("SELECT nm_cliente FROM cliente WHERE id_cliente = ?");
        $stmt->execute([$_SESSION['id_usuario']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($_SESSION['tipo_usuario'] === 'empresa') {
        $stmt = $pdo->prepare("SELECT nm_empresa FROM empresa WHERE id_empresa = ?");
        $stmt->execute([$_SESSION['id_usuario']]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    // Redireciona para a página de login se não estiver logado
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href = 'http://localhost/Public/Log/php/login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>LociMerx - Lista de Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/ADMIN/Css/moderacao.css">
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
            <a href="#">
                <i class="fi fi-rr-shopping-cart"></i>
            </a>
        </div>
    </header>

    <section>
        <div class="carousel">
            <nav class="horizontal-nav">
                <ul>
                    <li><a href="#">Alimentos e Bebidas</a></li>
                    <li><a href="#">Artigos de Cozinha</a></li>
                    <li><a href="#">Artigos de Esporte</a></li>
                    <li><a href="#">Artigos para Animais de Estimação</a></li>
                    <li><a href="#">Automotivos</a></li>
                    <li><a href="#">Beleza e Cuidados Pessoais</a></li>
                    <li><a href="#">Bebês e Crianças</a></li>
                    <li><a href="#">Brinquedos</a></li>
                    <li><a href="#">Colecionáveis e Hobbies</a></li>
                    <li><a href="#">Decoração</a></li>
                    <li><a href="#">Eletrodomésticos</a></li>
                    <li><a href="#">Eletrônicos</a></li>
                    <li><a href="#">Ferramentas</a></li>
                    <li><a href="#">Informática e Acessórios</a></li>
                    <li><a href="#">Instrumentos Musicais</a></li>
                    <li><a href="#">Jardim e Exterior</a></li>
                    <li><a href="#">Joias e Relógios</a></li>
                    <li><a href="#">Livros e Mídias</a></li>
                    <li><a href="#">Moda Fitness</a></li>
                    <li><a href="#">Papelaria e Escritório</a></li>
                    <li><a href="#">Produtos de Limpeza</a></li>
                    <li><a href="#">Produtos para Casa</a></li>
                    <li><a href="#">Roupas e Acessórios</a></li>
                    <li><a href="#">Saúde e Bem-Estar</a></li>
                    <li><a href="#">Viagem e Lazer</a></li>
                </ul>
            </nav>
        </div>
    </section>

    <div class="topo">
        <h1>Controle de Moderação</h1>
    </div>

    <section>
        <div class="container">
            <h2>Lista de Clientes</h2>
            <div class="table-container">
                <?php
                $conn = new mysqli('localhost', 'root', '06082006Gwas!', 'Teste_Sistema');

                if ($conn->connect_error) {
                    die('Erro de Conexão: ' . $conn->connect_error);
                }

                $sqlClientes = "SELECT id_cliente, nm_cliente, email_cliente, cpf_cliente, endereco_cliente, telefone_cliente, data_cliente FROM cliente";
                $resultClientes = $conn->query($sqlClientes);

                if ($resultClientes->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>Data de Registro</th>
                            </tr>";

                    while ($row = $resultClientes->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_cliente'] . "</td>
                                <td>" . $row['nm_cliente'] . "</td>
                                <td>" . $row['email_cliente'] . "</td>
                                <td>" . $row['cpf_cliente'] . "</td>
                                <td>" . $row['endereco_cliente'] . "</td>
                                <td>" . $row['telefone_cliente'] . "</td>
                                <td>" . $row['data_cliente'] . "</td>
                              </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "Nenhum cliente encontrado.";
                }
                ?>
            </div>

            <h2>Lista de Empresas</h2>
            <div class="table-container">
                <?php
                $sqlEmpresas = "SELECT id_empresa, nm_empresa, cnpj_empresa, endereco_empresa, email_empresa, telefone_empresa, descricao_empresa, contatovirtual_empresa, segmento_empresa FROM empresa";
                $resultEmpresas = $conn->query($sqlEmpresas);

                if ($resultEmpresas->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>Endereço</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Descrição</th>
                                <th>Contato Virtual</th>
                                <th>Segmento</th>
                            </tr>";

                    while ($row = $resultEmpresas->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_empresa'] . "</td>
                                <td>" . $row['nm_empresa'] . "</td>
                                <td>" . $row['cnpj_empresa'] . "</td>
                                <td>" . $row['endereco_empresa'] . "</td>
                                <td>" . $row['email_empresa'] . "</td>
                                <td>" . $row['telefone_empresa'] . "</td>
                                <td>" . $row['descricao_empresa'] . "</td>
                                <td>" . $row['contatovirtual_empresa'] . "</td>
                                <td>" . $row['segmento_empresa'] . "</td>
                              </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "Nenhuma empresa encontrada.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>
</body>
</html>