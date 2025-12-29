<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
	    <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="4" style="font-weight: bolder;font-size: 20px;text-align: center;">Hasil Klasifikasi Usia DPT Kabupaten Bojonegoro Triwulan {{$triwulan}} {{$year}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Klasifikasi</td>
                    <td>Laki - Laki</td>
                    <td>Perempuan</td>
                    <td>Total</td>
                </tr>
                @foreach($data as $k=>$v)
                <tr>
                    <td> {{ $v->klasifikasi }}</td>
                    <td> {{ $v->male }}</td>
                    <td> {{ $v->female }}</td>
                    <td> {{ $v->total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td>Jumlah</td>
                    <td>{{ $male }}</td>
                    <td>{{ $female }}</td>
                    <td>{{ $total }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>