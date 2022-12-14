<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = product::all();
        return view('index',["products"=>$products]);
    }

    public function fetchall(){
        $products = product::all();
        $output = '';
        if($products->count() >0){

            $output.= '<table class="table table-bordered table-striped" id="showAllProducts">
            <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Details</th>
                <th>Image</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($products as $product){
                $output.= '<tr>
                <td>'.$product->name.'</td>
                <td>'.$product->qty.'</td>
                <td>'.$product->details.'</td>
                <td><img style="height: 80px; width: 100px" src="images/.$product["avatar"]" alt=""></td>
                <td><button class="btn btn-sm btn-primary editProductBtn" id="'.$product->id.'">edit</button> <button class="btn btn-sm btn-danger deleteProductBtn" id="'.$product->id.'">delete</button></td>
                </tr>';
        }
            $output .=' </tbody> </table>';

			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
    }

    public function store(Request $request)
    {
        $product = new product;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->details = $request->details;
        if($request->hasfile('avatar')){
            $file = $request->file('avatar');
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $file->move('images/', $filename);
            $product->avatar = $filename;
        }
        $product->save();
        return response()->json([
            'status' => 200,
        ]);
    }


    public function edit(Request $request)
    {
        $product = product::find($request->product_id);
        return response()->json($product);
    }



    public function update(Request $request)
    {
        $product = product::find($request->edit_id);
        $product->name = $request->edit_name;
        $product->qty = $request->edit_qty;
        $product->details = $request->edit_details;
        if($request->hasfile('edit_avatar')){
            $file = $request->file('edit_avatar');
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $file->move('images/', $filename);
            $product->avatar = $filename;
        }
        $product->update();
        return response()->json([
            'status' => 200,
        ]);
    }


    public function delete(Request $request){
        $product = product::find($request->product_id);
        $product->delete();
        return response()->json([
            "status"=>200,
        ]);
    }


}
