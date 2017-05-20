@extends('layouts.user.layout')
@section('title')
<title>Account Settings</title>
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
        <div class="hlk"></div>
        <div class="container prd_con">
            <div class="row">
                <div class="col-sm-12 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-12">
                            <div class="col-sm-8">
                                <h4 style="text-align: justify; color: orange;">Account Information & Settings</h4>
                                <strong>Hello {{$User->name}}</strong><br>
                                <p>Having great time with us? Here you can see your personal information and change those information.</p>
                                <a class="normal-links" href="#" data-toggle="modal" data-target="#myModal_change_setting"><i class="fa fa-lock"></i> Change Personal Informations</a><br>
                                <a class="normal-links" href="#" data-toggle="modal" data-target="#myModal_change_password"><i class="fa fa-lock"></i> Reset Password</a>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12" style="text-align: center;">
                                    <img src="/images/user/icon/user.png" style="max-height:25%;max-width:27%; ">
                                </div>
                                <div class="col-sm-12"style="text-align: center;">
                                    <strong>{{$User->name}}</strong></br>
                                    <strong>{{$User->email}}</strong></br>
                                    <strong>{{$User->mobile}}</strong></br>
                                    <strong>{{$User->district}}</strong></br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="myModal_change_setting" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Your Information</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="/update/personalinfo/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="name" class="form-control" placeholder="Your Name" type="text" value="{{$User->name}}" required>
                        </div>
                        <div class="form-group">
                            <input name="email" class="form-control" placeholder="Your email" type="email" value="{{$User->email}}" required>
                        </div>
                        <div class="form-group">
                            <input name="mobile" class="form-control" placeholder="Your Phone Number" type="text" value="{{$User->mobile}}" required>
                        </div>
                        <div class="form-group">
                            <select id="dis" name="district" class="form-control" autocomplete="on">
                                @foreach($Districts as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Save" style="border: 2px solid orange;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_change_password" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="/update/password/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="password" class="form-control" placeholder="New Password" type="password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Save" style="border: 2px solid orange;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var pre_dis = '{{$User->district}}';
            $('#dis option[value='+pre_dis+']').attr('selected','selected');
            console.log(pre_dis);
        });
    </script>
@endsection