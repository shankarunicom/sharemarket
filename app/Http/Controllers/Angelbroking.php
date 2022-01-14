<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use AngelBroking\SmartApi;

use Session;


class Angelbroking extends Controller
{
    function __construct()
    {

    }

    public function index()
    {
        $smart_api  = new SmartApi('rY6jDt1c','768f35f9-547b-4aef-93be-1a0ea82a9417');
        //Login
        $demo = $smart_api ->GenerateSession("S1102836","Sandeep@123");

        //methods
        $token = $smart_api ->GenerateToken(); 

        $profile = $smart_api ->GetProfile();

        // $smart_api ->LogOut(array('clientcode'=>'your client-code'));

        $rms = $smart_api ->GetRMS();
        // dd($rms);

        // $order = $smart_api ->PlaceOrder(array('variety' => 'NORMAL',
        //                             'tradingsymbol'  =>  'JINDALSTEL-EQ',
        //                             'symboltoken' => '6733',
        //                             'exchange' => 'NSE',
        //                             'transactiontype' => 'SELL',
        //                             'ordertype' => 'LIMIT',
        //                             'quantity' => '1',
        //                             'producttype' => 'INTRADAY',
        //                             'price' => 312.65,
        //                             'squareoff' => 0,
        //                             'stoploss' => 0,
        //                             'duration' => 'DAY'));
                                    
        // $modifyOrder = $smart_api ->ModifyOrder(array('variety' => 'NORMAL',
        //                             'tradingsymbol'  =>  'JINDALSTEL-EQ',
        //                             'symboltoken' => '6733',
        //                             'exchange' => 'NSE',
        //                             'transactiontype' => 'BUY',
        //                             'ordertype' => 'LIMIT',
        //                             'quantity' => '1',
        //                             'producttype' => 'INTRADAY',
        //                             'price' => 200,
        //                             'squareoff' => 0,
        //                             'stoploss' => 0,
        //                             'duration' => 'DAY',
        //                             'orderid' =>210312000000394));

        // $cancelOrder = $smart_api ->CancelOrder(array('variety' => 'NORMAL',
        //                             'orderid' => '210312000000394'));
                                    
        // $GetOrderBook = $smart_api ->GetOrderBook();

        // $GetTradeBook = $smart_api ->GetTradeBook();

        // $GetHoldings =  $smart_api ->GetHoldings();

        // $GetPosition  = $smart_api ->GetPosition();

        // $ConvertPosition  = $smart_api ->ConvertPosition(array("exchange"=>"NSE",
        //                                         "oldproducttype"=>"INTRADAY",
        //                                         "newproducttype"=>"MARGIN",
        //                                         "tradingsymbol"=>"JINDALSTEL-EQ",
        //                                         "transactiontype"=>"SELL",
        //                                         "quantity"=>"1",
        //                                         "type"=>"DAY"));
                                                
        // $CreateRule  = $smart_api ->CreateRule(array("tradingsymbol" => "SBIN-EQ", 
        //                             "symboltoken" => "3045", 
        //                             "exchange" => "NSE", 
        //                             "producttype" => "MARGIN", 
        //                             "transactiontype" => "BUY",
        //                             "price" => 100000, 
        //                             "qty" => 10, 
        //                             "disclosedqty"=> 10, 
        //                             "triggerprice" => 200000,
        //                             "timeperiod" => 365));
                                    
        // $ModifyRule  = $smart_api ->ModifyRule(array('id' => '1000059',
        //                             "tradingsymbol" => "SBIN-EQ", 
        //                             "symboltoken" => "3045", 
        //                             "exchange" => "NSE", 
        //                             "producttype" => "MARGIN", 
        //                             "transactiontype" => "BUY",
        //                             "price" => 100000, 
        //                             "qty" => 20, 
        //                             "disclosedqty"=> 10, 
        //                             "triggerprice" => 200000,
        //                             "timeperiod" => 365));
                                    
        // $CancelRule = $smart_api ->CancelRule(array('symboltoken'  => '3045',
        //                             'exchange'   =>   'NSE',
        //                             'id'  => '1000059'));
                                    
        // $RuleDetails = $smart_api ->RuleDetails(array('id'=>'1000059'));

        // $RuleList = $smart_api ->RuleList(array( "status"=> [
        //                             "NEW",
        //                             "CANCELLED",
        //                             "ACTIVE",
        //                             "SENTTOEXCHANGE",
        //                             "FORALL"
        //                         ],
        //                         "page"=> 1,
        //                         "count"=> 10));
                             
        $res = '<style>table, th, td {
            border: 1px solid black;
          }</style>
        <table>
        <thead>
        <tr><th>Name</th><th>Time</th><th>Open</th><th>Hight</th><th>Low</th><th>Close</th><th>Volume</th></tr>
        </thead>';
        $GetCandleData = $smart_api ->GetCandleData(array("exchange"=> "NSE",
                                            "symboltoken"=> "12825",
                                            "interval"=> "ONE_DAY",
                                            "fromdate"=> "2022-01-06 09:00",
                                            "todate"=> "2022-01-07 15:30"));
        $GetCandleData = json_decode($GetCandleData, true);
        $GetCandleData = $GetCandleData['response_data']['data'][0];
        
        $res .= '<tr>
            <td>TCS</td>';
            foreach ($GetCandleData as $key => $value) {
                $res .= '<td>'. $value .'</td>';
            }
        $res .'</tr>';

        $GetCandleData = $smart_api ->GetCandleData(array("exchange"=> "NSE",
                                            "symboltoken"=> "3456",
                                            "interval"=> "ONE_DAY",
                                            "fromdate"=> "2022-01-06 09:00",
                                            "todate"=> "2022-01-07 15:30"));

        $GetCandleData = json_decode($GetCandleData, true);
        $GetCandleData = $GetCandleData['response_data']['data'][0];
        $res .= '<tr>
            <td>Tata Motars</td>';
            foreach ($GetCandleData as $key => $value) {
                $res .= '<td>'. $value .'</td>';
            }
        $res .'</tr>';
        $GetCandleData = $smart_api ->GetCandleData(array("exchange"=> "NSE",
                                            "symboltoken"=> "3405",
                                            "interval"=> "ONE_DAY",
                                            "fromdate"=> "2022-01-06 09:00",
                                            "todate"=> "2022-01-07 15:30"));

        $GetCandleData = json_decode($GetCandleData, true);
        $GetCandleData = $GetCandleData['response_data']['data'][0];
        $res .= '<tr>
            <td>Tata Chemical</td>';
            foreach ($GetCandleData as $key => $value) {
                $res .= '<td>'. $value .'</td>';
            }
        $res .'</tr>';
        $GetCandleData = $smart_api ->GetCandleData(array("exchange"=> "NSE",
                                            "symboltoken"=> "4503",
                                            "interval"=> "ONE_DAY",
                                            "fromdate"=> "2022-01-06 09:00",
                                            "todate"=> "2022-01-07 15:30"));
        $GetCandleData = json_decode($GetCandleData, true);
        $GetCandleData = isset($GetCandleData['response_data']['data'][0]) ? $GetCandleData['response_data']['data'][0] : '';
        if($GetCandleData){
            $res .= '<tr>
                <td>Tata Mphasis</td>';
                foreach ($GetCandleData as $key => $value) {
                    $res .= '<td>'. $value .'</td>';
                }
            $res .'</tr>';
        }

        
        $res .'<tbody>
        </tbody>
        </table>';

        echo $res;
                        
        // $GetLtpData = $smart_api ->GetLtpData(array('exchange'  => 'NSE',
        // 'tradingsymbol'   =>   'RELIANCE-EQ' ,
        // 'symboltoken'  => '3045'));

        // $GetLtpData  = file_get_contents('https://margincalculator.angelbroking.com/OpenAPI_File/files/OpenAPIScripMaster.json');
        // print_r(json_decode($GetLtpData, true));

        // $GetLtpData = $smart_api ->GetLtpData();

        // $GetCandleData = json_decode($GetLtpData, true);
        // print_r($GetCandleData);

        // cipla, tcs, tatamotors, tata chamical, mphasis, ongc
    }
}