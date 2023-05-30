<?php
const BASE_PATH = __DIR__ . '/';

/**
 * function for easier requiring off files
 *
 * @param string $path
 * @param array $attributes
 * @return void
 */
function view(string $path, array $attributes = []): void
{
    extract($attributes);

    require_once BASE_PATH . $path . '.php';
}

/**
 * function for finding the longest downward trend
 *
 * @param array $data
 * @return int
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

/**
 * function for finding the best day to buy and sell crypto
 *
 * @param array $priceData
 * @return array
 */
function findTheBestDaysToBuySell(array $priceData): array
{
    $highestPrice = ['price' => round($priceData[0][1], 2), 'date' => date("d-m-Y", $priceData[0][0] / 1000)];
    $lowestPrice = ['price' => round($priceData[0][1], 2), 'date' => date("d-m-Y", $priceData[0][0] / 1000)];

    foreach ($priceData as $dayData) {
        $currentPrice = round($dayData[1], 2);

        if ($currentPrice > $highestPrice['price']) {
            $highestPrice['date'] = date("d-m-Y", $dayData[0] / 1000);
            $highestPrice['price'] = $currentPrice;
        } else if ($currentPrice < $lowestPrice['price']) {
            $lowestPrice['date'] = date("d-m-Y", $dayData[0] / 1000);
            $lowestPrice['price'] = $currentPrice;
        }
    }

    return ['buy' => $lowestPrice, 'sell' => $highestPrice];
}


/**
 * function for finding the highest volume
 *
 * @param array $tradingVolume
 * @return array
 */
function getHighestVolumen(array $tradingVolume): array
{
    $highestVolume = 0;
    foreach ($tradingVolume as $dayData) {
        if ($dayData[1] > $highestVolume) {
            $highestVolume = $dayData[1];
            $date = date("d-m-Y", $dayData[0] / 1000);
        }
    }
    return ["date" => $date, "volume" => $highestVolume];
}