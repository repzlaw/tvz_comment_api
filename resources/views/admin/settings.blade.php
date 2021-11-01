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
                            <h5>Settings</h5> 
                        </div>
                        {{-- <div class="float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Policies</a></p>
                        </div> --}}
                    </div> 
                    <ul class="list-group list-group-flush">
                        {{-- <li class="list-group-item">
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-10" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">reCAPTCHA Enable</span>
                                </div>
                                <select class="form-control custom-select" name="captcha_enable" id="captcha_enable" required>
                                  <option value="0">disable </option>                           
                                  <option value="1">enable </option>                           
                              </select>
                              <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Save</button>
                              </div>
                            </div>
                          </form>
                        </li>
                        <li class="list-group-item">
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-10" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">reCAPTCHA Site Key</span>
                                </div>
                                <input type="text" name="captcha_site_key" class="form-control"  value="{{ $captcha_site_key }}" required>
                                <div class="input-group-append">
                                  <button class="btn btn-success" type="submit">Save</button>
                              </div>
                            </div>
                          </form>
                        </li> --}}
                        
                      <li class="list-group-item">
                        <div>
                          <p>List of white listed IP addresses</p>
                          <a class="btn btn-outline-primary" href="/settings/ip-address">View IP addresses</a>
                        </div>
                      </li>

                      <li class="list-group-item">
                        <div>
                          <p>Generate API key </p>
                          <form action="{{ route('setting.api_key.generate')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-9" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">API Key</span>
                                </div>
                                <input type="text" name="api_key" class="form-control"  value="{{$api_key}} " disabled>
                                <div class="input-group-append">
                                  <button class="btn btn-success" type="submit">Generate</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </li>
                      <li class="list-group-item"></li>

                    </ul>
                    
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