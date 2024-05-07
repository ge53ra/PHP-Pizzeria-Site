<?php
session_start();

// Inizializza l'ordine se non esiste
if(!isset($_SESSION['ordine'])) {
    $_SESSION['ordine'] = array();
    $_SESSION['totale'] = 0;
}

// Gestisci azioni di aggiunta o reset
if(isset($_POST['azione'])) {
    if($_POST['azione'] == 'aggiungi' && isset($_POST['idPizza']) && isset($_POST['prezzo']) && isset($_POST['nomePizza'])) {
        // Aggiungi pizza all'ordine
        $idPizza = $_POST['idPizza'];
        $prezzo = $_POST['prezzo'];
        $nomePizza = $_POST['nomePizza'];

        if(!isset($_SESSION['ordine'][$idPizza])) {
            $_SESSION['ordine'][$idPizza] = array('quantita' => 1, 'nome' => $nomePizza, 'prezzo' => $prezzo);
        } else {
            $_SESSION['ordine'][$idPizza]['quantita']++;
        }
        $_SESSION['totale'] += $prezzo;
    } elseif ($_POST['azione'] == 'reset') {
        // Reset dell'ordine
        $_SESSION['ordine'] = array();
        $_SESSION['totale'] = 0;
    }

    // Visualizza l'ordine aggiornato
    foreach($_SESSION['ordine'] as $id => $dettagli) {
        echo "Pizza: " . $dettagli['nome'] . " - Quantità: " . $dettagli['quantita'] . " - Prezzo: €" . number_format($dettagli['prezzo'], 2) . "<br>";
    }
    echo "<strong>Totale: €" . number_format($_SESSION['totale'], 2) . "</strong>";
}
?>