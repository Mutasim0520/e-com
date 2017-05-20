@extends('layouts.user.layout')
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

@section('slider')
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <?php $slides = sizeof($Slide)?>
                        <ol class="carousel-indicators">
                            @for($i = 0;$i<$slides;$i++)
                                @if($i ==0 )
                                    <li data-target="#slider-carousel" data-slide-to="{{$i}}" class="active"></li>
                                @else
                                    <li data-target="#slider-carousel" data-slide-to="{{$i}}"></li>
                                @endif
                            @endfor
                        </ol>

                        <div class="carousel-inner">
                            <?php $k = 0; ?>
                            @foreach($Slide as $item)
                                @if($k==0)
                                        <div class="item active">
                                            <div class="col-sm-6">
                                                <h1>{{$item->title}}</h1>
                                                <p>{{$item->description}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="/images/user/slides/{{$item->url}}" class="girl img-responsive" alt="" />
                                                {{--<img src="/images/user/slides/{{$item->url}}"  class="pricing" alt="" />--}}
                                            </div>
                                        </div>
                                    @else
                                        <div class="item">
                                            <div class="col-sm-6">
                                                <h1>{{$item->title}}</h1>
                                                <p>{{$item->description}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="/images/user/slides/{{$item->url}}" class="girl img-responsive" alt="" />
                                                {{--<img src="/images/user/slides/{{$item->url}}"  class="pricing" alt="" />--}}
                                            </div>
                                        </div>
                                    @endif
                                <?php $k = $k+1; ?>
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
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="designm">
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 padding-right">
                    <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Featured Items</h2>
                        <?php $p=1; ?>
                    @foreach($Product as $item)
                        <div class="col-sm-3" style="margin-bottom: 10px;">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        @foreach($Photo as $photo)
                                            @if($photo->product_id == $item->product_id)
                                                <a href="/productDetail/{{encrypt($item->product_id)}}">
                                                    <img src="/images/{{ $photo->url }}" alt="Image not available" style="height: 220px; width: 208px;" />
                                                </a>
                                            @endif
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection