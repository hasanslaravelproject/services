@extends('layouts.app')

@section('content')

<div class="container">
<div class="row">
<div class="col-sm-10 offset-1">
<div class="card p-4">
<form action="{{route('stripe.setting')}}" method="post">
@csrf
@method('put')
<input type="hidden" value="{{isset($stripeId)?$stripeId:''}}" name="stripe_id">
<div class="form-group">
    <label for="">Stripe Publishable Key</label>
    <input type="text" value="{{isset($stripe->stripe_publishable_key)?$stripe->stripe_publishable_key:''}}" class="form-control" name="stripe_publishable_key">
</div>

<div class="form-group">
    <label for="">Stripe Secret Key</label>
    <input type="text" value="{{isset($stripe->stripe_secret_key)?$stripe->stripe_secret_key:''}}" class="form-control" name="stripe_secret_key">
</div>
<div class="form-group">
<button class="btn btn-success badge-success light" type="submit">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
@endsection