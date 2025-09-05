@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

<style>
  .black{ color:#000; background:#f2f5fa; padding:20px 20px; border-radius:0 4px 4px 0; }
  .black:hover{ background:#fff; padding:20px 20px; color:#4295d2; }
  .content-page { overflow:hidden; margin-left:300px; }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

@section('content')
<div id="content-page" class="content-page">
  <div class="mt-5 d-flex">
    <a class="black" href="{{ URL::to('admin/livestreams') }}">All Livestreams</a>
    <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Livestream</a>
  </div>

  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-sm-12">
        <div class="iq-card">
          <div class="col-md-12 iq-card-header">
            <div class="row p-1 m-1 mb-2">
              <div class="col-md-7"><h4> Move Livestreams CPP </h4></div>
            <div>
          </div>
          </hr>

          <div class="iq-card-body table-responsive p-0" style="margin-top:2rem;">
            <form action="{{ URL::to('/admin/move/livestream-cpp-partner') }}" method="post">
              <div class="row d-flex col-md-12 p-1 m-1" style="margin-top:2rem;">

                <div class="col-md-6">
                  <label for="">Choose Content Partner</label>
                  <select name="cpp_users" class="form-control" id="cpp_users">
                    @foreach(@$ModeratorsUser as $value)
                      <option value="{{ $value->id }}">{{ $value->username }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="">Choose Livestream (*To Be Moved)</label>
                  <select name="livestream_id" class="form-control" id="livestream_id">
                    @foreach(@$livestreams as $value)
                      <option value="{{ $value->id }}">{{ $value->title }}</option>
                    @endforeach
                  </select>
                </div>

              </div>

              <div class="row d-flex col-md-12 p-1 m-1">
                <div class="col-md-4">
                  <label for="">CPP Commission (%)</label>
                  <input type="number" class="form-control" name="CPP_commission_percentage" min="0" max="100" step="1" placeholder="Optional">
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button type="submit" class="btn btn-primary" value="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
