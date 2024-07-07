@extends('kerangka.master')

@section('title', 'Dashboard')

@section('content')


    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Barang Habis Pakai</h6>
                                        <h6 class="font-extrabold mb-0">{{ $count1 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Barang Tersedia</h6>
                                        <h6 class="font-extrabold mb-0">{{ $count2 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Barang Rusak</h6>
                                        <h6 class="font-extrabold mb-0">{{ $count3 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Barang Baru</h6>
                                        <h6 class="font-extrabold mb-0">{{ $count4 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Berita Terbaru -->
                <div class="col-lg-12 mt-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Berita Terbaru</h5>
                            <div class="row">
                                @foreach($masterBeritas as $masterBerita)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                        <div class="card shadow-sm">
                                            <img src="{{ asset('images/' . $masterBerita->gambar) }}" class="card-img-top" alt="{{ $masterBerita->judul }}">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $masterBerita->judul }}</h6>
                                                <a href="{{ route('master-berita.show', $masterBerita->id) }}" class="btn btn-primary">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Section for the bar chart -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Barang</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" style="height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Skrip Chart.js untuk grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Skrip untuk menampilkan profil pengguna yang sedang login -->
<script>
    @auth
        var user = {!! json_encode(Auth::user()) !!};
        console.log('Profil pengguna:', user);
        // Di sini Anda bisa melakukan operasi atau menampilkan informasi profil pengguna
    @else
        console.log('Pengguna belum login.');
        // Handle jika pengguna belum login, misalnya redirect atau tindakan lain
    @endauth

    // Skrip untuk grafik menggunakan Chart.js
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Barang Habis Pakai', 'Barang Tersedia', 'Barang Rusak', 'Barang Baru'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $count1 }}, {{ $count2 }}, {{ $count3 }}, {{ $count4 }}],
                backgroundColor: [
                    'rgba(128, 0, 128, 0.8)', // Purple
                    'rgba(0, 0, 255, 0.8)',   // Blue
                    'rgba(0, 128, 0, 0.8)',   // Green
                    'rgba(255, 0, 0, 0.8)'    // Red
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
