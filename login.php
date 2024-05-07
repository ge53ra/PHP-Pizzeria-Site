<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login - Pizzeria Da Gera</title>
    <link rel="stylesheet" href="stilelogin.css">
</head>
<body>
    <header>
        <h1>Pizzeria Da Gera</h1>
    </header>
    <main>
        <h2>Login</h2>
        <form action="login.php" method="post">
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" name="submit" value="Login">
        </form>
        <p>Non hai un account? <a href="registrazione.php">Registrati</a></p>
        <?php
        if(isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Connessione al database
            $conn = new mysqli('localhost', 'root', '', 'pizzeriagera');
    if($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
            $sql = "SELECT * FROM Utente WHERE Email = ? AND Password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                
                $user = $result->fetch_assoc();
                if($user['Email'] == 'admin@admin' && $user['Password'] == 'Gera532005') {
                    header('Location: insert_pizza.php'); // Admin
                } else {
                    header('Location: menu.php');
                }
            } else {
                echo "<p>Credenziali non valide. Per favore, prova di nuovo o <a href='registrazione.php'>registrati</a>.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </main>
</body>
</html>