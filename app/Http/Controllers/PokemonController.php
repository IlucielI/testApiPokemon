<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;
use App\Models\myPokemons;

class PokemonController extends Controller
{
    public function index()
    {
        $api = new PokeApi;
        $datas = $api->resourceList('pokemon', '12', '0');
        sleep(0.2);
        $data = json_decode($datas);
        $i = 0;
        foreach ($data->results as $result) {
            $sprites = $api->pokemonForm($result->name);
            sleep(0.2);
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
        $datas = myPokemons::all();
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
}
