<?php

namespace Controllers;

class IndexController
{
    public function index(): void{
        view('views/index/index', [

        ]);
    }

    public function processData(): void{
        if(!validator()){
            return;
        }

        $output = [];
        $startValue = dateCalculator($_POST['start_d']);
        $endValue = dateCalculator($_POST['end_d']);

        foreach ($_POST['mode'] as $value){
            if($value === 'bearishMovement'){
                $data = $this->filterArrayByDate(getSpecifiedData('prices'), $startValue, $endValue);
                $output['longestTrend'] = 'The longest bearish trend lasted ' . findLongestDownwardTrend($data) . ' day(s).';
            }

            else if($value === 'highestTrading'){
                $data = $this->filterArrayByDate(getSpecifiedData('total_volumes'), $startValue, $endValue);
                $dayData = getHighestVolumen($data);
                $output['highestTrading'] = 'The highest trading volume was ' . $dayData['volume'] . ' EUR on ' . $dayData['date'] . '.';
            }

            else if($value === 'greatDeal'){
                $data = $this->filterArrayByDate(getSpecifiedData('prices'), $startValue, $endValue);
                $bestBuySellDays = findTheBestDaysToBuySell($data);
                $output['greatDeal'] = 'The best day for buying was on ' . $bestBuySellDays['buy']['date'] . ' when price was ' .
                    $bestBuySellDays['buy']['price'] . ' EUR. The best day for selling was on ' . $bestBuySellDays['sell']['date'] .
                    ' when price was ' . $bestBuySellDays['sell']['price'] . ' EUR.';
            }
        }

        view('view/index/index', [
            'output' => $output
        ]);
    }

    private function filterArrayByDate(array $arrayToFilter, float $startValue, float $endValue): array{
        $data = [];
        for ($i = $startValue; $i <= $endValue; $i++) {
            $data[sizeof($data)] = $arrayToFilter[$i];
        }
        return $data;
    }
}