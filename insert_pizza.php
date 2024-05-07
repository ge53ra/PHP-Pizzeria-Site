<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserisci Pizza</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #c0392b;
}

form {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

input[type="number"],
input[type="text"],
input[type="double"],
input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #c0392b;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #c0392b;
    color: #ffffff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #a93226;
}

</style>
</head>
<body>
    <h1>Inserisci una nuova Pizza</h1>
    <form action="insert_pizza.php" method="post">
        ID Pizza: <input type="number" name="id_pizza" required><br>
        Nome: <input type="text" name="nome" required><br>
        Ingredienti: <input type="text" name="ingredienti" required><br>
        Prezzo: <input type="double" name="prezzo" required><br>
        <input type="submit" name="submit" value="Inserisci Pizza">
        <p><a href="login.php">Indietro</a></p>
    </form>
</body>
</html>

<?php
if(isset($_POST['submit'])) {
    $idPizza = $_POST['id_pizza'];
    $nome = $_POST['nome'];
    $ingredienti = $_POST['ingredienti'];
    $prezzo = $_POST['prezzo'];

    // Connessione al database
    $conn = new mysqli('localhost', 'root', '', 'pizzeriagera');
    if($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Pizza (ID_Pizza, Nome, Ingredienti, Prezzo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $idPizza, $nome, $ingredienti, $prezzo);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        echo "Pizza inserita con successo!";
    } else {
        echo "Errore nell'inserimento: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>