<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin/datepicker3.css" rel="stylesheet">
    <link href="/css/admin/styles.css" rel="stylesheet">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('styles')
</head>

<body style="background-color: #80808033;">
<div class="main">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><span>Admin</span>Panle</a>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('admin/login') }}">Login</a></li>
                    @else
                        <li class="dropdown" id="not-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="glyphicon glyphicon-bell"><span id="Notification" class="badge red" style="background-color: orangered;"></span></span>
                            </a>
                            <ul class="dropdown-menu col-lg-6" role="menu"  style="width: 400px;text-align: justify; padding: 5px;">
                                @if(sizeof(Auth::user()->unreadNotifications)>0)
                                    @foreach(Auth::user()->unreadNotifications as $notification)
                                        @if($notification->data['type'] == 'employee_assign')
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}{{$notification->data['data']['order_number']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @elseif($notification->data['type'] == 'order_status_change')
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}{{$notification->data['status']}} of order number {{$notification->data['order']['order_number']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @elseif($notification->data['type'] == 'productChangeByEmployee')
                                            <?php
                                                $n = $notification->data['Product'];
                                            ?>
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}of Product number {{$n['product_id']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @elseif($notification->data['type'] == 'new_ticket_generation')
                                            <?php
                                            $n = $notification->data['ticket'];
                                            ?>
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}. Ticket id is {{$n['id']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @elseif($notification->data['type'] == 'assign_ticket_to_employee')
                                            <?php
                                            $n = $notification->data['ticket'];
                                            ?>
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}. Ticket id is {{$n['id']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @elseif($notification->data['type'] == 'ticket_solved')
                                            <?php
                                            $n = $notification->data['ticket'];
                                            $employee = $notification->data['employee'];
                                            ?>
                                            <li class="col-lg-6" style="width: 385px; border-bottom:1px solid grey; ">{{ $notification->data['message'] }}. Ticket id is {{$n['id']}}. Solved by: {{$employee['name']}}</li>
                                            <?php
                                            $notification->markAsRead();
                                            ?>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="col-lg-6" style="width: 385px;border-bottom:1px solid grey; ">No new notification</li>
                                @endif

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><svg style="height:18px; width: 20px;" class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                   </ul>
            </div>

        </div><!-- /.container-fluid -->
    </nav>

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar" style="vertical-align: middle;">
        <ul class="nav menu" style="vertical-align: middle;">
            @if(Auth::user()->role == 'super')
                <li><a href="{{Route('admin.index')}}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
                <li><a href="/productList"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>Products</a></li>
                <li><a href="/addProduct"><svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg> Add Product</a></li>
                <li><a href="{{Route('admin.orders')}}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Orders</a></li>
                <li><a href="{{Route('employee.register')}}"><svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg> Add Employee</a></li>
                <li><a href="/admin/user/register"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg> Create User</a></li>
                <li><a href="{{Route('admin.employee.management')}}"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg> Employee Mangement</a></li>
                <li><a href="{{Route('admin.user.management')}}"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg> User Mangement</a></li>
                <li><a href="{{Route('admin.create.order')}}"><svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg> Create Order</a></li>
                <li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Ticket Management
                    </a>
                    <ul class="children collapse" id="sub-item-1">
                        <li>
                            <a class="" href="{{Route('admin.new.tickets')}}">
                                <svg class="glyph stroked chain"><use xlink:href="#stroked-chain"/></svg> New Generated Tickets
                            </a>
                        </li>
                        <li>
                            <a class="" href="{{Route('admin.accepted.tickets')}}">
                                <svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg> Accepted Tickets
                            </a>
                        </li>
                    </ul>
                </li>

            @else
                <li><a href="{{Route('employee.index')}}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
                <li><a href="/employee/productList"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Products</a></li>
                <li><a href="/employee/addProduct"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Add Product</a></li>
                <li><a href="{{Route('employee.orders')}}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Orders</a></li>
                <li><a href="/employee/user/register"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Create User</a></li>
                <li><a href="{{Route('employee.user.management')}}"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg> User Mangement</a></li>
                <li>
                    <a class="" href="{{Route('employee.accepted.tickets')}}">
                        <svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg> Tickets
                    </a>
                </li>

            @endif{{--<li><a href="forms.html"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Forms</a></li>--}}
                 </ul>

    </div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        @yield('page-header')
        <div class="row">
            @yield('content')
        </div><!--/.col-->
    </div><!--/.row-->
</div>	<!--/.main-->
<?php
    $Notifications = [];
?>
    @foreach(Auth::user()->unreadNotifications as $notification)
        <?php
            array_push($Notifications,$notification->data);
        ?>
    @endforeach

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="/js/admin/lumino.glyphs.js"></script>
<script>
    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
<script>
    $(document).ready(function () {
        var size = '{{sizeof($Notifications)}}';
        if(size !='0')$('#Notification').text(size);
        $('#not-menu').click(function () {
            $('#Notification').text('');
        });
    });
</script>
@yield('scripts')
</body>

</html>
