@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>list of ips</h5> 
                        </div>
                        <div class="float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Add ip</a></p>
                        </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($ips as $ip)
                          <li class="list-group-item">
                                  {{$ip->ip_address}}
                                  <i class="fa fa-edit text-info fa-lg float-right" id="edit-button" onclick="edit({{$ip}})"></i>
                          </li>
                        @empty
                          <div class="alert alert-info text-center">
                            <b>No ips found</b>
                          </div>
                        @endforelse  
                    </ul>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

<!-- create team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add IP Address</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('setting.ip.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="input-group mb-4" >
                <div class="input-group-prepend">
                    <span class="input-group-text">IP Address</span>
                </div>
                <input  type="text" name="ip_address" class="form-control" placeholder="ip address">
              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
  <!-- /.modal -->

<!-- edit team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit IP Address</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('setting.ip.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="input-group mb-4" >
                <div class="input-group-prepend">
                    <span class="input-group-text">IP Address</span>
                </div>
                <input  type="text" name="ip_address" id="ip_address" class="form-control" placeholder="ip address">
              </div>
              <input  type="hidden" name="ip_id" id="ip_id">
              
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
  <!-- /.modal -->
@endsection

@section('scripts')
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

//modal to edit category
function edit(category){
    $('#ip_address').val(category.ip_address);
    $('#ip_id').val(category._id);
    $('#edit-modal').modal();
}

</script>
    
@endsection