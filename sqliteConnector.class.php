<?php

class sqliteDb extends SQLite3
{
    public function insert($sTable, $aCols, $aValues)
    {
        $oResult = $this->query('SELECT MAX(id) as id FROM '.$sTable);
        $aResult = $oResult->fetchArray();
        $neueId = $aResult['id'] + 1;

        $sSQL = 'INSERT INTO '.$sTable.' (id, '.implode(',', $aCols).') VALUES ('.$neueId.', \''.implode('\',\'', $aValues).'\')';
        $this->exec($sSQL);
        return $this->lastInsertRowID();
    }

    public function checkRow($sTable, $sCol, $sSearch)
    {
        $oResult = $this->query('SELECT COUNT(*) as cnt FROM '.$sTable.' WHERE '.$sCol.' = \''.$sSearch.'\'');
        $aResult = $oResult->fetchArray();
        if ($aResult["cnt"] == 0)
        {
            return false;
        }
        return true;
    }

    public function get($sSQL)
    {
        $oResult = $this->query($sSQL);
        $aReturn = array();
        while ($aRow = $oResult->fetchArray())
        {
            $aReturn[] = $aRow;
        }
        return $aReturn;
    }

}