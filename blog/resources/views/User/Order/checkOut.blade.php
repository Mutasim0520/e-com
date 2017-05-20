@extends('layouts.user.layout')
@section('title')
    <title>Checkout</title>
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
    <div class="container addft" style="display: none;">
        <div class="row">
            <div class="col-sm-12 prd_con" style="text-align: center; padding-top: 10px;">
                <div class="col-sm-12 order-step">
                    <div class="col-sm-3" data-toggle="tooltip" title="See Detail">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#auth">
                            <i class="fa fa-user fa-4x tracking"></i>
                            <h4 style="color: orange;">Authentication</h4>
                            <span>(click to see)</span>
                        </a>
                    </div>
                    <div class="col-sm-3" data-toggle="tooltip" title="See Detail">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#address">
                            <i class="fa fa-map-marker fa-4x tracking"></i>
                            <h4 style="color: orange;">Address Info</h4>
                            <span>(click to see)</span>
                        </a>
                    </div>
                    <div class="col-sm-3">
                        <i  style="color: #ccc;" class="fa fa-shopping-cart fa-4x"></i>
                        <h4  style="color: #ccc;">Order Detail</h4>
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-credit-card fa-4x" style="color: #ccc;"></i>
                        <h4 style="color: #ccc;">Payment</h4>
                    </div>
                </div>
                <div class="col-sm-12">
                    <h3 style="font-size: 30px; font-weight: bold; text-align: left">Order Details</h3>
                    <section id="cart_items" style="margin-top: 25px;">
                        <div  id="cart_container">
                            <div class="table-responsive cart_info table-bordered">
                                <table class="table table-condensed tc">
                                    <thead>
                                    <tr class="cart_menu">
                                        <td class="">S/N</td>
                                        <td class="image">Item</td>
                                        <td class="quantity">Quantity</td>
                                        <td class="price">Unit Price</td>
                                        <td class="price">Discount</td>
                                        <td class="total">Unit Total</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id="1">
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class=" col-sm-8">
                                @if($Points[0]->status == '1')
                                    <?php  ?>
                                    @if(intval($userId->points)>0)
                                        <div id="point-use-option">
                                            <p id="u-point" style="font-size: 14px;">You have some spare points. You can use these points to save more.To use your points click this <button style="height: 35px;font-size: 10px;" id="yes" class="button-4 buttontt btn">Use point</button></p>
                                        </div>
                                    @endif

                            </div>
                            <div class="col-sm-4">
                                <div id="point-use-container" style="display: none">
                                    <form id="point-use-button" action="javascript:void(0);">
                                        <input id="used-point" class="form-control" type="number" min="0" max="">
                                    </form>
                                </div>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <div class="col-sm-offset-8 col-sm-4">
                                    <table class="table table-condensed tc">
                                        <tr>
                                            <td>Cart Sub Total</td>
                                            <td id="final-total"></td>
                                        </tr>
                                        <tr class="shipping-cost">
                                            <td id="shipping">Shipping Cost</td>
                                            <td>
                                                @if(intval($Shipping_cost)>0)
                                                    {{$Shipping_cost}} tk
                                                @else Free
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td id="totalWithShipping"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="form-group bborder col-sm-12">
                        <a href="/orderPlacementInfo/payment">
                            <button type="submit" class="button-1 buttontt checkout-button">
                                <span>Proceed</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    <div class="modal fade" id="address" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Address</h4>
                </div>
                <div class="modal-body">
                    <span style="font-size: 16px; font-weight: bold">Shipping Address: </span><span id="shipping-address"></span><br>
                    <span style="font-size: 16px; font-weight: bold">Phone: </span><span id="phone"></span><br>
                    <span style="font-size: 16px; font-weight: bold">Email: </span><span id="email"></span><br>
                    <span style="font-size: 16px; font-weight: bold">Division: </span><span id="division"></span><br>
                    <span style="font-size: 16px; font-weight: bold">City: </span><span id="city"></span><br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            if(sessionStorage.getItem('productId')){
                $('.addft').show();
            }
            var products = JSON.parse(sessionStorage.getItem('productId'));
            var address = JSON.parse(sessionStorage.getItem('voucher'));
            for (var i = 0; i<address.length;i++){
                $('#shipping-address').text( address[i].address);
                $('#email').text( address[i].email);
                $('#phone').text( address[i].phone);
                $('#division').text( address[i].division);
                $('#city').text( address[i].city);
            }
            console.log(address);


            function itemAdder() {
                var products = JSON.parse(sessionStorage.getItem('productId'));
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#1').last().after('<tr>'+'<td>'+i+1+'</td>'+'<td class="cart_product"><img style="height: 110px;width: 110px;" src="'+products[i].photo+'" alt="Image not found"><h4>'+ products[i].title +'</h4> <p>Size:'+ products[i].sizes +'</p><p>Size:'+ products[i].colors +'</p><p>Product Code:'+ products[i].code +'</p> </td>'+'<td><p id="quantity_'+i+'">'+products[i].quantity+'</p> </td>'+
                        '<td class="cart_price">'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td class="cart_price">'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td class="cart_total"> <p class="cart_total_price" id="total_'+ i +'"></p></td>'+'</tr>');
                    var q = parseInt($('#quantity_'+ i +'').text());
                    var discount = parseInt(products[i].discount);
                    var productDiscount = Math.floor((discount/100)*parseInt(products[i].price));
                    var total = Math.floor(q*(parseInt(products[i].price)-productDiscount));
                    var totalDiscount = Math.floor((q*(parseInt(products[i].price)))-total);

                    $('#total_'+ i+'').text(total+' tk');
                    $('#total_discount_'+ i+'').text(totalDiscount+' tk');

                    final_total = final_total+parseInt((($('#total_'+ i+'').text()).replace(/[^0-9\.]+/g,'')));
                }
                var shippingCost = parseInt({{$Shipping_cost}});
                var totalwithshipping = final_total+shippingCost;
                $('#final-total').text(final_total+' tk');
                $('#totalWithShipping').text(totalwithshipping+' tk')

                var point_usage_status = parseInt({{$Points[0]->status}});
                if(point_usage_status == 1){
                    var point_usage_discount = parseInt({{$Points[0]->discount}});
                    var user_reserve_point = parseInt({{$userId->points}});
                    var allowed_point_usage = Math.floor(final_total*point_usage_discount/100);
                    if(user_reserve_point<allowed_point_usage){
                        allowed_point_usage = user_reserve_point;
                    }
                    $('#used-point').attr('max',allowed_point_usage);
                }
                $('#yes').click(function (event) {
                    $('#point-use-container').show();
                    $('#used-point').prop('placeholder','You can use upto '+allowed_point_usage+' point ')
                    event.preventDefault();
                });
                $('#used-point').change(function () {
                    console.log($('#used-point').val());
                    if((parseInt($('#used-point').val())>0)){
                        var new_final_total = final_total-parseInt($('#used-point').val());
                        var new_totalwith_shipping = totalwithshipping-parseInt($('#used-point').val());
                        $('#totalWithShipping').text(new_totalwith_shipping+' tk')
                        $('#final-total').text(new_final_total);
                        if( sessionStorage.getItem('pointUsage')){
                            sessionStorage.removeItem('pointUsage');
                            sessionStorage.setItem('pointUsage', $('#used-point').val());
                        }
                        else sessionStorage.setItem('pointUsage', $('#used-point').val());
                    }
                    console.log(JSON.parse(sessionStorage.getItem('pointUsage')));
                });
            }
            itemAdder();
            //console.log(products);
        });

    </script>
@endsection