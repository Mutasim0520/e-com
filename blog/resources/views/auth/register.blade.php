@if(Auth::guest())
    @extends('layouts.user.layout')
@endif
@section('title')
    <title>Register</title>
@endsection
@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="signup-form"><!--login form-->
                        <h2>Create Your Account</h2>
                        <form role="form" method="POST" action="/register">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input id="name" type="text" class="kalu" name="name" required placeholder="Enter Your Name">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="kalu" name="email" required placeholder="Enter Your Email">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="kalu" name="password" required placeholder="Enter Your Password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            <input id="name" type="text" class="kalu" name="mobile" required placeholder="Enter Your Contact Number" autofocus>

                            <select id="district" type="text" class="form-control" name="district" required autocomplete="on">
                                    <option value="">Select District</option>
                                    <option value="BARGUNA">BARGUNA</option>
                                    <option value="BARISAL">BARISAL</option>
                                    <option value="BHOLA">BHOLA</option>
                                    <option value="JHALOKATI">JHALOKATI</option>
                                    <option value="PATUAKHALI">PATUAKHALI</option>
                                    <option value="PIROJPUR">PIROJPUR</option>
                                    <option value="BANDARBAN">BANDARBAN</option>
                                    <option value="BRAHMANBARIA">BRAHMANBARIA</option>
                                    <option value="CHANDPUR">CHANDPUR</option>
                                    <option value="CHITTAGONG">CHITTAGONG</option>
                                    <option value="COMILLA">COMILLA</option>
                                    <option value="COX&#039;S BAZAR">COX&#039;S BAZAR</option>
                                    <option value="FENI">FENI</option>
                                    <option value="KHAGRACHHARI">KHAGRACHHARI</option>
                                    <option value="LAKSHMIPUR">LAKSHMIPUR</option>
                                    <option value="NOAKHALI">NOAKHALI</option>
                                    <option value="RANGAMATI">RANGAMATI</option>
                                    <option value="DHAKA">DHAKA</option>
                                    <option value="FARIDPUR">FARIDPUR</option>
                                    <option value="GAZIPUR">GAZIPUR</option>
                                    <option value="GOPALGANJ">GOPALGANJ</option>
                                    <option value="JAMALPUR">JAMALPUR</option>
                                    <option value="KISHOREGONJ">KISHOREGONJ</option>
                                    <option value="MADARIPUR">MADARIPUR</option>
                                    <option value="MANIKGANJ">MANIKGANJ</option>
                                    <option value="MUNSHIGANJ">MUNSHIGANJ</option>
                                    <option value="MYMENSINGH">MYMENSINGH</option>
                                    <option value="NARAYANGANJ">NARAYANGANJ</option>
                                    <option value="NARSINGDI">NARSINGDI</option>
                                    <option value="NETRAKONA">NETRAKONA</option>
                                    <option value="RAJBARI">RAJBARI</option>
                                    <option value="SHARIATPUR">SHARIATPUR</option>
                                    <option value="SHERPUR">SHERPUR</option>
                                    <option value="TANGAIL">TANGAIL</option>
                                    <option value="BAGERHAT">BAGERHAT</option>
                                    <option value="CHUADANGA">CHUADANGA</option>
                                    <option value="JESSORE">JESSORE</option>
                                    <option value="JHENAIDAH">JHENAIDAH</option>
                                    <option value="KHULNA">KHULNA</option>
                                    <option value="KUSHTIA">KUSHTIA</option>
                                    <option value="MAGURA">MAGURA</option>
                                    <option value="MEHERPUR">MEHERPUR</option>
                                    <option value="NARAIL">NARAIL</option>
                                    <option value="SATKHIRA">SATKHIRA</option>
                                    <option value="BOGRA">BOGRA</option>
                                    <option value="CHAPAINABABGANJ">CHAPAINABABGANJ</option>
                                    <option value="JOYPURHAT">JOYPURHAT</option>
                                    <option value="PABNA">PABNA</option>
                                    <option value="NAOGAON">NAOGAON</option>
                                    <option value="NATORE">NATORE</option>
                                    <option value="RAJSHAHI">RAJSHAHI</option>
                                    <option value="SIRAJGANJ">SIRAJGANJ</option>
                                    <option value="DINAJPUR">DINAJPUR</option>
                                    <option value="GAIBANDHA">GAIBANDHA</option>
                                    <option value="KURIGRAM">KURIGRAM</option>
                                    <option value="LALMONIRHAT">LALMONIRHAT</option>
                                    <option value="NILPHAMARI">NILPHAMARI</option>
                                    <option value="PANCHAGARH">PANCHAGARH</option>
                                    <option value="RANGPUR">RANGPUR</option>
                                    <option value="THAKURGAON">THAKURGAON</option>
                                    <option value="HABIGANJ">HABIGANJ</option>
                                    <option value="MAULVIBAZAR">MAULVIBAZAR</option>
                                    <option value="SUNAMGANJ">SUNAMGANJ</option>
                                    <option value="SYLHET">SYLHET</option>

                                </select>
                            <div style="margin-top: 15px; margin-bottom: 10px;"> 
                                <label class="radio-inline">
                                  <input type="radio" name="gender" id="optionsRadios1" value="Male"> <span> Male</span>

                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="gender" id="optionsRadios1" value="Female"> <span>Female</span>
                                </label>            
                            </div>
                                <button type="submit" class="btn">Register</button>
                            </form>
                    </div><!--/login form-->
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
