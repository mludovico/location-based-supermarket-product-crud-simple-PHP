<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Models\Product;

class ProductController extends Controller
{
  private $ProductObj;

  public function __construct()
  {
    $this->ProductObj = new Product();
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $products = $this->ProductObj->all();
        return view('index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
      $this->ProductObj->create([
        'name'=>$request->name,
        'location'=>$request->location
      ]);
      return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $product = $this->ProductObj->find($id);
      return view('index', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
      $this->ProductObj->where(['id'=>$id])->update([
        'name'=>$request->name,
        'location'=>$request->location
      ]);
      return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $deleted = $this->ProductObj->destroy($id);
      return $deleted ? "OK deleting Product $id" : "FAIL deleting Product $id";
    }

    public function getData()
    {
      return json_encode($this->ProductObj->all());
    }
}
