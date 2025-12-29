<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
        <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="6" style="font-weight: bolder;font-size: 20px;text-align: center;">Hasil Klasifikasi Usia DPT Kabupaten Bojonegoro Per Desa Triwulan {{$triwulan}} {{$year}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kecamatan</td>
                    <td>Desa</td>
                    <td>Klasifikasi</td>
                    <td>Laki - Laki</td>
                    <td>Perempuan</td>
                    <td>Total</td>
                </tr>
                @foreach($data as $k=>$v)
                <tr>
                    <td> {{ $v->kecamatan }}</td>
                    <td> {{ $v->klasifikasi }}</td>
                    <td> {{ $v->male }}</td>
                    <td> {{ $v->female }}</td>
                    <td> {{ $v->total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">Jumlah</td>
                    <td>{{ $male }}</td>
                    <td>{{ $female }}</td>
                    <td>{{ $total }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>