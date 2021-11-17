@extends('layout/main')

@section('title')
    Detail
@endsection

@section('content')

<div class="card">
    <div class="div d-flex justify-content-center">
        <img src="{{$data->sprites->front_default}}" style="width: 200px" class="card-img-top" alt="..." height="200">
    </div>
  <div class="card-body">
    <h5 class="card-title text-center">{{$data->name}}</h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><h6>Moves :</h6>
    @foreach ($data->moves as $moves)
        {{$moves->move->name}},
    @endforeach
    </li>
    <li class="list-group-item"> <h6>Types :</h6>
    @foreach ($data->types as $types)
        {{$types->type->name}},
    @endforeach
    </li>
    <li class="list-group-item"> <h6>abilities :</h6>
    @foreach ($data->abilities as $abilities)
        {{$abilities->ability->name}},
    @endforeach
    </li>
  </ul>
  <div class="card-body">
      <div class="div d-flex justify-content-center">
        <button type="button" class="btn btn-danger catch" data-img="{{$data->sprites->front_default}}" data-name="{{$data->name}}" data-move="@php $random = array_rand($data->moves,1); echo ($data->moves[$random]->move->name) @endphp" data-type ="@php $random = array_rand($data->types,1); echo ($data->types[$random]->type->name) @endphp">Catch</button>
      </div>
  </div>
</div>

@endsection

@section('script')

@if (Session::has('message'))
<script>
    Swal.fire(
           'Catch Success!',
           'Your Pokemon has been Catch.',
           'success')
</script>
@endif

<script>
  $( ".catch" ).click(function() {
        const probability = Math.round((Math.random()*100));
        if (probability >= 50){
            Swal.fire({
                title: `Succes Catch ${$(this).data('name')} with ${probability}% chance`,
                cancelButtonText: 'Cancel',
                showCancelButton: true,
                html: `<img src="${$(this).data('img')}" style="width: 150px" class="card-img-top" height="150">
                <h4>Special Move : ${$(this).data('move')}</h4>
                <h4>Type : ${$(this).data('type')}</h4>
                <form action="/pokemon" method="POST" id="submit-store">
                    @csrf
                    <label for="nickname" class="form-label mt-3">Pokemon Nickname</label>
                    <input type="text" id="nickname" class="form-control" name="name" value="${$(this).data('name')}">
                    <input type="hidden" name="img" value="${$(this).data('img')}">
                    <input type="hidden" name="move" value="${$(this).data('move')}">
                    <input type="hidden" name="type" value="${$(this).data('type')}">
                </form>`,
                confirmButtonText: 'Store to Inventory',
                }).then((result) => {
                    if (result.value) {
                    event.preventDefault();
                    $('#submit-store').submit();
                    // Swal.fire(
                    //     'Store Success!',
                    //     'Your Pokemon has been Store.',
                    //     'success')
                    } else (
                    result.dismiss === swal.DismissReason.cancel
                    )
            })
        }else{
            Swal.fire(`Catch Failed! your chance is ${probability}%`, 'Pokemon has been Run. Please Try Again', 'error')
        }
});
</script>

@endsection
