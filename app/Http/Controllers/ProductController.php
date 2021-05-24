<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Product::class);
        
        $search = $request->get('search', '');
        $role = auth()->user()->roles()->first()->id;
        $user_id = auth()->user()->id;
        if($role ==2){
            $products = Product::search($search)
            ->latest()
            ->paginate(5);
        }else{
            $products = Product::join('packages','products.package_id','packages.id')
            ->join('companies','packages.company_id','companies.id')
            ->join('company_user','companies.id','company_user.company_id')
            ->where('company_user.user_id','=', $user_id)
            ->select('packages.*')
            ->latest()
            ->paginate(5);
        }
        
        return view('app.products.index', compact('products', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Product::class);

        $packages = Package::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view('app.products.create', compact('packages', 'categories'));
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validated();

        $product = Product::create($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        return view('app.products.show', compact('product'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $packages = Package::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view(
            'app.products.edit',
            compact('product', 'packages', 'categories')
        );
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();

        $product->update($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
