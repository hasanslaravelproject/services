@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
    
    <div class="row">
    
<div class="col-sm-6 offset-3 text-center">

<form action="{{route('buy.package')}}" class="p-5" method="post" id="payment_form">
@csrf

<p>{{$package->name}}</p>
<p>{{$package->price}}</p>
                                            <input type="hidden" value="{{ $package->id }}" name="package_id">
                                            
                                            

                                            <div class="card-body">
                                                <!-- Mount the instance within a <label> -->
                                                <div id="card-element"></div>
                                            
                                            </div>

                                            <div class="form-group">
                                            
                                            <button  type="submit" class="btn btn-success text-center" type="submit">Confirm</button>
                                            </div>
                                   

</form>

</div>

</div>
    
    </div>

      
    </div>
</div>
@endsection
@section('js')
<script src="https://js.stripe.com/v3/"></script>
    <script !src="">
        "use strict";

        var stripe = Stripe('{{isset($stripe->stripe_publishable_key)?$stripe->stripe_publishable_key:''}}');
        var elements = stripe.elements();

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.on('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        // Handle form submission.
        var form = document.getElementById('payment_form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var cardRadio = document.getElementById('cardRadio');
            
                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            
        });
        
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment_form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form
            var form = $('#payment_form');
                if (form) {
                    form.submit();
                }
        
        }
        
        </script>
        @endsection
