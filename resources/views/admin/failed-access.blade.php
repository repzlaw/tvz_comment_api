@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5> Failed Access Logs</h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                    <p>page {{ $logs->currentPage() }} of {{ $logs->lastPage() }} , displaying {{ count($logs) }} of {{ $logs->total() }} record(s) </p>

                        <table id="log_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th width="3%">#</th>
                                <th width="9%">IP address</th>
                                <th>Header Info</th>
                                <th width="7%">Status code</th>
                                <th width="15%">Description</th>
                                <th width="10%">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key =>$log)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$log->ip_address}}</td>
                                        <td>{{$log->header_info}}</td>
                                        <td>{{$log->status_code}}</td>
                                        <td>{{$log->description}}</td>
                                        <td>{{$log->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links() }}
                        
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

@endsection

@section('scripts')
<script>


</script>
    
@endsection