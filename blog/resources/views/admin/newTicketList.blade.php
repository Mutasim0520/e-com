@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">New Tickets</h3>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(sizeof($Tickets)>0)
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket Number</th>
                                <th>Ticket Subject</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Mark as Accepted</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket Number</th>
                                <th>Ticket Subject</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Mark as Accepted</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($Tickets as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><a href="#" data-toggle="modal" data-target="#myModal{{$i}}">{{$item->id}}</a></td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item['user']->name}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a class="btn btn-large btn-primary" href="javascript:ticketStatusChanger({{$item->id}});">Accepted</a>
                                        <a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="javascript:deleteEmployee({{$item->id}})" target="_blank">Delete</a>
                                    </td>
                                </tr>
                                <?php $i = $i+1; ?>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No New Records</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <?php $k=1; ?>
    @foreach($Tickets as $item)
        <div class="modal fade" id="myModal{{$k}}" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ticket Detail</h4>
                    </div>
                    <div class="modal-body">
                        <label>Title: </label><span>{{$item->title}}</span><br>
                        <label>Detail:</label>
                        <p>{{$item->description}}</p>
                        <label>Issued By: </label><span>{{$item['user']->name}}</span><br>
                        <label>Email: </label><span>{{$item['user']->email}}</span><br>
                        <label>Phone: </label><span>{{$item['user']->mobile}}</span><br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php  $k = $k+1;?>
    @endforeach
@endsection

@section('scripts')
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script>
        $(document).ready(function () {

        });
        function ticketStatusChanger(id) {
            $.ajax({
                type:'POST',
                url:'/admin/changeTicketStaus',
                data:{_token: "{{ csrf_token() }}", id:id, status:'Pending'
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
        {{--function showCatagoryContainer() {--}}
            {{--$('#catagory-container').show();--}}
            {{--$('#cata-button').hide();--}}
        {{--}--}}
    </script>
@endsection