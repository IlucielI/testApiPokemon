@extends('layout/main')


@section('title')
    Pokemon Payment
@endsection


@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col text-center d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{$pokemon->img}}" alt="Card image cap">
                <div class="card-body">
                    <h6 class="card-title">{{$pokemon->name}}</h6>
                    <h5 class="card-title">Upgrade Pokemmon Level</h5>
                    <h5 class="card-title text-danger">{{$pokemon->level}} >> {{$pokemon->level + 1}}</h5>
                    <button id="pay-button" class="btn btn-primary" data-token="{{$snapToken}}">Pay Now!</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
  <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-b0U7KtA1McuSp71W"></script>

    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay($(this).data('token'));
        // customer will be redirected after completing payment pop-up
      });
    </script>

@endsection
