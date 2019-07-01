<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Coinmarket\CoinMarketLib;
use Auth;
use  App\Models\User_balance;

use  App\Http\Requests\UserCoin;
use  App\Http\Requests\UserCoinForWeb;
use Cache;

class CoinMarketController extends Controller
{
    
    public function __construct(){
       
    }

    public function deleteUserCoin(){

    }

    public function getUserCoinsForWeb(){
        $coins = $this->userCoins();

        $api_coins = $this->getApiCoinsFromCache();
        
        return View('coins.list', [
            'coins' => $coins,
            'api_coins' => json_decode($api_coins)
        ]);
    }

    public function saveBalanceForWeb(UserCoinForWeb $request){
        $api_coins = json_decode($this->getApiCoinsFromCache());
        foreach($api_coins as $v){
            if($v->id == $request->currency_id){
                $request->merge(['usd_rate'=> $v->usd_rate]);
                $request->merge(['currency_name'=>$v->name]);
            }
        }

        
        $this->saveCoin($request);
        return redirect()->back();
    }

    public function saveUserCoin(UserCoin $request){
      
        $this->saveCoin($request);
        return [
            'success' => true,
        ];
    }

    private function getApiCoinsFromCache(){
        $api_coins = (Cache::store('file')->has("coins_list")) ? Cache::store('file')->get("coins_list") : '[]';
        return $api_coins;
    }
    public function coins(){
        $coins = new CoinMarketLib();
        $data = $coins->cryptocurrency_listings_latest();
        $data = (isset($data->data)) ? $data->data : [];
        $_res = [];
        foreach($data as $k => $v){
            $res[] =[
                "id" => $v->id,
                "name" => $v->name,
                "usd_rate" => $v->quote->USD->price,
            ];
        }
        return $res;
    }

    public function getUserCoins(Request $request){
       return $this->userCoins();
    }

    private function saveCoin($request){

        $res = User_balance::updateOrCreate(['currency_id' => $request->currency_id], [ 
            "user_id" => Auth::user()->id,
            "amount" => $request->amount,
            //"currency_id" => $request->currency_id,
            "currency_name" => $request->currency_name,
            'usd_rate' => $request->usd_rate,
            'amount' => $request->amount,
        ]);

        
        // User_balance::insert([
        //     "user_id" => Auth::user()->id,
        //     "amount" => $request->amount,
        //     "currency_id" => $request->currency_id,
        //     "currency_name" => $request->currency_name,
        //     'usd_rate' => $request->usd_rate,
        //     'amount' => $request->amount,
        // ]);
    }
    private function userCoins(){
        $res =  User_balance::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        return $res;
    }

    
}
