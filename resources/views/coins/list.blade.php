@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">



        <div class="col-sm-12">
            <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#exampleModal">
                Add Coin
            </button>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <!-- <th scope="col">#</th> -->
                        <th scope="col">COIN</th>
                        <th scope="col">PRICE</th>
                        <th scope="col">HOLDINGS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coins as $coin)
                    <tr>
                        <!-- <td>{{$coin->id}}</td> -->
                        <td>{{$coin->currency_name}}</td>
                        <td>${{number_format(round($coin->usd_rate,2),2)}}</td>
                        <td>${{number_format(round($coin->usd_rate * $coin->amount),2)}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




    </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Coin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form method="post" action="{{url('/save_balance')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Coins</label>

                        <select class="form-control selectpicker" name="currency_id" data-live-search="true" required>
                            @foreach($api_coins as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                        <small id="emailHelp" class="form-text text-muted">Coin List.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection