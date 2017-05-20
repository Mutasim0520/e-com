@extends('layouts.user.layout')
@section('title')
    <title>Searched Product</title>
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
    <section class="designm">
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 padding-right">
                    <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Featured Items</h2>
                        <?php $p=1; ?>
                        @if(sizeof($Product)>0)
                            @foreach($Product as $item)
                                <div class="col-sm-3" style="margin-bottom: 10px;">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                @foreach($item['photo'] as $photo)
                                                        <a href="/productDetail/{{encrypt($item->product_id)}}">
                                                            <img src="/images/{{ $photo->url }}" alt="Image not available" style="height: 220px; width: 208px;" />
                                                        </a>
                                                @endforeach
                                                @if($item->discout)
                                                        <label class="off">{{ $item->discout }}% off</label>
                                                    @endif
                                            </div>

                                        </div>

                                    </div>
                                    <p class="ssl">{{ $item->title }}</p>
                                        <div class="col-sm-8 pull-left">
                                        <a class="hebt" href="/addToWishlist/{{encrypt($item->product_id)}}" class="btn btn-default add-to-cart"> <i class="fa fa-star"></i>Add to Wishlist</a>
                                        </div>
                                        <div class="col-sm-4">
                                        <p class="maaanag">{{ $item->price }} tk </p>
                                        </div>
                                </div>
                                <?php $p= $p+1; ?>
                            @endforeach
                            @else
                            <p>No Item Matched</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection