@extends('kerangka.master')
@section('title', 'Edit Log')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Log</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('logs.update', $log->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="id_users">User</label>
                                <input type="number" class="form-control" id="id_users" name="id_users" value="{{ $log->id_users }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tipe_aktivitas">Tipe Aktivitas</label>
                                <input type="text" class="form-control" id="tipe_aktivitas" name="tipe_aktivitas" value="{{ $log->tipe_aktivitas }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tabel_terkait">Tabel Terkait</label>
                                <input type="text" class="form-control" id="tabel_terkait" name="tabel_terkait" value="{{ $log->tabel_terkait }}" required>
                            </div>
                            <div class="form-group">
                                <label for="data_sebelum">Data Sebelum</label>
                                <textarea class="form-control" id="data_sebelum" name="data_sebelum">{{ $log->data_sebelum }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="data_sesudah">Data Sesudah</label>
                                <textarea class="form-control" id="data_sesudah" name="data_sesudah">{{ $log->data_sesudah }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
