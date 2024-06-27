@extends('template.header-footer')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if($user->photo)
                <img src="{{ Storage::url($user->photo) }}" alt="Profile" class="rounded-circle">
            @else
                <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            @endif
            <h2>{{ $user->name }}</h2>
            <h3>
                @foreach ($user->roles as $role)
                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </h3>
        </div>
    </div>
</div>
@endsection
