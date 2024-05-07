<?php
session_start();

// Verifica se l'ordine esiste e contiene elementi
if(isset($_SESSION['ordine']) && count($_SESSION['ordine']) > 0) {
    $conn = new mysqli('localhost', 'root', '', 'pizzeriagera');

    // Controlla la connessione
    if($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Inizia la transazione
    $conn->begin_transaction();

    try {
        // Inserisci l'ordine nel database
        $stmt = $conn->prepare("INSERT INTO Ordine (Data, Totale, ID_Utente) VALUES (CURDATE(), ?, ?)");
        $stmt->bind_param("di", $_SESSION['totale'], $_SESSION['ID_Utente']);
        $stmt->execute();
        $idOrdine = $conn->insert_id;

        // Inserisci i dettagli dell'ordine
        foreach($_SESSION['ordine'] as $idPizza => $dettagli) {
            $stmt = $conn->prepare("INSERT INTO Ordine_Pizza (ID_Ordine, ID_Pizza) VALUES (?, ?)");
            for($i = 0; $i < $dettagli['quantita']; $i++) {
                $stmt->bind_param("ii", $idOrdine, $idPizza);
                $stmt->execute();
            }
        }

        // Commit della transazione
        $conn->commit();
        echo "Ordine salvato con successo.";

        // Reset dell'ordine dopo il salvataggio
        $_SESSION['ordine'] = array();
        $_SESSION['totale'] = 0;

    } catch(Exception $e) {
        // Rollback in caso di errore
        $conn->rollback();
        echo "Errore: " . $e->getMessage();
    }

    // Chiudi la connessione
    $conn->close();
} else {
    echo "Nessun ordine da salvare.";
}
?>