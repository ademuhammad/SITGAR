@extends('template.header-footer')

@section('content')
    <main id="main" class="main">

        <section class="section profile">
            <div class="container">
                <h1>My Profile</h1>
                <div class="card">
                    <div class="card-header">
                        Profile Information
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <!-- Add other profile fields here -->
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                  <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                  <h2>{{ $user->name }}</h2>
                  <h3>   @foreach ($user->roles as $role)
                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach</h3>

                </div>
              </div>
        </section>
    </main>
@endsection
