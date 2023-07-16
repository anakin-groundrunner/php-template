<?php
// $con = include_once 'conf.php';
global $con;
echo '<h2>Straßenname ändern</h2>';
/* Straßennamen erfasse, Ort und PLZ aus Liste auswählen */
/* Sowohl das Formular als auch die Datenverarbeitung werden auf dieser Seite behandelt */

if (isset($_POST['change'])) {
    // Daten speichern
    $strid = $_POST['strid'];
    $strasse = $_POST['strasse'];
    $updateStmt = 'update strasse set str_name = "'.$strasse.'" where str_id = '.$strid;
    try {
        // 1. Strasse speichern
        /* $stmt = $con->prepare($insertStmt1);
        $stmt->execute([$strasse]);

        $strid = $con->lastInsertId(); */
        $array = array($strasse, $strid);
        $stmt = $con->prepare($updateStmt);
        $stmt->execute();
        // $stmt = makeStatement($updateStmt, [$strasse, $strid]);
        $strid = $con->lastInsertId();

        echo '<h3>Straßename wurde geändert!</h3>';
    }
    catch (Exception $e) {
        echo 'Error - Strasse: '.$e->getCode().': '.$e->getMessage().'<br>';
    }
} else {
    // Formular anzeigen
    ?>
    <form method="post">
    <label for="strasse">Alter Straßenname: </label>
        <!-- to do: select-option -->
        <?php
        $query = 'select str_id, str_name from strasse';
        $stmt = $con->prepare($query);
        $stmt->execute();
        echo '<select name="strid">';
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo '<option value="'.$row[0].'">'.$row[1];
        }
        echo '</select><br>';
        ?>
        <label for="strasse">Neuer Straßenname: </label>
        <input type="text" id="strasse" name="strasse" placeholder="z.B. Wiener Straße">
        <input type="submit" name="change" value="speichern">
    </form>
    <?php
}