@extends('layouts.user.layout')
@section('title')
    <title>Order Detail</title>
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
    <section style="margin-top: 25px;">
        <div class="container">
            <div class="col-md-12 prd_con" style="padding-top: 20px; margin-bottom: 25px; border-top: 2px solid orange;">
                <div class="col-md-4">
                    <address>
                        <h4>Shipping Address</h4>
                        <span>{{Auth::user()->name}}</span><br>
                        <span>{{$order['address']}}</span><br>
                        <span>City: {{$order['city']}}</span><br>
                        <span>Division: {{$order['division']}}</span><br>
                        <span>Phone: {{$order['phone']}}</span><br>
                        <span style="color: orange">Email: {{$order['email']}}</span>

                    </address>
                </div>
                <div class="col-md-4">
                    <h4>Payment Method</h4>
                    <div>
                    {{$order->payment_methode}}
                    <i class="fa fa-handshake-o tracking"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Curretnt Status</h4>
                    <span>
                        @if($order['status'] == 'Invoice' || $order['status'] == 'Shipping' || $order['status'] == 'Processing-Delivery')
                            Processing
                            @else
                            {{$order['status']}}
                        @endif
                    </span>
                </div>
            </div>
                <div class="clearfix"></div>
                <div class="table-responsive cart_info table-bordered">
                    <table class="table table-condensed tc">
                        <thead>
                        <tr class="cart_menu">
                            <td class="description" style="color:orange;">Order ID</td>
                            <td style="color:orange;">Issued Date</td>
                            <td class="image" style="color:orange;">Item</td>
                            <td class="description" style="color:orange;">Details</td>
                            <td class="price" style="color:orange;">Quantity</td>
                            <td class="quantity" style="color:orange;">Unit Price</td>
                            <td class="quantity" style="color:orange;">Discount</td>
                            <td class="quantity" style="color:orange;">Unit Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $subtotal =0;
                            $totalDiscount = 0;
                        ?>
                        @foreach($order['order_product'] as $item)
                            <tr>
                                <td class="cart_description">
                                    {{$order['order_number']}}
                                </td>
                                <td class="cart_description">
                                    {{ substr($order['created_at'], 0, strpos($order['created_at'], ' '))}}
                                </td>
                                <td class="cart_product">
                                    <a href=""><img style="height: 110px; width: 110px;" src="{{$item->photo}}" alt="Image Not Found"></a>
                                </td>
                                <td class="cart_description">
                                    <h4>{{$item->title}}</h4>
                                    <p><span>Size: </span>{{$item->size}}</p>
                                    <p><span>Color:</span> <span style="color: {{$item->color}}; background-color: {{$item->color}}">pp</span><span> {{$item->color}} </span></p>
                                </td>
                                <td class="cart_price">
                                    <p>{{$item->quantity}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <p>{{$item->unit_price}} tk</p>
                                </td>
                                <td class="cart_quantity">
                                    <p>
                                        <?php
                                            $totalDiscount = floor(intval($item->quantity)*intval($item->unit_price)*intval($item->discount)/100);
                                            echo(floor(intval($item->quantity)*intval($item->unit_price)*intval($item->discount)/100)).' tk';
                                        ?>
                                    </p>
                                </td>
                                <td class="cart_quantity">
                                    <p><?php
                                            $subtotal = $subtotal+(intval($item->quantity)*intval($item->unit_price));
                                        echo (intval($item->quantity)*intval($item->unit_price)." tk");
                                        ?></p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <div class="col-sm-offset-8 col-sm-4">
                        <table class="table table-condensed tc">
                            <tr>
                                <td>Sub Total</td>
                                <td>{{$subtotal}} tk</td>
                            </tr>
                            <tr>
                                <td>Total Discount</td>
                                <td>{{$totalDiscount}} tk</td>
                            </tr>
                            @if(intval($order['used_point'])>0)
                                <tr>
                                    <td>Point Usage Discount</td>
                                    <td>{{$order['used_point']}} tk</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Shipping Cost</td>
                                <td>{{$order->shipping_cost}} tk</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?php
                                        echo ($subtotal-$totalDiscount+intval($order->shipping_cost)-intval($order['used_point'])).' tk';
                                    ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!--/#cart_items-->
    </section>
@endsection
@section('scripts')
    <script>
        function showDetail(id) {
            $('#detail_'+id+'').toggle(function () {
                $(this).css("background-color","#F8F8F8");
                $(this).css("background-color","#F8F8F8");
            });
        }
    </script>
@endsection