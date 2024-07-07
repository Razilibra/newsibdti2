@extends('kerangka.master')
@section('title', 'Tabel Log Aktivitas')
@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-center">Tabel Log Aktivitas</h4>
                        <a class="btn btn-success" href="{{ route('logs.create')}}">Tambah</a>
                    </div>
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session()->has('failed'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-content">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Tipe Aktivitas</th>
                                    <th>Tabel Terkait</th>
                                    <th>Data Sebelum</th>
                                    <th>Data Sesudah</th>
                                    <th>Function</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>{{ $log->tipe_aktivitas }}</td>
                                        <td>{{ $log->tabel_terkait }}</td>
                                        <td>{{ $log->data_sebelum }}</td>
                                        <td>{{ $log->data_sesudah }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-primary btn-sm me-2" href="{{ route('logs.edit', $log->id) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('logs.destroy', $log->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash-fill"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
