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
        <script src ="js/jquery.js"></script>
        <!-- <script src ="js/script.nav.js"></script>-->
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
                <li class='nav-li-update'>
                    Aktualisieren
                </li>
                <li id="markAll" data="0">
                    Alle Auswählen
                </li>
                <li onClick="createWindow()" class='nav-li-remove'>
                    Entfernen
                </li>
            </ul>
        </div>

        <div class='window'></div>

        <div class="main">

        <?php
        
        $csv = new CSV();
        $csv->loadCSV();

    
        $r=0;
        foreach ($csv->getContent() as $key => $value) {
            $r++;
            $splitted = explode(";",$value[0]);

            echo "<div id='data-" . $splitted[0] . "' class='data'>";
            echo "<div class='databox databox-cb'><input type='checkbox' id='m-checkbox-".$splitted[0]."'></div>";
            echo "<div class='databox databox-pn'><input type='text' value='".$splitted[1]."'  class='fieldMid' id='field-pn-".$splitted[0]."'></div>";
            echo "<div class='databox databox-vi'><input type='text' value='".$splitted[2]."'  class='fieldSmall' id='field-vi-".$splitted[0]."'></div>";
            if($splitted[2] > $splitted[3])
            {
                echo "<div class='databox databox-vd'><input type='text' value='".$splitted[3]."' class='fieldSmall' id='field-vd-".$splitted[0]."' style='color: orange; font-weight: 600;'></div>";
            } else {
                echo "<div class='databox databox-vd'><input type='text' value='".$splitted[3]."' id='field-vd-".$splitted[0]."' class='fieldSmall'></div>";
            }
            echo "<div class='databox databox-ht'><input type='text' value='".$splitted[4]."' class='fieldSmall' id='field-ht-".$splitted[0]."'></div>";
            echo "<div class='databox databox-tt'><input type='text' value='Tooltip' class='fieldMid' id='field-tt-".$splitted[0]."'></div>";
            echo "<div class='databox databox-kg'><input type='text' value='".$splitted[5]."' class='fieldMid' id='field-kg-".$splitted[5]."'></div>";
            echo "<div class='databox databox-bg'><input type='text' placeholder='Bemerkung...' value='".$splitted[7]."' id='field-bg-".$splitted[0]."'></div>";
            echo "<div class='databox databox-dl'><input type='text' placeholder='Löschgrund...' id='field-dl-".$splitted[0]."'></div>";
            echo "</div>";
        }
        
        
        ?>
        </div>

    </div>
        

    <script>
        $('.databox-cb input').change(function() {
	        
        });

        $(document).on('click','.nav-li-update',function(){
            var arChecked = [];
	        $('.databox-cb input').each(function(event){
		    if($(this).prop('checked') == true){
                const cbID = $(this).attr('id');
                arChecked.push(cbID);
		    }
	        });
            console.log(arChecked);
            // Daten per POST an php senden, Version aktualisieren und CSV updaten
	        if(arChecked.length == 0) { alert('Vorher ein Programm auswählen!'); }
       });

$(document).on('click','#markAll',function(){
	if($(this).attr('data') == '0'){
		$('.databox-cb').parent().find('input').attr('checked',true);
		$(this).text('Alle Abwählen');
		$(this).attr('data','1');
	} else {
		$('.databox-cb').parent().find('input').attr('checked',false);
		$(this).text('Alle Auswählen');
		$(this).attr('data','0');
	}
});

function createWindow() {
	$('.window').append('<h2>Das ist eine Überschrift</h2>');
	$('.window').append('<p>Sind sie sich sicher?Sind sie sich sicher?Sind sie sich sicher?Sind sie sich sicher?Sind sie sich sicher?</p>');
	$('.window').append('<div class="window-buttons"><button id="window-button-close">Schliessen</button><button id="window-button-create">Erstellen</button></div>');
	$('.window').css('display','block');
}

$(document).on('click','#window-button-close',function(){
	$('.window').empty();
	$('.window').css('display','none');
});
    </script>
    </body>
</html>