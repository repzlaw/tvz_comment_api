@extends('layouts.app')
@section('style')
    a:visited {
        color: #1a0dab;
    }
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                {{-- <div class="row">
                    <div class="col-7">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Admin Login
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                   
                                </div>
                            </div>
                        </div>

                </div>

            </div> --}}
         <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
