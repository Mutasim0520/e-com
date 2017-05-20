@extends('layouts.user.layout')
@section('title')
<title>LogIn</title>
@endsection
@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="login-form"><!--login form-->
                        <h2>Login to your account</h2>
                        <form method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input class="kalu"  id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Email Address"/>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input class="kalu" id="password" type="password" name="password" required placeholder="Password"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" style="margin-top: 3px;" class="checkbox-inline" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn">Login</button>
                        </form>
                    </div><!--/login form-->
                    <a href="/login/facebook" class="btn"> Log in with facebook

                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <h2 class="or">OR</h2>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-offset-3 col-md-6">
                    <div class="signup-form"><!--login form-->
                        <a href="/register"><h2>Create Your Account</h2></a>
                    </div><!--/login form-->
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
