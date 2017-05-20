<?php

namespace App\Http\Controllers;

use App\Catagorie;
use Illuminate\Http\Request;
use App\Photo as Photo;
use App\Product as Products;
use App\Size as Size;
use App\Color as Color;
use App\Order as Order;
use App\Admin as Admin;
use App\Orders_discussion as discussion;
use App\Log as log;
use Auth;
use App\Notifications\EmployeeAssign;
use App\Notifications\OrderStatusChange;
use App\User as User;
use App\Points_management as Point;
use App\Catagorie as catagory;
use App\Slide as Slide;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribersMail;
use App\Mail\TickteSolved;
use App\Size_management as Size_manager;
use Storage;
use App\Orders_product as OrderedProduct;
use App\Product as Product;
use App\Ticket as Ticket;
use Hash;
use DB;
use App\Subscriber as Subscribers;
use App\Notifications\TicketAccepted;
use App\Notifications\AssignEmployeeToTicket;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showIndex(){
        $Point = Point::all();
        $Order = Order::where(['status'=>'Confirmed'])->count();
        $from = date('Y-m-d').' 00:00:00';
        $to = date('Y-m-d', strtotime(' +1 day')).' 00:00:00';
//        $Tickets = Ticket::whereBetween('created_at',[$from,$to])->get();
//        return json_encode($Tickets);
        $newUser = User::whereBetween('created_at',[$from,$to])->count();
        $User = User::all()->count();
        $Catagories = catagory::all();
        $Subscriber = User::where(['subscriber' => 'subscriber'])->count();
        $Slide = Slide::all();
        $Sizes = Size_manager::all();
        $Product = Products::all();
        $OrderedProduct = OrderedProduct::groupBy('product_id')->orderBy('count', 'desc')->get(['product_id', DB::raw('count(product_id) as count')]);

        return view('admin.index',['OrderedProduct' => $OrderedProduct,'Avilable_size'=>$Sizes,'Slide' => $Slide,'Catagory'=>$Catagories ,'newOrder'=>$Order , 'newUser'=>$newUser, 'user'=>$User, 'subscriber'=>$Subscriber, 'point' =>$Point]);
    }

    public function pointManager(Request $request){
        if($request->ajax()){
            $Point = Point::find($request->id);
            $Point->status = $request->status;
            $Point->discount = $request->point_discount;
            $Point->save();
        }
        else{
            return 'boo';
        }
    }

    public function addCatagory(Request $request){
        $Catagory = new catagory();
        $Catagory->catagory_type = $request->catagory_type;
        $Catagory->catagory_name = $request->catagory_name;
        $Catagory->save();
        return redirect('/admin/index');
    }
    function employeeManagement(){
        $Admin = Admin::where(['role' =>'employee'])->get();
        return view('admin.employeeManagement',['Admins' => $Admin]);
    }
    function employeeUpdate(Request $request){
        $Admin = Admin::find(decrypt($request->id));
        return view('admin.updateEmployee',['Admin' =>$Admin]);
    }
    public function update(Request $request){
        $Admin = Admin::find(decrypt($request->id));
        $Admin->name = $request->name;
        $Admin->email = $request->email;
        $Admin->save();
        return redirect('/admin/employee/management');
    }
    public function deleteEmployee(Request $request){
        if($request->ajax()){
            $Admin = Admin::find($request->id)->delete();
        }
    }

    public function addSlide(Request $request){
        $Slide = new Slide();
        if($request->file('file')){
            $fileName = time().'.'.$request->file('file')->getClientOriginalExtension();
            $request->file->move(public_path('images/user/slides'), $fileName);
            $Slide->url = $fileName;
        }
        $Slide->title = $request->slide_title;
        $Slide->description = $request->slide_description;
        $Slide->save();
        return redirect('/admin/index');
    }

    public function deleteSlide(Request $request){
        $Slide = Slide::find($request->id)->delete();
        return redirect('/admin/index');
    }

    public function showUsers(){
        $User = User::all();
        return view('admin.userManagement',['Users'=>$User]);
    }

    public  function sendMail(Request $request){
        $Subcribers = Subscribers::all();
        $subject = $request->mail_subject;
        $body = $request->mail_body;
        foreach ($Subcribers as $subcriber){
            Mail::to($subcriber)->send(new SubscribersMail($subject,$body,$subcriber));
        }
    }

    public function saveSize(Request $request){
        $Size = new Size_manager();
        $Size->size = strtoupper($request->size);
        $Size->save();
        return redirect('/admin/index');
    }

    public function showOrderForm(){
        $user = User::all();
        $Districts = explode(',',Storage::disk('public')->get('districts.txt')) ;
        $Product = Products::with('color','size','photo')->get();
        //return json_encode($Product);
        return view('admin.adminOrders.adminOrderCreate',['Districts'=>$Districts,'User'=>$user, 'Products'=>$Product]);
    }

    public function setOrder(Request $request)
    {
        if ($request->ajax()) {
            $Shipping_cost = explode(',',Storage::disk('public')->get('companyInfo.txt')) ;
            $shp = trim(str_replace('Shipping Cost:',' ',$Shipping_cost[1]));
            $Order = new Order();
            $Order->order_value = intval($request->order_value)+intval($shp);
            $Order->user_id = $request->user_id;
            $Order->address = $request->address;
            $Order->email = $request->email;
            $Order->division = $request->division;
            $Order->city = $request->city;
            $Order->payment_methode = $request->paymentMethode;
            $Order->phone = $request->phone;
            $Order->shipping_cost = $shp;
            $Order->status = "Confirmed";
            $Order->created_by = "Admin";
            $Order->save();

            $Order = Order::select('order_id')->orderBy('order_id', 'desc')->first();

            $uid = (string)$request->user_id;
            $oid = (string) $Order->order_id;
            $this->logCreator($oid,'Confirmed','1');

            $orderNumber = "$oid" . str_replace(':', '', date('Y:m:d')) . "$uid";
            $Order->order_number = $orderNumber;
            $Order->save();

                $Order = Order::select('order_id')->orderBy('order_id', 'desc')->first();
                $OrderedProduct = new OrderedProduct();

                if($request->size =='0')  $has_size = 0;
                else $has_size = 1;

                //var_dump($has_size);
                if ($has_size == 0) {
                    $Product = Product::find($request->id);
                    $avilability = intval($Product->quantity) - intval($request->quantity);
                    var_dump($avilability);
                } else {

                    $avilability = $this->productAvailabilityChecker($request->id, $request->size, $request->quantity);
                }

                if ($avilability >= 0) $OrderedProduct->available = "available";
                else $OrderedProduct->available = $avilability;
                $OrderedProduct->product_id = $request->id;
                $OrderedProduct->size = $request->size;
                $OrderedProduct->title = $request->title;
                $OrderedProduct->color = $request->color;
                $OrderedProduct->quantity = $request->quantity;
                $OrderedProduct->unit_price = $request->unit_price;
                $OrderedProduct->total_price = $request->total;
                $OrderedProduct->discount = $request->discount;
                $Order->order_product()->save($OrderedProduct);

                if ($has_size == '0') {
                    $Product = Product::find($request->id);
                    $Product->quantity = $avilability;
                    $Product->save();
                } else {
                    $this->productQuantityTinker($avilability, $request->id, $request->size, $request->quantity);
                }

        } else echo 'not got';
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

    public function productQuantityTinker($LeftOver, $product_id, $size, $quantity){
        $Size = Size::where(['product_id'=>$product_id, 'size'=>$size])->update(['quantity' => $LeftOver]);
        $Product = Product::find($product_id);
        $Product->quantity = intval($Product->quantity)-intval($quantity) ;
        $Product->save();
    }

    public function showNewTickets(){
        $Ticket = Ticket::with('user')->where(['status'=>'Recieved'])->get();
        return view('admin.newTicketList',['Tickets'=>$Ticket]);
    }

    public function changeTicketStatus(Request $request){
        if($request->ajax()){
            $Ticket = Ticket::with('user')->find($request->id);
            $Ticket['user']->notify(new TicketAccepted($Ticket));
            $Ticket = Ticket::find($request->id);
            $Ticket->status = $request->status;
            $Ticket->save();
        }
    }

    public function showAcceptedTickets(){
        $Admin = Admin::where(['role'=>'employee'])->get();
        $Ticket = Ticket::with('admin','user')->where('status', '!=' , 'Recieved')->get();
        //return json_encode($Ticket);
        return view('admin.acceptedTicketList',['Tickets'=>$Ticket, 'Employees'=>$Admin]);
    }

    public function assignEmployeeToTicket(Request $request){
        if($request->ajax()){
            $Admin = Admin::find($request->employee);
            $Ticket = Ticket::find($request->id);
            $Admin->ticket()->save($Ticket);
            $Admin->notify(new AssignEmployeeToTicket($Ticket));
        }
    }

    public function sendTicketSolvationMail(Request $request){
        $Ticket = Ticket::find($request->ticketId);
        $Ticket->feedback = $request->mail_body;
        $Ticket->save();
        $User = Ticket::with('user')->find($request->ticketId);
//        var_dump($User);
      //  return $User['user']->email;
        $subject = $request->mail_subject;
        $body = $request->mail_body;
        //return $body;
        Mail::to($User['user']->email)->send(new TickteSolved($subject,$User,$body));
        return redirect('/admin/accepted/tickets');
    }

    public function showRegistrationForm(){
        $Districts = explode(',',Storage::disk('public')->get('districts.txt')) ;
        return view('admin.createUser',['Districts'=>$Districts]);
    }

    public function registerUser(Request $request){
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->district = $request->email;
        $User->password = Hash::make($request->password);
        $User->gender = $request->gender;
        $User->mobile = $request->phone;
        $User->save();
        return redirect('/user/management');
    }

    public function checkSize(Request $request){
        $check = sizeof(Size_manager::where(['size' => strtoupper($request->size) ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function checkCatagory(Request $request){
        $check = sizeof(Catagorie::where(['catagory_name' => $request->catagory_name ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }
}
