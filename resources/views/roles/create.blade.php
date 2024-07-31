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
                <h2>Buat Rol Baru</h2>
                <a class="btn btn-primary" href="{{ route('role.index') }}"> Kembali</a>
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
                <label for="name"><strong>Nama:</strong></label>
                {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label for="role_type"><strong>Tipe:</strong></label>
                <select name="role_type" id="role_type" class="form-control" required>
                    <option value="">Pilih Tipe</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="OPD Admin">OPD Admin</option>
                </select>
            </div>

            <div class="form-group" id="opd_id_group" style="display: none;">
                <label for="opd_id">OPD</label>
                <select class="form-control" id="opd_id" name="opd_id">
                    @foreach ($opds as $opd)
                        <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                            {{ $opd->opd_name }}
                        </option>
                    @endforeach
                </select>
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
                                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $value->name }}" id="permission{{ $value->id }}">
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
    document.addEventListener('DOMContentLoaded', function() {
        const roleTypeSelect = document.getElementById('role_type');
        const opdIdGroup = document.getElementById('opd_id_group');

        roleTypeSelect.addEventListener('change', function() {
            if (this.value === 'OPD Admin') {
                opdIdGroup.style.display = 'block';
            } else {
                opdIdGroup.style.display = 'none';
            }
        });

        // Trigger change event on page load to set initial state
        roleTypeSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
