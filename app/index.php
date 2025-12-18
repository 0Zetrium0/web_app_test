<?php
// Connexion à la base
$servername = "mysql";
$username = "root";
$password = "docker_test_2025";
$dbname   = "web_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fruit_id = $_POST['fruit_id'];
    $action = $_POST['action'];

    $stmt = $conn->prepare("SELECT stock FROM fruits WHERE id = ?");
    $stmt->bind_param("i", $fruit_id);
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    if ($action === 'increase') {
        $stock += 1;
    } elseif ($action === 'decrease' && $stock > 0) {
        $stock -= 1;
    }

    $stmt = $conn->prepare("UPDATE fruits SET stock = ? WHERE id = ?");
    $stmt->bind_param("ii", $stock, $fruit_id);
    $stmt->execute();
    $stmt->close();

    // Redirection doit être avant tout HTML
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire de Fruits</title>
</head>
<body>
<h1>Inventaire de Fruits</h1>
<?php
// Affichage du stock
$fruit_id = 1;
$stmt = $conn->prepare("SELECT stock FROM fruits WHERE id = ?");
$stmt->bind_param("i", $fruit_id);
$stmt->execute();
$stmt->bind_result($stock);
$stmt->fetch();
$stmt->close();
?>
<div class="fruit">
    <img src="images/pomme.jpg" alt="Pomme">
    <div>Quantité disponible : <span class="quantity"><?php echo $stock; ?></span></div>
    <h2>Pommes en stock: <span id="stock-value"><?php echo $stock; ?></span></h2>

    <form method="POST" action="">
        <input type="hidden" name="fruit_id" value="1">
        <button type="submit" name="action" value="decrease">-</button>
        <button type="submit" name="action" value="increase">+</button>
    </form>
</div>
</body>
</html>
