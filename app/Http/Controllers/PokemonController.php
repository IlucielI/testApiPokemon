<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;
use App\Models\myPokemons;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PokemonController extends Controller
{
    public function index()
    {
        $api = new PokeApi;
        $datas = $api->resourceList('pokemon', '12', '0');
        $data = json_decode($datas);
        $i = 0;
        foreach ($data->results as $result) {
            $sprites = $api->pokemonForm($result->name);
            $sprite = json_decode($sprites);
            if ($sprite->sprites) {
                $data->results[$i]->sprite = $sprite->sprites->front_default;
            }
            $i++;
        }
        return view('index', compact('data'));
    }

    public function show(Request $request)
    {
        $api = new PokeApi;
        $data = json_decode($api->pokemon($request->name));
        return view('detail', compact('data'));
    }

    public function store(Request $request)
    {
        $request['user_id'] = Auth::user()->id;
        myPokemons::Create($request->except('_token'));
        return redirect('/mypokemon')->with('message', 'Your Pokemon has been Store.');
    }

    public function update(Request $request)
    {
        myPokemons::where('id', $request->id)
            ->update([
                'name' => $request->name,
            ]);
        return redirect('/mypokemon')->with('message', 'Your Pokemon Name has been Update.');
    }

    public function myPokemon()
    {
        $datas = myPokemons::where('user_id', Auth::user()->id)->get();
        return view('myPokemon', compact('datas'));
    }

    public function myPokemonDetailAjax(Request $request)
    {
        $datas = myPokemons::where('id', $request->id)->first();
        echo json_encode($datas);
    }

    public function destroy(Request $request)
    {
        myPokemons::destroy($request->id);
        return redirect('/mypokemon')->with('message', 'Your Pokemon has been Release.');
    }

    public function bayar (Request $request)
    {
        $user = Auth::user();
        $pokemon = myPokemons::where('id', $request->id)->where('user_id', $user->id)->first();
        if (!($pokemon)){
            return redirect('/mypokemon')->with('message', 'Pokemon not found.');
        }
        date_default_timezone_set('Asia/Jakarta');
        $order = Order::where('pokemon_id', $pokemon->id)->where('to_level', '>' ,$pokemon->level)->where(function($query) {
		    $query->where('expired', '>=',  date('Y-m-d H:i:s'))
			        ->orWhere('expired', null);
            })->first();
        if ($order){
            $snapToken = $order->transaction_token;
        }else {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = 'SB-Mid-server-DSSMo0XK3pPQ6EIP3YC-F72C';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $gross_amount = ($pokemon->level * 10000);
            $id = 'pokemon_'.$pokemon->id.$user->name.'_level='.$pokemon->level.'_'.rand();
            $params = array(
                'transaction_details' => array(
                    'order_id' => $id,
                    'gross_amount' => $gross_amount,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'email' => $user->email,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            if($snapToken){
                $order = [
                    'order_id' => $id,
                    'pokemon_id' => $pokemon->id,
                    'user_id' => $user->id,
                    'transaction_token' => $snapToken,
                    'to_level' => $pokemon->level + 1,
                ];
                Order::Create($order);
            }
        }
        return view('bayar', compact('snapToken', 'pokemon'));
    }

    public function notification (Request $request)
    {
        // $payment = json_decode($request->result);
        // Order::where('order_id', $payment->order_id)
        //     ->update([
        //         'transaction_id' => $payment->transaction_id,
        //         'transaction_status' => $payment->transaction_status,
        //         'payment_type' => $payment->payment_type,
        //         'fraud_status' => $payment->fraud_status,
        //         'price' => $payment->gross_amount,
        //         'order_date' => $payment->transaction_time,
        //     ]);
        //  return redirect('/mypokemon')->with('message', 'Your Pokemon has been Leveled.');
        \Midtrans\Config::$isProduction = false;
		\Midtrans\Config::$serverKey = 'SB-Mid-server-DSSMo0XK3pPQ6EIP3YC-F72C';
		$notif = new \Midtrans\Notification();

		$transactionStatus = $notif->transaction_status;
		$paymentType = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraudStatus = $notif->fraud_status;

		$order = Order::where('order_id', $order_id)->first();
        $data["order_date"] = $notif->transaction_time;
		$data["payment_type"] = $paymentType;
        $data["fraud_status"] = $fraudStatus;

        if($paymentType == 'gopay' || $paymentType = 'qris'){
            $data["expired"] = date('Y-m-d H:i:s', strtotime($notif->transaction_time) + (60*15));
        }else{
            $data["expired"] = date('Y-m-d H:i:s', strtotime($notif->transaction_time) + (60*60*24));
        }

		if ($order) {
			if ($transactionStatus == 'capture' && $paymentType == 'credit_card') {
				if ($fraudStatus == 'challenge') {
                    $data["transaction_status"] = 'Challenge by FDS';
                }
				else {
                    $data["price"] = $notif->gross_amount;
					$data["transaction_status"] = 'paid';
                    myPokemons::where('id', $order->pokemon_id)
                        ->update([
                            'level' => $order->to_level
                        ]);
					$data["paid_date"] = now();
				}
			} else if ($transactionStatus == 'settlement') {
                $data["price"] = $notif->gross_amount;
				$data["transaction_status"] = 'paid';
                myPokemons::where('id', $order->pokemon_id)
                        ->update([
                            'level' => $order->to_level
                        ]);
				$data["paid_date"] = $notif->settlement_time;
			} else {
                $data["price"] = $notif->gross_amount;
				$data["transaction_status"] = $transactionStatus;
			}
            Order::where('order_id', $order_id)
            ->update($data);
		}
		return response()->json('ok');
    }
}
