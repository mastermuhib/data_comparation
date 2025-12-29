<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
	    <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="6" style="font-weight: bolder;font-size: 20px;text-align: center;">Rekap Statistik DPT Bojonegoro</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td colspan="4">{{ $kecamatan }}</td>
                </tr>
                <tr>
                    <td>Status Ektp</td>
                    <td>:</td>
                    <td colspan="4">{{ $ektp }}</td>
                </tr>
                <tr>
                    <td>Status Nikah</td>
                    <td>:</td>
                    <td colspan="4">{{ $mariage }}</td>
                </tr>
                <tr>
                    <td>Disabilitas</td>
                    <td>:</td>
                    <td colspan="4">{{ $disabilitas }}</td>
                </tr>
                <tr>
                    <td>Klasifikasi</td>
                    <td>:</td>
                    <td colspan="4">{{ $klasifikasi }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                	<td>Kecamatan</td>
                    <td>Jumlah Desa</td>
                    <td>Jumlah TPS</td>
                    <td>Laki - Laki</td>
                    <td>Perempuan</td>
                    <td>Total</td>
                </tr>
                @foreach($data as $k=>$v)
                <tr>
                	<td> {{ $v->kecamatan }}</td>
                    <td> {{ $v->desa }}</td>
                    <td> {{ $v->tps }}</td>
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