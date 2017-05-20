@extends('layouts.layout')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <style>
        .thumb {
            height: 75px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
        }
    </style>
@endsection

@section('content')
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Product</div>
                <div class="panel-body">
                    @if(Auth::user()->role == 'super')
                        <?php $url = '/storeProduct'; ?>
                    @else
                        <?php $url = '/employee/storeProduct'; ?>
                    @endif
                    <form id="baal" role="form" method="post" action={{ $url }} enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Title</label>
                                <input class="form-control" name="title" required>
                            </div>
                            <div class="form-group">
                                <label>Product Detail</label>
                                <textarea class="form-control ckeditor" id="detail" name="detail" required></textarea>
                            </div>
                            <div class="form-group">
                                <label id="color">Available Color</label>
                                <div class="pl">
                                    <div  class="input-group colorpicker-component cp" id="color_1">
                                        <input type="text" value="#00AABB" class="form-control" name="color_1" />
                                        <span class="input-group-addon"><i id="rgb_1" onchange="setRGB(1)"></i></span>
                                        <a data-toggle="tooltip" title="More color" id="add-color" href="#" style="float:left; padding-bottom: 6px;margin-left: 5px; margin-right: -12px;">
                                            <span><svg style="height: 20px; width: 20px;" class="glyph stroked plus sign">
                                                    <use xlink:href="#stroked-plus-sign"/></svg></span></a>
                                    </div>
                                </div>

                                <input id="color_count" type="hidden" name="color_counter">
                            </div>
                            <div class="form-group">
                                <label>Upload image</label>
                                <input type="file" id="files" name="file">
                                <output id="list"></output>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox"  name="discount_label">Discount (In Percentage)
                                <input type="hidden" name="discount" class="form-control" value="0"></label>
                        </div>
                        <div class="form-group">
                            <label>Product Code</label>
                            <input class="form-control" name="code" required>
                        </div>
                        <div class="form-group">
                            <label>Product Type</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="Male" required>Male Product
                                </label>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="Female">Female Product
                                </label>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios3" value="Kids">Kids Product
                                </label>
                            </div>
                        </div>
                        <div class="form-group"  style="display: none;" id="female-catgory" >
                            <label>Select Catagory</label>
                            <select class="form-control" name = "catagory_female">
                                <option value = "">Select Catagory</option>
                                @foreach($Catagory as $item)
                                   @if($item->catagory_type == 'Female')
                                        <option value = "{{$item->catagory_name}}">{{$item->catagory_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"  style="display: none;" id="male-catgory" >
                            <label>Select Catagory</label>
                            <select class="form-control" name="catagory_male">
                                <option value="">Select Catagory</option>
                                @foreach($Catagory as $item)
                                    @if($item->catagory_type == 'Male')
                                        <option value = "{{$item->catagory_name}}">{{$item->catagory_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"  style="display: none;" id="kid-catgory" >
                            <label>Select Catagory</label>
                            <select class="form-control" name="catagory_kid">
                                <option value="">Select Catagory</option>
                                @foreach($Catagory as $item)
                                    @if($item->catagory_type == 'Kids')
                                        <option value = "{{$item->catagory_name}}">{{$item->catagory_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Avaiable Size</label>
                            <label><input type="checkbox" name="has_size"></label>
                            <input type="hidden" name="size" value="0">
                            <div id="size_container" style ="display:none;">
                                @foreach($Sizes as $size)
                                    <div class="checkbox">
                                        <div class="col-md-2">
                                            <label>
                                                <input type="checkbox" value="{{$size->size}}" name="size_{{$size->size}}"><?php echo $size->size;?>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label id="{{$size->size}}"><input name="{{$size->size}}_quantity" class="form-control" style="display: inline-block" type="number" name="quantity" min="1" max="1000"></label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="quantity_container">
                                <label>Quantity</label>
                                <input type="text" class="form-control" name="quantity" required>
                            </div>
                        </div>

                    </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                        <input type="hidden" id="color_rgb_1" name="color_rgb_1" value="rgb(0,0,0)">
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
    <script>
        $('input[name=has_size]').change(function () {
            if($('input[name=has_size]').is(":checked")){
                $('#size_container').show();
                $('input[name=quantity]').removeAttr('required');
                $('#quantity_container').css('display','none');
                $('input[name=size]').val(1);
            }

            else{
                $('#size_container').css('display','none');
                $('input[name=quantity]').attr('required',true);
                $('#quantity_container').show();
                $('input[name=size]').val(0);
            }
        });
        $('input[name=discount_label]').change(function () {
            if($('input[name=discount_label]').is(":checked")){
                $('input[name=discount]').attr('type','text');
                $('input[name=discount]').attr('required',true);
            }
            else{
                $('input[name=discount]').attr('type','hidden');
                $('input[name=discount]').removeAttr('required');
            }
        });
            <?php
            foreach ($Sizes as $item){
            ?>
        $("input[name=size_{{trim($item->size)}}]").change(function () {
            if( $("input[name=size_{{trim($item->size)}}]").is(":checked")){
                console.log('got it');
                $("input[name={{trim($item->size)}}_quantity]").attr('required',true);
            }
            else  $("input[name={{trim($item->size)}}_quantity]").removeAttr('required');
            //console.log($("input[name=size_{{trim($item->size)}}:checked]"));
        });

        <?php
            }
        ?>
        $(document).ready(function() {
            $(function () {
                $('#color_1').colorpicker({
                    color: 'rgb(0,0,0)',
                    format: 'rgb',
                    colorSelectors: {
                        'black': '#000000',
                        'white': '#ffffff',
                        'red': '#FF0000',
                        'gray': '#777777',
                        'green': '#5cb85c',
                        'blue': '#5bc0de',
                        'yellow':'#ffff00',
                        'pink':'#ff00ff',
                        'brown':'#cc0000',
                        'orange':'#ff8000'
                    }
                }).on('changeColor', function() {
                    setRGB(this);
                });
            });
            var counter = 1;
            var c;
            $('#color_count').val(counter);
            $('#add-color').click(function (event) {
                event.preventDefault();
                counter = counter+1;
                console.log(counter);
                $(".pl").append('<div class="input-group colorpicker-component cp" id="color_'+ counter +'" style=" width: 469.4px; margin-top: 5px">'+
                    '<input type="text" value="#00AABB" class="form-control" name="color_'+counter +'">'+
                    ' <span class="input-group-addon">'+
                    '<i id="rgb_'+counter+'" onchange="setRGB('+counter+')"></i></span>'+'</div>');
                $("#baal").append('<input type="hidden" id="color_rgb_'+counter+'" name="color_rgb_'+counter+'" value="rgb(0,0,0)">');

                    $('#color_count').val(counter);
                $(function () {
                    $('#color_'+counter+'').colorpicker({
                        color: 'rgb(0,0,0)',
                        format: 'rgb',
                        colorSelectors: {
                            'black': '#000000',
                            'white': '#ffffff',
                            'red': '#FF0000',
                            'gray': '#777777',
                            'green': '#5cb85c',
                            'blue': '#5bc0de',
                            'yellow':'#ffff00',
                            'pink':'#ff00ff',
                            'brown':'#cc0000',
                            'orange':'#ff8000'
                        }
                    }).on('changeColor', function() {
                        setRGB(this);
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                });
            });

            $('#remove-color').click(function (event) {
                event.preventDefault();
                console.log(counter);
                $('#color_'+ counter +'').remove();
                counter = counter-1;
                $('#color_count').val(counter);
            });


            $('.radio').change(function () {
                var type = $('input[name=optionsRadios]:checked').val();
                if (type == "Male"){
                    $('#male-catgory').show();
                    $('#female-catgory').hide();
                    $('#kid-catgory').hide();
                }
                else if(type == "Female") {
                    $('#male-catgory').hide();
                    $('#female-catgory').show();
                    $('#kid-catgory').hide();
                }
                else{
                    $('#male-catgory').hide();
                    $('#female-catgory').hide();
                    $('#kid-catgory').show();
                }
            });

            function handleFileSelect(evt) {
                var files = evt.target.files; // FileList object

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                        return function(e) {
                            // Render thumbnail.
                            var span = document.createElement('span');
                            span.innerHTML = ['<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
                            document.getElementById('list').insertBefore(span, null);
                        };
                    })(f);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            }

            document.getElementById('files').addEventListener('change', handleFileSelect, false);
        });
        CKEDITOR.replace( 'detail',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            })
        function setRGB(index) {
            var id = (index.id).split('_')[1];
            console.log(id)
            $("#color_rgb_"+id).val(document.getElementById('rgb_'+id).style.backgroundColor);
        }
    </script>
@endsection