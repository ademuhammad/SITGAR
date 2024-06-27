@extends('template.header-footer')

@section('content')
    <style>
        .main {
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .alert-danger {
            margin-top: 20px;
        }

        .form-check {
            margin-bottom: 10px;
        }
    </style>

    <main id="main" class="main">
        <div class="row mt-4">
            <div class="col-lg-12 margin-tb">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Create New Role</h2>
                    <a class="btn btn-primary" href="{{ route('role.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['route' => 'role.store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                    <label for="name"><strong>Name:</strong></label>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="permissions"><strong>Permissions:</strong></label>
                    <div id="permissions" class="row">
                        @php
                            $chunkedPermissions = $permission->chunk(ceil($permission->count() / 2));
                        @endphp

                        @foreach ($chunkedPermissions as $chunk)
                            <div class="col-md-6">
                                @foreach ($chunk as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permission[]"
                                            value="{{ $value->name }}" id="permission{{ $value->id }}">
                                        <label class="form-check-label" for="permission{{ $value->id }}">
                                            {{ $value->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </main>
    <script>
        $(document).ready(function() {
            $('#select-all').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });
        });
    </script>
@endsection
