<?php

require_once('api/csv.php');
require_once('api/interactive.php');

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Startseite</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <?php

    $interactive = new Interactive();
    
    // Layout von CSV
    // Programname: Alphabetisch sortiert | Anzeigename soll frei wählbar sein, nicht unbedingt gleich wie im Chip Quelltext
    // Programname soll, falls Plugin, Addon usw. Die Farbe blau erhalten

    // Version Internet: Aktuelle Version aus dem Internet | Ziffern | Punkte | Klammern | Buchstaben

    // Version Lokal: Ziffern | Punkte | Klammern | Buchstaben
    // Version Lokal soll, falls Version Lokal kleiner als Internet, die Farbe orange erhalten

    // How To: Dropdown Menü mit z.B. 7-Zip, SFX, SA, UE

    // Kategorie: Dropdown Menü mit allen Kategorien

    // Stealth: Ist Programm stealth. Boolean Ja/Nein

    // Hinweise: Joa Hinweise...



    // Fragen an Gökhan
    // Kategorie: besser nur Textfeld oder Kategorie per Navigationspunkt hinzufügen?
    // Löschgrund: Warum? Reicht nicht einfach ein Button zum löschen? Wenn gelöscht dann weg
    // HowTo: Das gleiche Prinzip wie bei Kategorie, oder nicht? Textfeld wäre doch besser

    ?>



    <div class="container">

        <div class="header">
            <h1>
                Mertero
            </h1>
            <h2>
                PL-Update
            </h2>
        </div>

        <div class="navigation">
            <ul>
                <li>
                    Aktualisieren
                </li>
                <li>
                    Alle Auswählen
                </li>
                <li>
                    Programm Hinzufügen
                </li>
                <li>
                    Kategorie hinzufügen
                </li>
                <li>
                    HowTo hinzufügen
                </li>
                <li>
                    Entfernen
                </li>
            </ul>
        </div>

        <div class="main">

        <?php
        
        $csv = new CSV();
        $csv->loadCSV();

    

        foreach ($csv->getContent() as $key => $value) {
            $splitted = explode(";",$value[0]);

            echo "<div id='data-" . $splitted[0] . "' class='data'>";
            echo "<div class='databox databox-cb'><input type='checkbox'></div>";
            echo "<div class='databox databox-pn'><p>". $splitted[1] ."</p></div>";
            echo "<div class='databox databox-vi'><p>". $splitted[2] . "</p></div>";
            if($splitted[2] > $splitted[3])
            {
                echo "<div class='databox databox-vd'><p style='color: orange; font-weight: 600;'>". $splitted[3] . "</p></div>";
            } else {
                echo "<div class='databox databox-vd'><p>". $splitted[3] . "</p></div>";
            }
            echo "<div class='databox databox-ht'><p>". $splitted[4] ."</p></div>";
            echo "<div class='databox databox-tt'><p>Tooltip</p></div>";
            echo "<div class='databox databox-kg'>";
                echo "<select id='data-kg-".$splitted[0]."'>";
                    foreach($interactive->loadKategorie() as $key2=>$kategorie)
                    {
                        if($kategorie == $splitted[5])
                        {
                            echo '<option value="'. $kategorie .'" selected="selected">'.$kategorie.'</option>';
                        } else {
                            echo '<option value="'. $kategorie .'">'.$kategorie.'</option>';
                        }
                    }
                echo "</select>";
            echo "</div>";
            echo "<div class='databox databox-bg'><input type='text' placeholder='Bemerkung...' value='".$splitted[7]."'></div>";
            echo "<div class='databox databox-bg'><input type='text' placeholder='Löschgrund...'></div>";
            echo "</div>";
        }
        
        
        ?>
        </div>

    </div>
        
    </body>
</html>