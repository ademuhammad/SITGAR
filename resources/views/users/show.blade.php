@extends('template.header-footer')
@section('content')
    <style>
        .main {
            padding: 20px;
        }

        .user-details-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .user-details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-details-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            color: #ffffff;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group strong {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: #333;
        }

        .badge {
            background-color: #28a745;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 14px;
        }
    </style>
    <main id="main" class="main">
        <div class="user-details-card">
            <div class="user-details-header">
                <h2>Detail User</h2>
                <a class="btn btn-success" href="{{ route('user.index') }}">Kembali</a>
            </div>

            <div class="form-group">
                <strong>Nama:</strong>
                <span>{{ $user->name }}</span>
            </div>
            <div class="form-group">
                <strong>Email:</strong>
                <span>{{ $user->email }}</span>
            </div>
            <div class="form-group">
                <strong>Roles:</strong>
                @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $v)
                        <label class="badge">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
@endsection
