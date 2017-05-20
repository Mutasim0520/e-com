@extends('layouts.layout')

@section('styles')
    <link href=" https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin/bootstrap-tagging.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Orders</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped table-hover" width="100%" cellspacing="0" id="myTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Number</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Regeion</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Value</th>
                                <th>Log</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Number</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Regeion</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Value</th>
                                <th>Log</th>
                            </tr>
                            </tfoot>
                            <tbody id="fbody">
                            <?php $i = 0;?>
                            @foreach($Orders as $item)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td><a href="/admin/indivisualOrderDetail/{{encrypt($item['order_id'])}}">{{$item['order_number']}}</a></td>
                                    <td>{{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}</td>
                                    <td>{{$item['user']->name}}</td>
                                    <td>{{$item['city']}}</td>
                                    <td style="font-weight: bold;">
                                        @if(sizeof($item['admin'])>0)
                                            @foreach($item['admin'] as $item2)
                                                {{$item2['name']}}
                                            @endforeach
                                        @else
                                            <input placeholder="Assign employee" id="assigned_employee{{ $i }}" type="text"class="form-control">
                                            <button class="btn btn-primary" style="width: 100%;" onclick="employeeAssigner('{{$item['order_id']}}','{{$i}}')">assign</button>
                                        @endif
                                    </td>
                                    <td>{{$item['status']}}</td>
                                    <td>
                                        @if($item['used_point'])
                                            <?php
                                            echo (intval($item['order_value'])-intval($item['used_point']));
                                            ?>
                                        @else {{$item['order_value']}}
                                        @endif
                                        tk
                                    </td>
                                    <td><a href="/showLog/{{encrypt($item['order_id'])}}">Log</a></td>
                                </tr>
                                <?php $i = $i+1;?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/data-table.min.js" type="text/javascript"></script>
    <script src="/js/admin/bootstrap-tagging.js" type="text/javascript"></script>
    <script src="/js/admin/tapered.bundle.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                initComplete: function () {
                    this.api().columns([4,5,6,7]).every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });

            var old_assigned_employee = [];
            @foreach($Orders as $item)
              old_assigned_employee.push("{{$item['assigned_to']}}");
              console.log("got");
            @endforeach
         console.log(old_assigned_employee);

         ////tags input
            var employees = JSON.constructor({!!  json_encode($Employees)  !!});
            console.log(employees);
            var arr = [];
            var cities = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: employees
            });
            cities.initialize();

            for(var i =0; i<old_assigned_employee.length;i++){
                var elt = $('#assigned_employee'+i+'');
                elt.tagsinput({
                    itemValue: 'value',
                    itemText: 'text',
                    allowDuplicates: false,
                    interactive:true,
                    typeaheadjs: {
                        name: 'cities',
                        displayKey: 'text',
                        source: cities.ttAdapter()
                    }
                });
            }
            $('input[type = search]').addClass('form-control');
            $('select').addClass('form-control');
            $('#myTable_length').addClass('col-md-6');
            $('#myTable_length').css('border-bottom','1px solid #e9ecf2');
            $('#myTable_filter').addClass('col-md-6');
            $('#myTable_filter').css('border-bottom','1px solid #e9ecf2');


        });

        function employeeAssigner(id,index) {
            console.log(id);
            var employees = $('#assigned_employee'+index+'').val().split(',');
            $.ajax({
                type:'POST',
                url:'/admin/assignEmployee',
                data:{_token: "{{ csrf_token() }}", id:id, employees:employees
                },
                success: function( msg ) {
                    console.log(msg);
                    location.reload();
                }
            });
        }
    </script>
@endsection