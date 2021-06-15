@php $editing = isset($category) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $category->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>


add to cart items
UserCart-> product_id, quantity=1;
$user=auth::user();
$carts=Cart::where('user_id',$user->id)->get();
foreach($carts as $cart){
    
    $product=Product::where('id',$cart->product_id)->first();
$productPreQuantity=product->stock - $cart->quantity;
product->stock=productPreQuantity;
$product->save();

}