@extends('layouts.user.layout')
@section('title')
    <title>Address</title>
@endsection
@section('navigation')
    <div class="mainmenu pull-left">
        <ul class="nav navbar-nav collapse navbar-collapse">
            <li class="dropdown"><a href="#">Men's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Male')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="dropdown"><a href="#">Women's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Female')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="dropdown"><a href="#">Kid's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Kids')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <section style="margin-top: 20px;">
        <div class="container addft order-process">
            <div class="row">
                <div class="col-sm-12 prd_con" style="text-align: center; padding-top: 10px; border-bottom: 2px solid gainsboro;">
                   <div class="col-sm-12 order-step">
                       <div class="col-sm-3" data-toggle="tooltip" title="See Detail">
                           <a href="javascript:void(0);" data-toggle="modal" data-target="#auth">
                               <i class="fa fa-user fa-4x tracking"></i>
                               <h4 style="color: orange;">Authentication</h4>
                               <span>(click to see)</span>
                           </a>
                       </div>
                       <div class="col-sm-3">
                           <i class="fa fa-map-marker fa-4x" style="color: #ccc;"></i>
                           <h4 style="color: #ccc;">Address Info</h4>
                       </div>
                       <div class="col-sm-3">
                           <i class="fa fa-shopping-cart fa-4x" style="color: #ccc;"></i>
                           <h4 style="color: #ccc;">Order Detail</h4>
                       </div>
                       <div class="col-sm-3">
                           <i class="fa fa-credit-card fa-4x" style="color: #ccc;"></i>
                           <h4 style="color: #ccc;">Payment</h4>
                       </div>
                   </div>
                    <div class="col-sm-12">
                        <form class="form">
                            <div class="form-group col-sm-12">
                                <h3 style="font-size: 30px; font-weight: bold; text-align: left">Shipping Address</h3>
                            </div>
                            <div class="form-group">
                                <textarea id="address" class="form-control addtex" placeholder="Address" rows="5" required placeholder="Delivery address"></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <input id="email" type="email" class="form-control"  placeholder="Please Enter Your Email" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <input id="phone" type="text" class="form-control" id="Phone" placeholder="Please Enter Your Phone No" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <select id="division"  class="form-control" autocomplete="on" required>
                                    <option value="">Select Division</option>
                                    <option value="DHAKA">Dhaka</option>
                                    <option value="MAYMENSHINGH">Maymensingh</option>
                                    <option value="RANGPUR">Rangpur</option>
                                    <option value="RAJSHAHI">Rajshahi</option>
                                    <option value="SYLHET">Sylhet</option>
                                    <option value="BARISAL">Barisal</option>
                                    <option value="KHULNA">Khulna</option>
                                    <option value="CHITTAGONG">Chittagong</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <select id="city" class="form-control" autocomplete="on" required>
                                    <option value="">Select City</option>
                                    @foreach($Districts as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="submit" class="button-1 buttontt checkout-button" value="Proceed">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="auth" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Email</h4>
                </div>
                <div class="modal-body">
                    <h3>{{Auth::user()->email}}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('form').submit(function (event) {
                event.preventDefault();
                var voucher = JSON.parse(sessionStorage.getItem('productId'));
                var userId = "{{ $userId->id }}";
                var orderInfo = [];
                orderInfo.push({
                    'userId' : userId,
                    'address':$('#address').val(),
                    'phone' : $('#phone').val(),
                    'email':$('#email').val(),
                    'division' : $('#division').val(),
                    'city' : $('#city').val(),
                    'productDetail' : voucher
                });
                sessionStorage.setItem('voucher',JSON.stringify(orderInfo));
                window.location.href = '/orderPlacementInfo/checkOut';
            })
        })
    </script>
    @endsection