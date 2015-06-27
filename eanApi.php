<?php

//dom
include "dom.php";

$ean = $argv[1];



$html = file_get_html('http://www.opengtindb.org/index.php?cmd=ean1&ean='.$ean.'&sq=1');

foreach ($html->find('INPUT[name=fullname]') as $e)
{
    $t = trim($e->value);
    if ( empty($t) == false)
    {
        $name = $e->value;
    }

}

if (empty($name)) $name = "Unbekannt";

//insert
echo "<xml>
    <info>created</info>";

echo '<item ean="'.$ean.'">';
echo "	<ean>$ean</ean>";
echo "	<name>$name</name>";
echo "</item>";

echo "</xml>";

}


