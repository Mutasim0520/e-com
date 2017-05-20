<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConirmed;
use Illuminate\Http\Request;
use App\User as user;
use App\Product as Product;
use App\Order as Order;
use App\Size as Size;
use App\Orders_product as OrderedProduct;
use App\Log as log;
use Auth;
use App\Points_management as Points;
use App\Catagorie as Catagory;
use Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showOrderPlacement(){
        $Districts = explode(',',Storage::disk('public')->get('districts.txt')) ;
        $id = auth()->user()->id;
        $user = user::find($id);
        $Point = Points::all();
        $Catagory = Catagory::all();
        return view('User.Order.orderPlacementInfo',['Districts'=>$Districts,'Catagory'=>$Catagory,'userId' => $user, 'Points' => $Point]);
    }

    public function showCheckOut(){
        $Shipping_cost = explode(',',Storage::disk('public')->get('companyInfo.txt')) ;
        $shp = trim(str_replace('Shipping Cost:',' ',$Shipping_cost[1]));
        $id = auth()->user()->id;
        $user = user::find($id);
        $Point = Points::all();
        $Catagory = Catagory::all();
        return view('User.Order.checkOut',['Catagory'=>$Catagory,'userId' => $user, 'Points' => $Point, 'Shipping_cost' => $shp]);
    }

    public function showOrderPayment(){
        $Shipping_cost = explode(',',Storage::disk('public')->get('companyInfo.txt')) ;
        $shp = trim(str_replace('Shipping Cost:',' ',$Shipping_cost[1]));
        $id = auth()->user()->id;
        $user = user::find($id);
        $Catagory = Catagory::all();
        return view('User.Order.payment',['Shipping_cost' => $shp,'Catagory'=>$Catagory,'userId' => $user]);
    }

    public function logCreator($id, $updated_step, $updated_by){
        $message = 'Order has been recieved to admin';
        $Order = Order::find($id);
        $Log = new log();
        $Log->updated_step = $updated_step;
        $Log->admin_id = $updated_by;
        $Log->message = $message;
        $Order->log()->save($Log);
    }

    function productAvailabilityChecker($product_id,$size,$quantity){
        $Size = Size::where(['product_id'=>$product_id, 'size'=>$size])->get();
        $leftOver = intval($Size[0]->quantity)-intval($quantity);
        return $leftOver;
    }

    public function confirmCheckout(Request $request){
        if($request->ajax()){
            $voucher = $request->voucher;
            $voucher = $voucher[0];
            $total =0;
            foreach ($voucher['productDetail'] as $item){
                $discount = floor((intval($item['discount'])/100)*$item['price']);
                $unitPrice = floor(intval($item['price'])-$discount);
                $total =$total+ ($unitPrice*$item['quantity']);
            }
            //echo $total;
            $Shipping_cost = explode(',',Storage::disk('public')->get('companyInfo.txt')) ;
            $shp = trim(str_replace('Shipping Cost:',' ',$Shipping_cost[1]));
            $Order = new Order();
            $total = intval($shp)+$total;
            if(intval($request->pointUsage)>0) {
                $Order->used_point = ($request->pointUsage);
                $total = $total-floor(intval($request->pointUsage));
            }
            $Order->order_value = floor($total);
            $Order->user_id = $voucher['userId'];
            $Order->address = $voucher['address'];
            $Order->email = $voucher['email'];
            $Order->division = $voucher['division'];
            $Order->city = $voucher['city'];
            $Order->payment_methode = $request->paymentMethode;
            $Order->phone = $voucher['phone'];
            $Order->shipping_cost = $shp;
            $Order->status = "Confirmed";
            $Order->save();

            $uid = (string) $voucher['userId'];
            $Order = Order::select('order_id')->orderBy('order_id','desc')->first();

            $oid = (string) $Order->order_id;
            $this->logCreator($oid,'Confirmed','1');

            $orderNumber ="$oid".str_replace(':','',date('Y:m:d'))."$uid";
            $Order->order_number = $orderNumber;
            $Order->save();

            foreach ($voucher['productDetail'] as $item){
                $Order = Order::select('order_id')->orderBy('order_id','desc')->first();
                $OrderedProduct = new OrderedProduct();

                $has_size = $this->sizeChecker($item['id']);
                //var_dump($has_size);
                if($has_size == 0){
                    $Product = Product::find($item['id']);
                    $avilability = intval($Product->quantity)-intval($item['quantity']);
                    var_dump($avilability);
                }
                else{

                    $avilability = $this->productAvailabilityChecker($item['id'],$item['sizes'],$item['quantity']);
                }

                if($avilability >=0 ) $OrderedProduct->available = "available";
                else $OrderedProduct->available = $avilability;
                $OrderedProduct->product_id = $item['id'];
                $OrderedProduct->size = $item['sizes'];
                $OrderedProduct->title = $item['title'];
                $OrderedProduct->photo = $item['photo'];
                $OrderedProduct->color = $item['colors'];
                $OrderedProduct->quantity = $item['quantity'];
                $OrderedProduct->unit_price = $item['price'];
                $OrderedProduct->total_price = floor((intval($item['price'])*$item['quantity']));
                $OrderedProduct->discount = floor($item['discount']);
                $Order->order_product()->save($OrderedProduct);

                if($has_size=='0'){
                    $Product = Product::find($item['id']);
                    $Product->quantity = $avilability;
                    $Product->save();
                }
                else{
                    $this->productQuantityTinker($avilability,$item['id'],$item['sizes'],$item['quantity']);
                }
            }
            echo $orderNumber;
            $user = Auth::user();
            Mail::to($user)->send(new OrderConirmed($user));
            if(intval($request->pointUsage)>0){
                $user->points = intval($user->points)-intval($request->pointUsage);
                $user->save();
            }
        }
    }

    public function productQuantityTinker($LeftOver, $product_id, $size, $quantity){
        $Size = Size::where(['product_id'=>$product_id, 'size'=>$size])->update(['quantity' => $LeftOver]);
        $Product = Product::find($product_id);
        $Product->quantity = intval($Product->quantity)-intval($quantity) ;
        $Product->save();
    }

    public function sizeChecker($product_id){
        $Product = Product::find($product_id);
        return $Product->has_size;
    }

    public function showUserOrderDetail(){
        $id = auth()->user()->id;
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->where(['user_id'=>$id])->get();
        return view('User.Order.orderDetail',['Catagory'=>$Catagory,'order' => $Order]);
    }

    public function showIndivisualOrder(Request $request){
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->find(decrypt($request->id));
        //return json_encode($Order);
        return view('User.Order.IndivisualOrderDetail',['Catagory'=>$Catagory,'order' => $Order]);
    }
    public function showOrderTrack(Request $request){
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->find(decrypt($request->id));
        //return json_encode($Order);
        return view('User.Order.IndivisualOrderTrack',['Catagory'=>$Catagory,'order' => $Order]);

    }
}
