<?php
    require_once("sqliteConnector.class.php");

    $bRead = true;
    $bModus = 0; //Modus, 0 = Ausgabe, 1 = Eingabe
    $oDb = new sqliteDb('wawi.sqlite');

    echo "start read at ".date("d.m.Y", time()).PHP_EOL;

    while ($bRead)
    {
        $iEAN = readline("EAN Eingabe: ");
        if (!is_numeric($iEAN)) {
            echo "ean not valid.";
            continue;
        }

        switch ($iEAN)
        {
            case 01:
                $bModus = 1;
                echo "Modus Wareneingabe aktiv".PHP_EOL;
                break;
            case 00:
                $bModus = 0;
                echo "Modus Warenausgabe aktiv".PHP_EOL;
                break;
            default:

                //Lade Produkt von API
                $sXML = file_get_contents('http://api.gvisions.de/barcode/getEAN.php?ean='.$iEAN);
                $oXML = simplexml_load_string($sXML);

                echo "EAN ".$iEAN.' gehoert zu Produkt "'.$oXML->item->name.'"'.PHP_EOL;

                if ($oDb->checkRow('artikel', 'ean', $iEAN) == false)
                {
                    $oDb->insert('artikel', array('ean', 'name', 'angelegt'), array($iEAN, utf8_encode($oXML->item->name), time()));
                    echo 'Datensatz in DB geschrieben.'.PHP_EOL;
                }

                //Schauen ob es schon einen Eintrag in bestand gibt
                if ($oDb->checkRow('bestand', 'ean', $iEAN))
                {
                    $aRes = $oDb->query("SELECT * FROM bestand WHERE ean = $iEAN")->fetchArray();
                    $iAktuell = $aRes['bestand'];

                    if ($bModus == 0)
                    {
                        $iNeuerBestand = $iAktuell - 1;
                        if ($iNeuerBestand <= 0)
                        {
                            echo 'Artikel leer!'.PHP_EOL;
                            $iNeuerBestand = 0;
                        }
                    }
                    else
                    {
                        $iNeuerBestand = $iAktuell + 1;
                    }
                    $oDb->query("UPDATE bestand SET bestand = $iNeuerBestand WHERE ean = $iEAN");
                    echo 'Alter Bestand: '.$iAktuell.PHP_EOL.'Neuer Bestand: '.$iNeuerBestand.PHP_EOL;
                }
                else
                {
                    if ($bModus == 0)
                    {
                        echo "Noch kein Bestand vorhanden, keine Ausgabe möglich...".PHP_EOL;
                    }
                    else
                    {
                        $oDb->insert('bestand', array('ean', 'bestand'), array($iEAN, 1));
                        echo "Artikel der Bestandstabelle hinzugefuegt".PHP_EOL;
                    }
                }

                break;
        }


    }

    echo "end read at ".date("d.m.Y", time()). PHP_EOL."bye...";