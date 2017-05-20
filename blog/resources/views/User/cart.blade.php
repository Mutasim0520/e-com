@extends('layouts.user.layout')
<title>Cart</title>
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
        <div id="mes" class="container prd_con" style="padding: 20px;">
            <h4 style=" text-align:center; color: orange;">You have not added any item to your cart yet</h4>
        </div>
        <div  id="cart_container" class="container" style="display: none;">
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
                        <td class="remove">Remove</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr id="1">
                        </tr>
                    </tbody>
                </table>
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
                        <tr>
                            <td style="text-align: right;" colspan="2" class="checkout-button-cell">
                                    <a href="/orderPlacementInfo/address" class="btn btn-default cart" style="margin-bottom: 20px">
                                        Proceed To Checkout
                                    </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            function itemAdder() {
                var products = JSON.parse(sessionStorage.getItem('productId'));
                if(products.length >0){
                    $('#cart_container').show();
                    $('#mes').hide();
                }
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#1').last().after('<tr>'+'<td>'+i+1+'</td>'+'<td class="cart_product"><img style="height: 110px;width: 110px;" src="'+products[i].photo+'" alt="Image not found"><h4>'+ products[i].title +'</h4> <p>Size:'+ products[i].sizes +'</p><p>Size:'+ products[i].colors +'</p><p>Product Code:'+ products[i].code +'</p> </td>'+'<td><label id="L"><form><input id="quantity_'+ i +'" class="form-control" type="number" name="quantity" value="'+products[i].quantity+'" min="1" max="'+products[i].maxQuantity+'" onchange="totalPriceCounter('+products[i].price +','+i+','+products[i].id+','+ products[i].discount +')"></form></label> </td>'+
                        '<td class="cart_price">'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td class="cart_price">'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td class="cart_total"> <p class="cart_total_price" id="total_'+ i +'"></p></td>'+'<td class="cart_delete"><a class="cart_quantity_delete" href="javascript:itemRemover('+products[i].id+');"><i class="fa fa-times"></i></a></td>'+'</tr>');
                    var q = Math.floor(parseInt($('#quantity_'+ i +'').val()));
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
            }
            itemAdder();
        });
        function totalPriceCounter(price,id,pid,discount) {
            var products = JSON.parse(sessionStorage.getItem('productId'));
            var unitPrice = parseInt(price);
            var discount = parseInt(discount);
            var productDiscount = Math.floor((discount/100)*unitPrice);
            var counter = parseInt($('#quantity_'+ parseInt(id) +'').val());
            var total = Math.floor(counter*(unitPrice-productDiscount));
            var totalPrice = unitPrice*counter;
            var totalDiscount = Math.floor((counter*unitPrice)-total);

            $('#total_discount_'+ id+'').text(totalDiscount+' tk');
            $('#total_'+ parseInt(id) +'').text(total+' tk');

            var finalTotal = 0;

            for (var i =0; i<products.length;i++){
                var itemTotal = $('#total_'+ i +'').text();
                itemTotal = itemTotal.replace(/[^0-9\.]+/g,'');
                finalTotal = parseInt(itemTotal)+finalTotal;
            }

            var shippingCost = parseInt({{$Shipping_cost}});
            var totalwithshipping = finalTotal+shippingCost;

            $('#final-total').text(finalTotal+' tk');
            $('#totalWithShipping').text(totalwithshipping+' tk')


            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(pid)){
                    console.log('dukse');
                    var pid = products[i].id;
                    var title = products[i].title;
                    var price = products[i].price;
                    var colors = products[i].colors;
                    var sizes = products[i].sizes;
                    var photo = products[i].photo;
                    var code = products[i].code;
                    var discount = products[i].discount;
                    var quantity = $('#quantity_'+ parseInt(id) +'').val();
                    products.splice(i,1);
                    products.push({
                        id : pid,
                        code:code,
                        title : title,
                        price: price,
                        shippingCost: shippingCost,
                        discount:discount,
                        colors:colors,
                        sizes:sizes,
                        photo:photo,
                        quantity:quantity
                    });
                    sessionStorage.setItem('productId', JSON.stringify(products));
                    console.log(sessionStorage.getItem('productId'));

                }
            }

        }
        function itemRemover(id) {
            var products = JSON.parse(sessionStorage.getItem('productId'));
            console.log(products);
            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(id)){
                    products.splice(i,1);
                    sessionStorage.setItem('productId',JSON.stringify(products));
                    break;
                }
            }
            location.reload();
        }

    </script>
@endsection