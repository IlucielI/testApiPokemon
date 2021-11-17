@php
use PokePHP\PokeApi;
$api = new PokeApi;
@endphp

@extends('layout/main')

@section('title')
    Bayu Anugerah
@endsection

@section('content')

<div class="row">
    @foreach ($data->results as $result)
            {{-- @php
             $sprite = json_decode($api->pokemonForm($result->name));
            @endphp --}}
    <div class="col mt-2 d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
        <a href="/pokemon/{{$result->name}}"><img src="{{$result->sprite}}" class="card-img-top" alt="..."></a>
          <div class="card-body">
            <h5 class="card-title text-center">{{$result->name}}</h5>
            <a href="/pokemon/{{$result->name}}">
              <button type="button" class="btn btn-info">Detail</button>
            </a>
          </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
