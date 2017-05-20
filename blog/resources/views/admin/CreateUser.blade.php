@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">Create User</div>
                    <div class="panel-body">
                        <form method="post" action="/admin/user/register/">
                            {{csrf_field()}}
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input class="form-control" type="text"  name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input class="form-control" type="email"  name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>password</label>
                                <input class="form-control" type="password"  name="password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input class="form-control" type="text"  name="phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Select District</label>
                                <select class="form-control"  name="district" required autocomplete="on">
                                    <option value="">Select District</option>
                                    @foreach($Districts as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Female">Female
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Male">Male
                                </label>
                            </div>
                            <div class="form-group col-md-12" style="text-align: center;">
                                <input class="btn btn-primary"  type="submit" value="Create User">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection