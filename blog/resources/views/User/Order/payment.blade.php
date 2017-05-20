@extends('layouts.user.layout')
@section('content')
    <div class="col-md-offset-5 col-md-6" style="text-align: center; display: none;" id="loading"><br>
        <div class="loader" style="text-align: center;"></div><br>
        <div style="text-align: left;padding-left: 7px;font-size: 22px;">Please Wait....</div>
    </div>
    <div class="container addft" style="margin-top: 20px;">
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
                    <div class="col-sm-3" data-toggle="tooltip" title="See Detail">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#cart">
                            <i class="fa fa-shopping-cart fa-4x tracking"></i>
                            <h4 style="color: orange;">Order Detail</h4>
                            <span>(click to see)</span>
                        </a>
                    </div>
                    <div class="col-sm-3">
                        <i style="color: #ccc;" class="fa fa-credit-card fa-4x"></i>
                        <h4 style="color: #ccc;">Authentication</h4>
                    </div>
                </div>
                <div class="col-sm-12">
                    <h3 style="font-size: 30px; font-weight: bold; text-align: left">Payment</h3>
                    <form action="javascript:callAjax();">
                                {{csrf_field()}}
                                <label class="radio-inline abul">
                                    <input type="radio"  name="paymentMthode" value="Other" required> <span> Other</span>

                                </label>
                                <label class="radio-inline abul">
                                    <input type="radio" name="paymentMthode" value="Cash On Delivery" required> <span>Cash On Delivery</span>
                                </label>
                                <input style="float: right" type="submit" class="button-1 buttontt checkout-button" value="Confirm Order">
                            </form>
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
    </div>
    <div class="modal fade" id="cart" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Detail</h4>
                </div>
                <div class="modal-body">
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
                    <table class="table table-condensed tc">
                        <tr>
                            <td>Cart Sub Total</td>
                            <td id="final-total"></td>
                        </tr>
                        <tr id="point-container" style="display: none;">
                            <td>Point Usage Discount</td>
                            <td id="used-point"></td>
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

            function itemAdder() {
                var products = JSON.parse(sessionStorage.getItem('productId'));
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#1').last().after('<tr>'+'<td>'+i+1+'</td>'+'<td class="cart_product"><img style="height: 60px;width: 55px;" src="'+products[i].photo+'" alt="Image not found"><h4>'+ products[i].title +'</h4> <p>Size:'+ products[i].sizes +'</p><p>Size:'+ products[i].colors +'</p><p>Product Code:'+ products[i].code +'</p> </td>'+'<td><p id="quantity_'+i+'">'+products[i].quantity+'</p> </td>'+
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

                if(sessionStorage.getItem('pointUsage')){
                    $('#point-container').show();
                    var new_totalwithshipping = totalwithshipping-parseInt(sessionStorage.getItem('pointUsage'));
                    $('#used-point').text(sessionStorage.getItem('pointUsage')+' tk');
                    $('#totalWithShipping').text(new_totalwithshipping+' tk')
                }
            }
            itemAdder();
        });
        function callAjax() {
            $('.addft').hide();
            $('#loading').show()
            var paymentMethode =$('input[name=paymentMthode]:checked').val();
            var address = JSON.parse(sessionStorage.getItem('voucher'));
            var pointUsage;
            if(sessionStorage.getItem('pointUsage')){
                pointUsage = sessionStorage.getItem('pointUsage');
            }
            else pointUsage = 0;
            console.log(address);
            $.ajax({
                type: 'POST',
                url:'/checkOut',
                data:{_token: "{{ csrf_token() }}", voucher:address, paymentMethode:paymentMethode, pointUsage:pointUsage
                },
                success: function( msg ) {
                    console.log(msg);
                    sessionStorage.clear();
                    console.log(msg);
                    window.location.replace('/userOrderDetail');
                }
            });
        }
    </script>
@endsection