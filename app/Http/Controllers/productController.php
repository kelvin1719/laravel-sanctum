<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //lets validate data first ;
        $rules = array(
            'name'=> 'required',
            'price'=>'required',
            'slug'=> 'required',
        );
        $validate = Validator::make( $request->all() ,$rules);
        if($validate->fails()){
            return (new ResponseController())->Error('Validation Failure' , $validate->errors());
        }
        $user = new Product();
        $user['name'] = $request->name ;
        $user['description'] = $request->description ;
        $user['price'] = $request->price ;
        $user['slug'] = $request->slug ;
        $insert = $user->save();
        if($insert){
            return (new ResponseController())->Success('Data saved successfully' , $user);
        }else{
            return (new ResponseController())->Error('Data not saved' , null);
        }

    }

    public function find($id){
        $product = Product::where('id', $id)->get();
        if(count($product) > 0){
            return (new ResponseController())->Success('Item found' , $product) ;
        }else{
            return (new ResponseController())->Error('No item Found' , null) ;
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //lets update product
        $product = Product::where('id' , $id)->first();
//        return $product;

        $rules = array(
            'name'=> 'required',
            'price'=>'required',
            'slug'=> 'required',
        );
        $validate = Validator::make($request->all() , $rules );
        if($validate->fails()){
            return (new ResponseController())->Error('Validation Errors' , $validate->errors());
        }
        if(!empty($product)){
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->slug = $request->slug;
            $result = $product->save();
            if($result){
                return (new ResponseController())->Success('successfull update' , $product);
            }else{
                return (new ResponseController())->Error('failure updating' , 'null');
            }
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::where('id' , $id)->first();
        if(!empty($item)){
            $deleted = $item->delete();
            return (new ResponseController())->Success('item deleted' , $deleted);
        }else{
            return (new ResponseController())->Error('nothing to delete' , null);
        }
    }
    public function restore($id){
        //check if item is deleted
        $deleted_items = Product::onlyTrashed()->where('id' , $id);
        if(!empty($deleted_items)){
            $restore = $deleted_items->restore();
            return (new ResponseController())->Success('item restored ' , $restore);
        }

    }

    public function search(Request $request){
        //Search by keyword
        $search = Product::where('name' , 'like', '%'.$request->name.'%')->paginate(1);
        return $search;
    }
}
