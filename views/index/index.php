<!DOCTYPE html>
<html>
<head>
    <title>First page</title>
    <link rel="stylesheet" type="text/css" href="views/css/main.css">
</head>
<body>
<h1 class="naslov">Enter selected date range</h1>

<form method="POST" class="lamal">
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

    <button type="submit" class="majmun">Submit</button>

    <?php view('views/partials/dataDisplay' , [
        'output' => $output
    ]); ?>

</form>

</body>
</html>