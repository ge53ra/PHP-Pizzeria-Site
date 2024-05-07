<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - Pizzeria Da Gera</title>
    <link rel="stylesheet" href="stileregistrazione.css">
</head>
<body>
    <header>
        <h1>Pizzeria Da Gera</h1>
    </header>
    <main>
        <h2>Registrazione</h2>
        <form action="registrazione.php" method="post">
            Nome: <input type="text" name="nome" required><br>
            Cognome: <input type="text" name="cognome" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" name="submit" value="Registra">
            <p><a href="login.php">Indietro</a></p>
        </form>
    </main>
</body>
</html>

<?php
if(isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connessione al database
    $conn = new mysqli('localhost', 'root', '', 'pizzeriagera');
    if($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Query to select the last ID entry
$query = "SELECT ID_Utente FROM Utente ORDER BY ID_Utente DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['ID_Utente'] + 1;
} else {
    $last_id = 1;
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO Utente (ID_Utente, Nome, Cognome, Email, Password) VALUES(?,?,?,?,?)");
$stmt->bind_param("issss", $last_id, $nome, $cognome, $email, $password);
$stmt->execute();

    if($stmt->affected_rows > 0) {
        echo "Utente registrato con successo!";
        header('Location: login.php');
    } else {
        echo "Errore nella registrazione: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>