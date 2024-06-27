@extends('template.header-footer')

@section('content')
    <style>
        .main {
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            margin-top: 20px;
        }
        .badge {
            color: #000000;
        }
    </style>

    <main id="main" class="main">
        <div class="row mb-4">
            <div class="col-lg-12 margin-tb">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Show Role</h2>
                    <a class="btn btn-primary" href="{{ route('role.index') }}">Back</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                    <label><strong>Name:</strong></label>
                    <p>{{ $role->name }}</p>
                </div>
                <div class="form-group">
                    <label><strong>Permissions:</strong></label>
                    <div>
                        @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $v)
                                <span class="badge badge-success">{{ $v->name }}</span>
                            @endforeach
                        @else
                            <p>No permissions assigned to this role.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
