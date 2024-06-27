@extends('template.header-footer')

@section('content')
    <main id="main" class="main">

        <section class="section profile">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="photo">Profile Photo</label>
                                <input type="file" name="photo" class="form-control">
                                @if ($user->photo)
                                    <img src="{{ Storage::url($user->photo) }}" alt="Profile Photo" class="mt-2"
                                        width="100">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
        @endsection
