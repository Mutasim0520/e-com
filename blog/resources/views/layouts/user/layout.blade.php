<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
@yield('title')
<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/user/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="/css/user/font-awesome.min.css" rel="stylesheet">
    <link href="/css/user/prettyPhoto.css" rel="stylesheet">
    <link href="/css/user/price-range.css" rel="stylesheet">
    <link href="/css/user/animate.css" rel="stylesheet">
    <link href="/css/user/main.css" rel="stylesheet">
    <link href="/css/user/responsive.css" rel="stylesheet">
    <script src="/js/user/html5shiv.js"></script>
    @yield('styles')
</head>
<body>
<header id="header"><!--header-->
    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="logo pull-left">
                        <a href="/" style="color: white !important;"><img src="" alt="" />Logo</a>
                    </div>
                    <div class="btn-group pull-right">
                    </div>
                </div>
                <div class="col-sm-6">
                    <form satd action="/searchItem" method="post">
                        {{csrf_field()}}
                        <input type="text" id="search" name="search" class="searchicon" placeholder="Find Your Product" style="width: 500px;">
                    </form>
                </div>
                <div class="col-sm-4">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if (Auth::guest())
                                <li><a href="/login"><i class="fa fa-sign-in"></i>Sign In</a></li>
                                <li><a href="/register"><i class="fa fa-lock"></i>Sign Up</a></li>
                                <li><a href="{{ url('/cart')}}"><i class="fa fa-shopping-cart"></i><span id="cartNotification" class="badge blue"></span></a></li>
                            @else
                                <li class="dropdown"><a href="javascript:void(0);"><i class="fa fa-user"></i> {{ Auth::user()->name}}</a></li>
                                <li><a href="{{route('user.account.settings')}}"  data-toggle="tooltip" title="Account Settings" data-placement="bottom"><i class="fa fa-cog"></i></a></li>
                                <li>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"  data-toggle="tooltip" title="Logout" data-placement="bottom">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                </li>
                                <li><a href="{{ url('/cart')}}"><i class="fa fa-shopping-cart"  data-toggle="tooltip" title="Cart" data-placement="bottom"></i><span id="cartNotification" class="badge blue"></span></a></li>
                                <li><a href="{{route('user.wishList')}}"><i class="fa fa-star"  data-toggle="tooltip" title="WishList" data-placement="bottom"></i></a></li>
                                <li><a href="{{route('user.order')}}"><i class="fa fa-book" data-toggle="tooltip" title="Order Detail" data-placement="bottom"></i></a></li>
                                <li data-toggle="tooltip" title="Create Ticket" data-placement="bottom"><a  href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope"></i></a></li>
                                <li>
                                    <div class="dropdown">
                                        <button id="not-menu" class="btn btncl dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 8px 0px; color: white;">
                                            <i class="fa fa-bell"></i><span id="blue" class="badge blue"></span>
                                        </button>
                                        <ul class="dropdown-menu blamr">
                                            @if(sizeof(Auth::user()->unreadNotifications)>0)
                                                @foreach(Auth::user()->unreadNotifications as $notification)
                                                    @if($notification->data['type'] == 'favourite_product_change')
                                                        <?php $p = $notification->data['Product']  ?>
                                                        <li>{{ $notification->data['message'] }}.Updated Product code is {{ $p['code']}}. <a style="color:orange;" href="/productDetail/{{encrypt($p['product_id'])}}"> Check here</a></li>
                                                        <?php
                                                        $notification->markAsRead();
                                                        ?>
                                                    @elseif($notification->data['type'] == 'order_status_change')
                                                        <li>{{ $notification->data['message'] }}{{$notification->data['status']}} of order number {{$notification->data['order']['order_number']}}</li>
                                                        <?php
                                                        $notification->markAsRead();
                                                        ?>
                                                    @elseif($notification->data['type'] == 'ticket_accepted')
                                                        <?php $ticket = $notification->data['ticket'] ?>
                                                        <li>{{ $notification->data['message'] }}.Ticket number is {{$ticket['id']}}</li>
                                                        <?php
                                                        $notification->markAsRead();
                                                        ?>
                                                    @elseif($notification->data['type'] == 'ticket_solved')
                                                        <?php $ticket = $notification->data['ticket'] ?>
                                                        <li>{{ $notification->data['message']}}.Ticket number is {{$ticket['id']}}</li>
                                                        <?php
                                                        $notification->markAsRead();
                                                        ?>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li>No new notification</li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    @yield('navigation')
                </div>

            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Your Ticket</h4>
            </div>
            <form action="/create/ticket" method="POST">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <input name="title" class="form-control" type="text" placeholder="Title Of Ticket" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Description Of Ticket" maxlength="1000" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" value="Send" style="border: 2px solid orange; text-align: left;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@yield('slider')
@yield('content')
<div class="footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Service</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="">Online Help</a></li>
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Quock Shop</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="">Kids</a></li>
                        <li><a href="">Mens</a></li>
                        <li><a href="">Womens</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Policies</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="">Terms of Use</a></li>
                        <li><a href="">Privecy Policy</a></li>
                        <li><a href="">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>About Shopper</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="">About Us</a></li>
                        <li><a href="">Copyright</a></li>
                    </ul>
                </div>
            </div>
            @if(Auth::user())
                @if(Auth::user()->subscriber)
                @else
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>Subscribe Us</h2>
                            <form action="{{Route('user.subscribe')}}" class="searchform">
                                <input type="text" name="email" placeholder="Your email address" required />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...</p>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>Subscribe Us</h2>
                        <form action="{{Route('unauth.user.subscribe')}}" class="searchform">
                            <input type="text" name="email" placeholder="Your email address" required />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Get the most recent updates from <br />our site and be updated your self...</p>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright ©company All rights reserved.</p>
                <p class="pull-right">Developed by <span><a href=""></a></span></p>
            </div>
        </div>
    </div>

</footer><!--/Footer-->
<?php
$Notifications = [];
?>
@if(Auth::user())
    @foreach(Auth::user()->unreadNotifications as $notification)
        <?php
        array_push($Notifications,$notification->data);
        ?>
    @endforeach
@endif

<script src="/js/user/jquery.js"></script>
<script src="/js/user/bootstrap.min.js"></script>
<script src="/js/user/jquery.scrollUp.min.js"></script>
<script src="/js/user/price-range.js"></script>
<script src="/js/user/jquery.prettyPhoto.js"></script>
<script src="/js/user/main.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        var size = '{{sizeof($Notifications)}}';
        if(size !='0')$('#blue').text(size);
        $('#not-menu').click(function () {
            $('#blue').text('');
        });
        if(sessionStorage.getItem('productId')){
            if(JSON.parse(sessionStorage.getItem('productId')).length>0){
                $('#cartNotification').text(JSON.parse(sessionStorage.getItem('productId')).length);
            }
            else $('#cartNotification').text('');

        }
    });
</script>
@yield('scripts')
</body>
</html>
