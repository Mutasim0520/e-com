@extends('layouts.user.layout')
@section('title')
    <title>Order List</title>
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
    <section id="cart_items" style="margin-top: 25px;">
        <div class="container">
            <div class="table-responsive cart_info table-bordered">
                <table class="table table-condensed tc table-hover">
                    <thead>
                    <tr class="cart_menu">
                        <td style="color: orange;">S/N</td>
                        <td class="" style="color: orange;">Order Number</td>
                        <td class="" style="color: orange;">Date</td>
                        <td class="description" style="color: orange;">Total Amount</td>
                        <td style="color: orange;">Track Order</td>
                        <td style="color: orange;">Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n = 1; ?>
                    @foreach($order as $item)
                        <tr>
                            <td class="">
                                {{$n}}
                            </td>
                            <td class="">
                                {{$item['order_number']}}
                            </td>
                            <td class="">
                                {{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}
                            </td>

                            <td class="cart_price">
                                <p>{{floor($item->order_value)}} tk</p>
                            </td>
                            <td>
                                <a class="normal-links" href="/indivisualOrderTrack/{{encrypt($item->order_id)}}"><i class="fa fa-eye" style="margin-right: 2px;"></i>Track Order
                                </a>
                            </td>
                            <td>
                                <a class="normal-links" href="/indivisualOrderDetail/{{encrypt($item->order_id)}}">
                                    <i class="fa fa-info" style="margin-right: 2px;"></i>Detail
                                </a>
                            </td>
                        </tr>
                        <?php $n++;?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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