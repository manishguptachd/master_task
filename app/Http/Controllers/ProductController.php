<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('categories', 'subCategories')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::with('categories', 'subCategories')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * Search for a name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }


    // below code is for web application
    public function getAllData($data = null) {

        $all_data = Product::with('categories', 'subCategories')->get();
        $all_data = !empty($all_data) ? $all_data->toArray() : [];

        $category = Category::all();
        $category = !empty($category) ? $category->toArray() : [];

        $sub_category = SubCategory::all();
        $sub_category = !empty($sub_category) ? $sub_category->toArray() : [];

        $data_arr = [];
        foreach ($all_data as $data_key => $value) {
            $data_arr[] = [
                'id' => $value['id'],
                'prod_name' => $value['name'],
                'cat_id' => $value['categories']['id'],
                'cat_name' => $value['categories']['name'],
                'subCat_id' => $value['sub_categories']['id'],
                'subCat_name' => $value['sub_categories']['name']
            ];
        }

        if($data == 1)
        {
            return $data_arr;
        }
        return view('index', [
            'data' => $data_arr,
            'category' => $category,
            'subCat' => $sub_category
        ]);
    }

    public function addProduct(Request $request) {

        $request->validate([
            'cat_id' => 'required',
            'subCat_id' => 'required',
            'prod_name' => 'required'
        ]);

        $create_pro = [
            'category_id' => $request->cat_id,
            'subcategory_id' => $request->subCat_id,
            'name' => $request->prod_name,
            'slug' => 'product',
            'price' => 499.00
        ];

        Product::create($create_pro);
        $data = $this->getAllData(1);
        return response()->json(array('success' => true, 'msg' => 'Product Inserted Successfully!', 'data' => $data));
    }
}
