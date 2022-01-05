<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function finish(Request $request)
    {
        if($request->transaction_status == 'pending'){
            return redirect('/mypokemon')->with('message', 'Your Transaction '. $request->transaction_status .'. Please Complete Your Payment...' );
        }
        return redirect('/mypokemon')->with('message', 'Your Transaction '. $request->transaction_status .' Thanks For Your Payment' );
    }

    public function unfinish(Request $request)
    {
        return redirect('/mypokemon')->with('message', 'Your Transaction '. $request->transaction_status .', please pay the bill' );
    }

    public function error(Request $request)
    {
        return redirect('/mypokemon')->with('message', 'Sorry, Your Transaction '. $request->transaction_status);
    }
}
