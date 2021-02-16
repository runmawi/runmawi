@include('header')

<div class="container  page-height">
    <div class="row justify-content-center">

        <div class="card" style="margin-top: 30px;">
                  
            <div class="col-md-8 col-sm-offset-2">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header col-form-label"><h1>{{ __('Phone Number') }}</h1></div>
			</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('nexmo') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-sm-offset-1 col-form-label text-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-5">
                                <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-5 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mobile Verification') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@extends('footer')
