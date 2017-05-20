@extends('layouts.user.layout')
@section('title')
<title>Product Detail</title>
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
        <div class="container prd_con">
            <div class="row">
                <div class="col-sm-12 padding-right" style="background: white;">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-6">
                            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                        $k = 0;
                                    ?>
                                    @foreach($Photo->photo as $item)
                                        @if($k=0) <li data-target="#slider-carousel" data-slide-to="{{$k}}" class="active"></li>
                                            @else <li data-target="#slider-carousel" data-slide-to="{{$k}}"></li>
                                            @endif
                                        <?php $k = $k+1; ?>
                                        @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                        $photos = sizeof($Photo);
                                        $n = 0;
                                    ?>
                                    @foreach($Photo->photo as $item)
                                            @if($n==0)
                                                <div class="item active">
                                                    <img id="photo" src="/images/{{$item->url}}" class="girl img-responsive" alt="Image Not found" />
                                                </div>
                                                <?php $n=$n+1; ?>
                                            @else
                                                <div class="item">
                                                    <img src="/images/{{$item->url}}" class="girl img-responsive" alt="Image Not found" />
                                                </div>
                                                <?php $n=$n+1; ?>
                                            @endif
                                        @endforeach

                                </div>

                                <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="product-information"><!--/product-information-->
                                <h2>{{ $Product->title }}</h2>
                                <span>Product Code: {{$Product->code}}</span>
                                <div class="price">
                                    @if($Product->discout)
                                        <span class="prev-price"><strike>{{ $Product->price }}.00 tk</strike></span>
                                    <?php
                                    $price =  intval($Product->price);
                                    $discount = floor((intval($Product->discout)/100)*$price);
                                    $newPrice = $price-$discount;
                                    ?>
                                        <span class="product-price">{{$newPrice}} tk</span>
                                        <span class="discount" style="color:orange; font-size: 15px;">({{$Product->discout}}% Discount)</span>
                                        <span class="discount" style="color:orange;">Save {{$discount}} tk </span>

                                    @else
                                        <span class="product-price">{{ $Product->price }} tk</span>
                                    @endif
                                </div>
                                {{--<p style="margin-bottom: 20px">(Additional VAT, if applicable, will be charged at checkout.)</p>--}}
                                <div class="hlk"></div>

                                <div>
                                    <form action="javascript:cartAdder();">
                                        @if(sizeof($Color->color) > 0 )
                                            <div class="form-group">
                                            <label>Available Color: </label>
                                            <?php $colorCounter = 0; ?>
                                            @foreach($Color->color as $item)
                                                <lable class="radio-inline">
                                                    <input name="color" value="{{$item->color}}" type="radio" id="color_{{$colorCounter}}" required>
                                                    <span style="height: 20px;width: 20px;border-radius: 50%;background-color:{{$item->color}}; color:{{$item->color}} ">o</span>
                                                </lable>
                                                <?php $colorCounter = $colorCounter+1; ?>
                                            @endforeach
                                            </div>
                                        @endif
                                            <?php $sizeCounter = 0; ?>
                                            @if(sizeof($Size->size) >0 )
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <label for="sel1">Available Size:</label>
                                                    <select name="size"  class="form-control" id="sel1" required>
                                                        <option value="">Select Size</option>
                                                        @foreach($Size->size as $item)
                                                            <option  value="{{$item->size}}">{{$item->size}}</option>
                                                            <?php $sizeCounter = $sizeCounter+1; ?>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            @if(intval($Product->quantity)>0)
                                                <div class="form-group">
                                                    <button style="margin-bottom: 20px" type="submit" class="btn btn-default cart" id="addToCart">
                                                        <i class="fa fa-shopping-cart"></i>
                                                        <span>Add to cart</span>
                                                    </button>
                                                        <a href="/addToWishlist/{{encrypt($Product->product_id)}}" class="btn btn-default cart" style="margin-bottom: 20px" >
                                                            <i class="fa fa-plus-star"></i>
                                                            Add to wishlist
                                                        </a>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                    <?php
                                        if(intval($Product->quantity)>0) $quantity = "In Stock";
                                        else $quantity = "Out Of Stock";
                                    ?>
                                <p><b>Availability:</b>{{$quantity}}</p>
                            </div><!--/product-information-->
                        </div>
                    </div><!--/product-details-->
                </div>
            </div>
        </div>
    </section>
    <section style="margin-top: 5px;">
        <div class="hlk"></div>
        <div class="container prd_con">
            <div class="row">
                <div class="col-sm-12 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <h3 style="text-align: center;">Product info & care</h3>
                                <p><?php echo $Product->description;?></p>
                            </div>
                        </div>

                    </div><!--/product-details-->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
        });
        function cartAdder() {
            var productIds = [];
            var id = "{{ $Product->product_id }}";
            var price = "{{ $Product->price }}";
            var discount = "{{$Product->discout}}";
            var title = "{{ $Product->title }}";
            var code = "{{$Product->code}}";

            var colorCounter = parseInt("{{ $colorCounter }}");
            if(colorCounter>0){
                var colors = $('input[name=color]:checked').val();
            }
            var sizeCounter = parseInt("{{ $sizeCounter }}");
            if(sizeCounter>0){
                var sizes = $('#sel1 :selected').val();
            }
            else sizes="Not Applicable"
            var has_size = '{{$Product->has_size}}';
            var max_quantity = 0;
            var quantity_array =  JSON.constructor({!!  json_encode($Quantity_array)  !!});
            if(has_size=='1'){
                for(var i = 0; i<quantity_array.length; i++){
                   if(quantity_array[i]['size'] ==sizes ){
                       max_quantity = quantity_array[i]['quantity'];
                   }
                }
            }
            else max_quantity = '{{ $Product->quantity }}';

            if(sessionStorage.getItem('productId')){
                var pid = sessionStorage.getItem('productId');
                var productIds = JSON.parse(pid);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:$('#photo').attr('src'),
                    quantity:'1',
                    maxQuantity:max_quantity
                });
                sessionStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
            }
            else{
                //console.log(id);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:$('#photo').attr('src'),
                    quantity:'1',
                    maxQuantity:max_quantity
                });
                sessionStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
            }
        };

        function wishAdder(productId){
            console.log(productId);
            $.ajax({
                type:'POST',
                url:'/addToWishlist',
                data:{_token: "{{ csrf_token() }}", id:productId
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
    </script>

@endsection