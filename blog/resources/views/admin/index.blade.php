@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-blue panel-widget ">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$newOrder}}</div>
                            <div class="text-muted">New Orders</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-red panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$newUser}}</div>
                            <div class="text-muted">New Users</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-teal panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$user}}</div>
                            <div class="text-muted">Total Users</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-orange panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked wireless router"><use xlink:href="#stroked-wireless-router"/></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$subscriber}}</div>
                            <div class="text-muted">Subscriber</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">
                        Point Management<br>
                    </div>
                    <div class="panel-body">
                        @if($point[0]->status == '1')
                            <h4 style="text-align: center; color: darkblue;">Point Usage Previlage "On"</h4>
                            <h5 style="text-align: center; color: darkblue;">Given At:{{$point[0]->updated_at}}</h5>
                            <h5 id="last_dis" style="text-align: center; color: darkblue;">Given Discount:{{$point[0]->discount}}% </h5>
                        @else
                            <h4 style="text-align: center; color: darkblue;">Point Usage Previlage "Off"</h4>
                        @endif
                        <form action="javascript:pointChanger();">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Point Using </label><br>
                                <label>ON</label><input type="radio" name="point-switch" value = "1">
                                <label>OFF</label><input type="radio" name="point-switch" value = "0">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="point-discount" type="hidden" placeholder="Highest allowed discount">
                            </div>
                            <div class="form-group">
                                <button id="point-button" style="display: none; float: right;" class="btn btn-default">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">Order Products</div>
                    <div class="panel-body">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Product ID</th>
                                <th>Number Of Order</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $k = 1; ?>
                            @foreach($OrderedProduct as $item)
                                <tr>
                                    <td>{{$k}}</td>
                                    <td><a href="/indivisualProduct/{{encrypt($item->product_id)}}">{{$item->product_id}}</a></td>
                                    <td>{{$item->count}}</td>
                                </tr>
                                <?php $k++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Websites Slide Management</div>
                        <div class="panel-body">
                            <button id="add-slide-button" class="btn btn-default">Add New Slide</button>
                            @if(sizeof($Slide)>0)
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Operation</th>
                                    </thead>
                                    <tbody>
                                    <?php $k =1; ?>
                                        @foreach($Slide as $item)
                                            <tr>
                                                <td>{{$k}}</td>
                                                <td>{{$item->title}}</td>
                                                @if($item->description)
                                                    <td>{{$item->description}}</td>
                                                    @else<td>No Description Given</td>
                                                @endif
                                                <td><img src="/images/user/slides/{{$item->url}}" style="height:50px; width: 85px;border: 1px solid black;"></td>
                                                <td><a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="/admin/deleteSlide/{{$item->id}}" target="_blank">Delete</a>
                                                </td>
                                            </tr>
                                            <?php $k = $k+1; ?>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                            <div id="slide-container" style="display: none;">
                                <form action="/admin/addSlide" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label>Slide Title</label>
                                        <input class="form-control" type="text" name="slide_title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Slide Description</label>
                                        <textarea class="form-control" type="text" name="slide_description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Photo</label>
                                        <input class="form-control" type="file" name="file" accept="image/*" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="Save">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading dark-overlay">
                            Catagory Management
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9" style="border-right:2px gray; ">
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Male Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Male')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Female Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Female')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Kids Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Kids')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a id="cata-button" class="btn btn-default" href="javascript:showCatagoryContainer();">Add New Catagory</a>
                                <div id="catagory-container" style="display: none">
                                    <form id="catagory_form" method="post" action="{{Route('admin.add.catagory')}}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Select Type</label><br>
                                            <input type="radio" name="catagory_type" value="Male" required><label>Male</label>
                                            <input type="radio" name="catagory_type" value="Female"><label>Female</label>
                                            <input type="radio" name="catagory_type" value="Kids"><label>Kids</label>
                                        </div>
                                        <div class="form-group">
                                            <label>Catagory Name</label>
                                            <input class="form-control" type="text" name="catagory_name" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control btn-success" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading dark-overlay">Size Management</div>
                        <div class="panel-body">
                        <div class="col-md-6">
                        @foreach($Avilable_size as $item)
                            <div class="col-md-2">{{$item->size}}</div>
                        @endforeach
                        </div>

                            <div class="col-md-3">
                                <div><button id="add-size" class="btn btn-default">Add New Size</button><br></div>
                            <div id="size_container" style="display: none;">
                                <form id="sizeForm" method="POST" action="{{Route('save.size')}}">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input name="size" type="text" placeholder="Enter Size" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="save" class="btn btn-success">
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script src="/js/admin/validations/sizeValidator.js"></script>
    <script src="/js/admin/validations/catagoryValidator.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#add-size').click(function () {
                $('#size_container').show();
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });

            $('#add-slide-button').click(function () {
                $('#slide-container').show();
            });

            var Switch = '{{$point[0]->status}}';
            $('input[name=point-switch][value = '+Switch+']').attr('checked',true);
            if(Switch == '1'){
                $('#last_dis').show();
            }

            $('input[name=point-switch]').change(function () {
                $('#point-button').show();
                console.log($('input[name=point-switch]:checked').val());
                if($('input[name=point-switch]:checked').val()=="1"){
                    $('input[name=point-discount]').attr('type','text');
                    $('input[name=point-discount]').attr('required',true);
                }
                else if($('input[name=point-switch]:checked').val()=="0") {
                    $('input[name=point-discount]').attr('type','hidden');
                    $('input[name=point-discount]').attr('required',false);
                    console.log(1);
                }
            });
        });
        function pointChanger() {
            var status = $('input[name=point-switch]:checked').val();
            var id = '{{$point[0]->id}}';
            if(status == '1'){
                var point_discount = $('input[name=point-discount]').val();
            }
            else var point_discount = 0;

            $.ajax({
                type:'POST',
                url:'/admin/changePointDiscount',
                data:{_token: "{{ csrf_token() }}", status:status, point_discount:point_discount, id:id
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
        function showCatagoryContainer() {
            $('#catagory-container').show();
            $('#cata-button').hide();
        }
    </script>
@endsection