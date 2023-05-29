<?php
require_once __DIR__ . '/functions.php';

if (isset($_POST['start_d']) && validator()) {
    $startValue = dateCalculator($_POST['start_d']);
    $endValue = dateCalculator($_POST['end_d']);

    if(isset($_POST['mode']) && $_POST['mode'] === 'bearishMovement'){
        $priceData = getSpecifiedData('prices');
        $data = [];
        for ($i = $startValue; $i <= $endValue; $i++) {
            $data[sizeof($data)] = $priceData[$i];
        }

        $longestTrend = findLongestDownwardTrend($data);
    }
    else if (isset($_POST['mode']) && $_POST['mode'] === 'highestTrading'){
        $volumenData = getSpecifiedData('total_volumes');
        getHighestVolumen($volumenData);
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>First page</title>
</head>
<body>
<h1>Enter selected date range</h1>

<form method="POST">
    <label for="start_d">Enter the beginning date</label><br>
    <input type="date" name="start_d" min="2020-01-01" max="2020-12-31"><br><br>

    <label for="end_d">Enter the ending date</label><br>
    <input type="date" name="end_d" min="2020-01-01" max="2020-12-31"><br><br>

    <input type="checkbox" id="bearishMovement" name="mode" value="bearishMovement">
    <label for="vehicle1">Get bearish movement</label><br>
    <input type="checkbox" id="highestTrading" name="mode" value="highestTrading">
    <label for="vehicle2">Get highest trading volumen</label><br>
    <input type="checkbox" id="greatDeal" name="mode" value="greatDeal">
    <label for="vehicle3">Get the best days to buy and sell</label><br>

    <button type="submit">Submit</button>
</form>
<?php
echo '<p>The longest bearish movement within selected range was ' . $longestTrend . ' day(s)</p>'
?>
</body>
</html>