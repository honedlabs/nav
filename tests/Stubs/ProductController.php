<?php

declare(strict_types=1);

namespace Honed\Nav\Tests\Stubs;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Products/Index');
    }

    public function create()
    {
        return inertia('Products/Create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return inertia('Products/Show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return inertia('Products/Edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
