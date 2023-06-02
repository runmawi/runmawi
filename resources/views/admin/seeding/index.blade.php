@extends('admin.master')

@include('admin.favicon')

@include('admin.cache.style')

@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid p-0">
            <div id="webhomesetting">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Seeding Management</h4>
                        </div>
                    </div>

                    <div class="panel panel-primary mt-3" data-collapsed="0">

                        <div class="panel-body">
                            <div class="align-items-center p-2">
                                <div class="col-sm-5">
                                    <label class="m-0">Seeding:</label>
                                    <p class="p1">Select the Seed class in the below box:</p>
                                    <div class="panel-body">
                                        <form method="POST" action="{{ route('seeding-run') }}" class="form-horizontal"
                                            id="seedingForm">
                                            @csrf
                                            <div class="form-group">
                                                <select name="seed_class" class="form-control">
                                                    <option value="">{{ ucwords('select the seeding class') }}</option>
                                                    @foreach ($seederClasses as $seed)
                                                        <option value="{{ $seed }}">{{ $seed }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="panel-body">
                                                <div class="align-items-center p-2">
                                                    <div class="mt-1 d-flex align-items-justify-content-right">
                                                        <button class="button-87 pull-right" id="seedingButton"
                                                            type="button">Seeding</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@section('javascript')

    <script>
        document.getElementById('seedingButton').addEventListener('click', function(event) {
            event.preventDefault();

            var password = prompt("Please Enter your correct password (Only for developers):");

            if (password !== null && password.trim() == "13579@$^*)") {
                document.getElementById('seedingForm').submit(); // Submit the form
            } else {
                alert("Incorrect Password / Action cancel.");
            }

        });

        @if (session('success'))
            alert("{{ session('success') }}");
        @endif

        @if (session('failure'))
            alert("{{ session('failure') }}");
        @endif
    </script>
@stop
@stop
