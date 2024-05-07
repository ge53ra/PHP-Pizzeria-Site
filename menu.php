<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Menù Pizze</title>
    <link rel="stylesheet" href="stilemenu.css">
    <style>
        .logoContainer{
            height: 3rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    padding: 5px 5px 5px 5px;
    margin-top: 2rem;
}

.logo {
    /* position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%); */
    width: 4rem;
    aspect-ratio: 1 / 1;
    border-radius: 5px;

}
    </style>
    <script>
        function aggiungiPizza(idPizza, prezzo, nomePizza) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'aggiungi_ordine.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                document.getElementById('ordine').innerHTML = this.responseText;
            };
            xhr.send('azione=aggiungi&idPizza=' + idPizza + '&prezzo=' + prezzo + '&nomePizza=' + encodeURIComponent(nomePizza));
        }

        function resetOrdine() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'aggiungi_ordine.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                document.getElementById('ordine').innerHTML = this.responseText;
            };
            xhr.send('azione=reset');
        }

        function inviaOrdine() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'salva_ordine.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                alert('Ordine inviato con successo!');
                document.getElementById('ordine').innerHTML = '';
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <div class="logoContainer">
        <h1>Menù Pizze</h1>
        <img src="logo.png" alt="Logo" class="logo"> 
    </div>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ingredienti</th>
            <th>Prezzo</th>
            <th>Aggiungi</th>
        </tr>
        <?php
        // Connessione al database
        $conn = new mysqli('localhost', 'root', '', 'pizzeriagera');
        if($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Pizza";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["ID_Pizza"]. "</td><td>" . $row["Nome"]. "</td><td>" . $row["Ingredienti"]. "</td><td>€" . $row["Prezzo"]. "</td>";
                echo "<td><button onclick='aggiungiPizza(".$row["ID_Pizza"].",".$row["Prezzo"].",\"".$row["Nome"]."\")'>Aggiungi</button></td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 risultati</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <h2>Il tuo ordine:</h2>
    <div id="ordine">
        <!-- Qui verrà visualizzato l'ordine aggiornato -->
    </div>
<center>
    <button onclick="resetOrdine()">Reset Ordine</button>
    <button onclick="inviaOrdine()">Invia Ordine</button>
</center>
</body>
</html>