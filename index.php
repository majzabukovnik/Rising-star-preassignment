<?php
require_once __DIR__ . '/functions.php';

if (isset($_POST['start_d']) && validator()) {
    $output = [];
    $startValue = dateCalculator($_POST['start_d']);
    $endValue = dateCalculator($_POST['end_d']);

    foreach ($_POST['mode'] as $value){
        if($value === 'bearishMovement'){
            $priceData = getSpecifiedData('prices');
            $data = [];
            for ($i = $startValue; $i <= $endValue; $i++) {
                $data[sizeof($data)] = $priceData[$i];
            }
            $output['longestTrend'] = 'The longest bearish trend lasted ' . findLongestDownwardTrend($data) . ' day(s).';
        }

        else if($value === 'highestTrading'){
            $volumenData = getSpecifiedData('total_volumes');
            $dayData = getHighestVolumen($volumenData);
            $output['highestTrading'] = 'The highest trading volume was ' . $dayData['volume'] . ' on ' . $dayData['date'] . '.';
        }

        else if($value === 'greatDeal'){
            $priceData = getSpecifiedData('prices');
            $output['greatDeal'] = findTheBestDaysToBuySell($priceData);
        }
    }
} ?>

<!DOCTYPE html>
<html>
<head>
    <title>First page</title>
    <link rel="stylesheet" type="text/css" href="views/css/main.css">
</head>
<body>
<h1>Enter selected date range</h1>

<form method="POST">
    <label for="start_d">Enter the beginning date</label><br>
    <input type="date" name="start_d" min="2020-01-01" max="2020-12-31"><br><br>

    <label for="end_d">Enter the ending date</label><br>
    <input type="date" name="end_d" min="2020-01-01" max="2020-12-31"><br><br>

    <input type="checkbox" id="bearishMovement" name="mode[]" value="bearishMovement">
    <label for="vehicle1">Get bearish movement</label><br>
    <input type="checkbox" id="highestTrading" name="mode[]" value="highestTrading">
    <label for="vehicle2">Get highest trading volumen</label><br>
    <input type="checkbox" id="greatDeal" name="mode[]" value="greatDeal">
    <label for="vehicle3">Get the best days to buy and sell</label><br><br>

    <button type="submit">Submit</button>
</form>
<?php require_once __DIR__ . '/views/partials/dataDisplay.php'; ?>
</body>
</html>