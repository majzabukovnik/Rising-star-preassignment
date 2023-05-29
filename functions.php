<?php
/**
 * function for finding the longest downward trend
 *
 * @param $data
 * @return array
 */
function findLongestDownwardTrend(array $data): int
{
    $trendLength = 0;
    $maxTrendLength = 0;

    for ($i = 1; $i < count($data); $i++) {
        if ($data[$i][1] < $data[$i - 1][1]) {
            $trendLength++;

            if ($trendLength > $maxTrendLength) {
                $maxTrendLength = $trendLength;
            }
        } else {
            $trendLength = 0;
        }
    }

    return $maxTrendLength;
}

/**
 * function for getting filtered data from api
 *
 * @param string $mode
 * @param string $coin
 * @param string $fiat
 * @param string $start
 * @param string $end
 * @return array
 */
function getSpecifiedData(string $mode, string $coin = 'bitcoin', string $fiat = 'eur', string $start = '1577836800', string $end = '1609376400'): array
{
    $api_url = 'https://api.coingecko.com/api/v3/coins/' . $coin . '/market_chart/range?vs_currency=' . $fiat . '&from=' . $start . '&to=' . $end;
    $rawData = file_get_contents($api_url);
    return json_decode($rawData, true)[$mode];
}

/**
 * function for validating user input
 *
 * @return bool
 */
function validator(): bool
{
    $start_timestamp = strtotime($_POST['start_d']);
    $end_timestamp = strtotime($_POST['end_d']);
    $start_boundary = strtotime('2020-01-01');
    $end_boundary = strtotime('2020-12-31');

    if ($start_timestamp > $end_timestamp) {
        return false;
    } else if ($start_timestamp < $start_boundary || $end_timestamp > $end_boundary) {
        return false;
    }
    return true;
}

/**
 * function for returning numeric difference in days
 *
 * @param string $date
 * @return float
 */
function dateCalculator(string $date): float
{
    $unixDate = strtotime($date);
    return ($unixDate - strtotime('2020-1-1')) / 86400;
}
function findTheBestDaysToBuySell(array $priceData): array{

    return [];
}

function getHighestVolumen(array $tradingVolume): array
{
   $highestvolume = 0;
   foreach ($tradingVolume as $daydata){
    if($daydata[1] > $highestvolume ){
        $highestvolume = $daydata[1];
        $date = date("Y-m-d", strtotime("@". $daydata [0]));
    }
   }
   return ["date" => $date, "volume" => $highestvolume ];
}
