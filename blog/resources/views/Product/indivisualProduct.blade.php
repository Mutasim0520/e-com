@extends('layouts.layout')
@section('styles')
@endsection
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Product Detail</h3>
        </div>
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel panel-body" style="text-align: center">
                        @foreach($Photo->photo as $item)
                            <img src="/images/{{$item->url}}" alt="image not found" style="width: 314px; height: 403px"/>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-sm-offset-1 col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Product Detail</div>
                    <div class="panel panel-body">
                        <div class="p_d">
                            <span style="font-weight: bold">Product Name: </span>
                            <span>{{ $Product->title }}</span>
                        </div>
                        <div class="p_d"><span style="font-weight: bold">Description: </span>  <span><?php echo $Product->description; ?></span></div>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Colors</th>
                                    <th>Sizes</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Type</th>
                                    <th>Catagory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $Product->code }}
                                    </td>
                                    <td>
                                        @foreach($Color->color as $item)
                                            <span style="background-color: {{ $item->color }}; color: {{ $item->color }}">pp</span>
                                            <span> {{ $item->color }} </span><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(sizeof($Size->size)>0)
                                            @foreach($Size->size as $item)
                                                    <span> {{ $item->size }}  </span><small>({{$item->quantity}})</small><br>
                                            @endforeach
                                        @else No size available
                                        @endif
                                    </td>
                                    <td> {{ $Product->quantity }}</td>
                                    <td>
                                          {{ $Product->price }}.00 tk
                                    </td>
                                    <td>
                                        {{ $Product->discout }} %
                                    </td>
                                    <td>{{ $Product->gender }}</td>
                                    <td>{{ $Product->catagory }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection