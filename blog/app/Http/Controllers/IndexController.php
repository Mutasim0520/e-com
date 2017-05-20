<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo as Photo;
use App\Product as Products;
use App\Size as Size;
use App\Color as Color;
use App\Slide as Slide;
use App\Catagorie as Catagory;
use Storage;
use App\Subscriber as Subscriber;

class IndexController extends Controller
{
    public function showIndex(){
        $Product = Products::with('size','color','photo')->get();
        //return json_encode($Product);
        $Photo = Photo::all();
        $Slide = Slide::all();
        $Catagory = Catagory::all();

        return view('User.products' , ['Catagory'=>$Catagory,'Slide'=>$Slide,'Product' => $Product , 'Photo' => $Photo]);
    }

    public function QuantityContainer($id){
        $Size = Products::find(decrypt($id));
        $Size->Size;
        $Quantity_array = array();
        foreach ($Size->Size as $item){
            $Quantity_array[] = array("size"=>$item->size,"quantity"=>$item->quantity);
        }
        return $Quantity_array;
    }

    public function showProductDetail(Request $request){
        $Product = Products::find(decrypt($request->id));
        $Color = Products::find(decrypt($request->id));
        $Color->Color;
        $Size = Products::find(decrypt($request->id));
        $Size->Size;
        $Photo = Products::find(decrypt($request->id));
        $Photo->Photo;
        $quantity_array = $this->QuantityContainer($request->id);
        $Catagory = Catagory::all();
        return view('User.productDetail' , ['Catagory'=>$Catagory,'Product' => $Product , 'Color' => $Color , 'Size' => $Size , 'Photo' => $Photo, 'Quantity_array'=>$quantity_array]);
    }

    public function showCart(){
        $Catagory = Catagory::all();
        $Shipping_cost = explode(',',Storage::disk('public')->get('companyInfo.txt')) ;
        $shp = trim(str_replace('Shipping Cost:',' ',$Shipping_cost[1]));
        return view('User.cart',['Catagory'=>$Catagory, 'Shipping_cost' => $shp]);
    }
    public function CatagoryWiseProduct(Request $request){
        $Product = Products::with('size','color','photo')->where(['catagory' => $request->catagory])->get();
        //return json_encode($Product);
        $Photo = Products::where(['catagory' => $request->catagory])->with('Photo')->get();
        //return json_encode($Photo->photo);
        $Slide = Slide::all();
        $Catagory = Catagory::all();
        return view('User.catagoryProducts' , ['Catagory'=>$Catagory,'Slide'=>$Slide,'Product' => $Product , 'Photo' => $Photo]);
    }

    public function subscriber (Request $request){
        $Subscriber = Subscriber::where(['email' => $request->email])->get();
        if(sizeof($Subscriber)>0){
            return redirect('/');
        }
        else{
            $Subscriber = new Subscriber();
            $Subscriber->email = $request->email;
            $Subscriber->save();
            return redirect('/');
        }
    }

    public function itemFinder(Request $request){
        $Product = Products::with('photo','color','size')->where('title', 'like', '%' . $request->search . '%')->get();
        $Catagory = Catagory::all();
//        return $Product;
        return view('User.searchProducts' , ['Catagory'=>$Catagory,'Product' => $Product]);

    }
}
