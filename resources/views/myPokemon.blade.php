@extends('layout/main')

@section('title')
    Bayu Anugerah
@endsection

@section('content')
<div class="row">
    <div class="col text-center">
        <h3>My Pokemon List</h3>
    </div>
</div>
<div class="row">
    @foreach ($datas as $data)
    <div class="col mt-2 d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
        <img src="{{$data->img}}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title text-center">{{$data->name}}</h5>
            <button type="button" class="btn btn-info rename" data-toggle="modal" data-target="#modalRename" data-id="{{$data->id}}" data-name="{{$data->name}}" data-img="{{$data->img}}">
            Rename
            </button>
              <button type="button" class="btn btn-primary detail" data-toggle="modal" data-target="#modalDetail" data-id="{{$data->id}}">
                Detail
              </button>
              <button type="button" class="btn btn-danger release" data-id="{{$data->id}}" data-name="{{$data->name}}" data-img="{{$data->img}}" data-move="{{$data->move}}" data-type="{{$data->type}}">Release</button>
          </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <img src="" class="card-img-top" id="modalDetailImage">
            </div>
            <div class="col">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="modalName">

                        </li>
                        <li class="list-group-item" id="modalMove">
                            Move :
                        </li>
                        <li class="list-group-item" id="modalType">
                            Type :
                        </li>
                    </ul>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- rename modal--}}

<div class="modal fade" id="modalRename" tabindex="-1" role="dialog" aria-labelledby="modalRenameTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRenameLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <img src="" class="card-img-top" id="modalRenameImage">
            </div>
            <div class="col">
                <form action="/mypokemon" method="post">
                    @csrf
                    @method('patch')
                    <label for="renameNickname" class="form-label">Rename Nickname</label>
                    <input type="hidden" id="idNickname" name="id">
                    <input type="text" class="form-control" id="renameNickname" name="name">
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" id="change_nickname">Rename With JS</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
@if (Session::has('message'))
<script>
    Swal.fire(
           'Success!',
           '{{ Session::get('message')}}',
           'success')
</script>
@endif


<script>
  $( ".release" ).click(function() {
        const number = Math.round((Math.random()*10));
        const checkPrime = (number) =>{
            let divider = 0;
            for(let i=1;i<=number;i++){
                if (number%i == 0){
                    divider++;
                }
            }
            if (divider == 2){
                return true
            }
            return false
        }
        if (checkPrime(number)){
            Swal.fire({
                title: `<p class="text-danger">Succes Release ${$(this).data('name')} with number ${number}</p>`,
                cancelButtonText: 'Cancel',
                showCancelButton: true,
                html: `<img src="${$(this).data('img')}" style="width: 150px" class="card-img-top" height="150">
                <h4>Special Move : ${$(this).data('move')}</h4>
                <h4>Type : ${$(this).data('type')}</h4>
                <form action="/mypokemon/${$(this).data('id')}" method="POST" id="submit-release">
                    @csrf
                    @method('delete')
                </form>`,
                confirmButtonText: 'Release from Inventory',
                }).then((result) => {
                    if (result.value) {
                    event.preventDefault();
                    $('#submit-release').submit();
                    // Swal.fire(
                    //     'Release Success!',
                    //     'Your Pokemon has been Release.',
                    //     'success')
                    } else (
                    result.dismiss === swal.DismissReason.cancel
                    )
            })
        }else{
            Swal.fire(`Release Failed! your number is ${number}`, 'Pokemon cant Release. Please Try Again', 'error')
        }
});

    $('.detail').click(function(){
        var id = $(this).data('id');
        $.ajax({
				url: "/mypokemonDetailAjax",
				method: "POST",
                data: {
					id: id,
                    _token: "{{ csrf_token() }}",
				},
				dataType: 'json',
				success: function(data) {
					const name = `<p class="text-primary">Name : ${data.name}</p>`;
					$(`#modalName`).html(name);
					const type = `<p class="text-danger">Type : ${data.type}</p>`;
					$(`#modalType`).html(type);
					const move = `<p class="text-warning">Move : ${data.move}</p>`;
					$(`#modalMove`).html(move);
					$(`#modalDetailImage`).attr('src', data.img);
					$(`#modalDetailLongTitle`).html(data.name + "With Ajax");
			}
		});
    });

    $('.rename').click(function(){
        $("#idNickname").val($(this).data('id'));
        $("#renameNickname").val($(this).data('name'));
        $("#modalDetailLongTitle").val('Change Nickname '+ $(this).data('name'));
        $("#modalRenameImage").attr('src',$(this).data('img'));
        $("#change_nickname").attr('data-limit', 0);
        $("#change_nickname").attr('data-oldname', $(this).data('name'));
    });

    $(document).on('click', '#change_nickname', function() {
        let number = document.getElementById('change_nickname').getAttribute('data-limit');
        let name = document.getElementById('change_nickname').getAttribute('data-oldname');
        const fibo = fibonacci(number);
        $(this).attr('data-limit',  ++number);
        name = name+'-'+fibo;
        $("#renameNickname").val(name);
    });

    const fibonacci = (limit) => {
             return limit < 1 ? 0
                    : limit <= 2 ? 1
                    : fibonacci(limit - 1) + fibonacci(limit - 2)
    }
</script>

@endsection

