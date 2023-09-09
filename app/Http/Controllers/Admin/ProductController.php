<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();

            Log::info("Begin DB Transaction");

            $image = $request->image_url;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(15) . '.' . 'png';

            Storage::disk('public')->put("products/{$imageName}", base64_decode($image));

            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imageName,
            ]);

            Log::info("Product Created with given id : {$product->id}.");

            DB::commit();

            return response()->noContent(201);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::warning("DB Transaction Rollback");
            Log::error("Exeption : {$th}");

            return response()->noContent(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            Log::info("Begin DB Transaction");

            $product->delete();

            if (Storage::disk('public')->exists("products/{$product->image}")) {
                Storage::disk('public')->delete("products/{$product->image}");
            }

            Log::info("Product Deleted with id : {$product->id}.");

            DB::commit();

            return response()->noContent(204);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::warning("DB Transaction Rollback");
            Log::error("Exeption : {$th}");

            return response()->noContent(500);
        }
    }
}
