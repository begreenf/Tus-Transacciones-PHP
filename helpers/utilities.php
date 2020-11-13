<?php


class Utilities
{

    public function getLastElement($list)
    {
        $countList = count($list);
        $lastElement = $list[$countList - 1];
        return $lastElement;
    }



    public function searchProperty($list, $property, $value)
    {

        $filter = [];

        foreach ($list as $item) {

            if ($item->$property == $value) {
                array_push($filter, $item);
            }
        }

        return $filter;
    }

    public function GetCookieTime()
    {
        return time() + 69 * 60 * 24 * 30;
    }

    public function getIndexElement($list, $property, $value)
    {

        $index = 0;

        foreach ($list as $key => $item) {

            if ($item->$property == $value) {
                $index = $key;
            }
        }

        return $index;
    }

    function jsonToCSV($jfilename, $cfilename)
    {
        if (($json = file_get_contents($jfilename)) == false)
            die('Error reading json file...');
        $data = json_decode($json, true);
        $fp = fopen($cfilename, 'w');
        $header = false;
        foreach ($data as $row) {
            if (empty($header)) {
                $header = array_keys($row);
                fputcsv($fp, $header);
                $header = array_flip($header);
            }
            fputcsv($fp, array_merge($header, $row));
        }
        fclose($fp);
        return;
    }
}
