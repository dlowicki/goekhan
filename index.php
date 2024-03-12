<?php

require_once('api/csv.php');
require_once('api/interactive.php');
require_once('api/updater.php');
require_once('api/log.php');

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>PL-Update</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src ="js/jquery.js"></script>
        <!-- <script src ="js/script.nav.js"></script>-->
    </head>
    <body>

    <?php

    $interactive = new Interactive();
    $log = new Log();
    
    $log->checkLogExist();

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
                <li onClick="addProgramm()" class='nav-li-add'>
                    Hinzufügen
                </li>
                <li onClick="removeProgramm()" class='nav-li-remove'>
                    Entfernen
                </li>
            </ul>
            <div class="lastupdate">
                <h2 style="display:block; float:right; margin-right: 5%; color:white; font-size: 1rem;"></h2>
            </div>
        </div>

        <div class='window'></div>

        <div class="main">

        <div class="data">
            <div class="databox databox-cb"><input type="checkbox" id="markAll" data="0"></div>
            <div class="databox databox-pn"><h3>Program</h3></div>
            <div class="databox databox-vi"><h3>VI</h3></div>
            <div class="databox databox-vd"><h3>VD</h3></div>
            <div class="databox databox-ht"><h3>Exe.</h3></div>
            <div class="databox databox-tt"><h3>ToolTip</h3></div>
            <div class="databox databox-kg"><h3>Platzhalter</h3></div>
            <div class="databox databox-bg"><h3>Bemerkung</h3></div>
            <div class="databox databox-dl"><h3>Löschgrund</h3></div>
        </div>

        <?php
        
        $csv = new CSV();
        
        $csv->loadCSV();

        //$csv->updateVersionCSV(1,"21.10");

        //$updater = new Updater();
        //$updatedVersions = $updater->getAllVersions();

        // Wenn auf aktualisieren klicken dann Daten von Chip.de ziehen
        // Gezogene Daten im Browser als localStorage speichern

        // CSV
        // 0 = ID | 1 = Name | 2 = VersionInternet | 3 = VersionDatabase | 4 = Ausführen mit | 5 = ToolTip | 6 = 
        $r=0;
        foreach ($csv->getContent() as $key => $value) {
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
                echo "<div class='databox databox-tt'><input type='text' value='".$splitted[5]."' class='fieldMid' id='field-tt-".$splitted[0]."'></div>";
                echo "<div class='databox databox-kg'><input type='text' value='".$splitted[6]."' class='fieldMid' id='field-kg-".$splitted[0]."'></div>";
                echo "<div class='databox databox-bg'><input type='text' placeholder='Bemerkung...' value='".$splitted[7]."' id='field-bg-".$splitted[0]."'></div>";
                echo "<div class='databox databox-dl'><input type='text' placeholder='Löschgrund...' id='field-dl-".$splitted[0]."'></div>";
                echo "</div>";
                $r++;
        }
        
        
        ?>
        </div>

    </div>
        

    <script>
        $.get( "api/lastupdate.php?display=true", function( data ) {
            $('.lastupdate h2').text(data);    
        });


        $(document).on('change','.databox-cb input',function(event){
            event.preventDefault();
            if(document.getElementById(event.target.id).checked == true){
                $('#'+event.target.id).attr('checked',true);
            } else {
                $('#'+event.target.id).attr('checked',false);
            }
        });

        $(document).on('click','.nav-li-update',function(){
            var arChecked = getCheckedProgramms();
            // Daten per POST an php senden, Version aktualisieren und CSV updaten
	        if(arChecked.length == 0) { alert('Vorher ein Programm auswählen!'); } else {
                var data = '';
                arChecked.forEach(element => {
                    data = data + element.split('-')[2] + ';';
                });

                console.log('[INDEX] Data prepared');
                
                $.ajax({
                    url: "api/validate.php",
                    type: "post",
                    data: {update: data},
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }


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

        function removeProgramm() {
            var arChecked = getCheckedProgramms();
            if(arChecked.length == 0) { alert('Vorher ein Programm auswählen!'); } else {
                var data = '';
                arChecked.forEach(element => {
                    data = data + element.split('-')[2] + ';';
                });

                console.log('[INDEX] Data prepared for removing');
                
                $.ajax({
                    url: "api/validate.php",
                    type: "post",
                    data: {remove: data},
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        }

        function addProgramm() {
            $('.window').append('<h2>CHIP-URL hinzufügen</h2>');
            $('.window').append('<input type="text" placeholder="URL..." id="field-url-add">');
            $('.window').append('<div class="window-buttons"><button id="window-button-close">Schliessen</button><button id="window-button-create">Erstellen</button></div>');
            $('.window').css('display','block');
        }

        $(document).on('click','#window-button-close',function(){
            $('.window').empty();
            $('.window').css('display','none');
        });

        $(document).on('click','#window-button-create',function(){
            $('.window').empty();
            $('.window').css('display','none');
        });




        $(document).on('focusout','.databox input[type=text]',function(){
            const textfield = $(this).val();
            var id = $(this).attr('id');

            $.ajax({
                url: "api/validate.php",
                type: "post",
                data: {focus: textfield.length+';'+textfield+';'+id},
                success: function (response) {
                    console.log(response);
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });


        });



        function getCheckedProgramms(){
            var arChecked = [];
	        $('.databox-cb input').each(function(event){
                if($(this).prop('checked') == true && $(this).attr('id') != "markAll"){
                    const cbID = $(this).attr('id');
                    arChecked.push(cbID);
                }
	        });
            return arChecked;
        }


    </script>
    </body>
</html>