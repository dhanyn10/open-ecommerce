@extends('tataletak')
@section('konten')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">Pengguna</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Peran</th>
                                <th>Konfirmasi</th>
                            </tr>
                            @foreach ($pengguna as $item)
                                <tr>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->peran}}</td>
                                    <td>{{$item->konfirmasi}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endsection
@endsection