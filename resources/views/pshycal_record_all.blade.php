<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
	    <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="16" style="font-weight: bolder;font-size: 20px;text-align: center;">{{ $title }}</th>
                </tr>
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Sekolah</th>
                    <th style="font-weight: bold;">Kelas</th>
                    <th style="font-weight: bold;">Murid</th>
                    <th style="font-weight: bold;">Pemeriksa</th>
                    <th style="font-weight: bold;">Tanggal Pemeriksaan</th>
                    <th style="font-weight: bold;">Berat</th>
                    <th style="font-weight: bold;">Tinggi</th>
                    <th style="font-weight: bold;">Gizi</th>
                    <th style="font-weight: bold;">Mata / Penglihatan</th>
                    <th style="font-weight: bold;">Hidung / Penciuman</th>
                    <th style="font-weight: bold;">Telinga / Pendengaran</th>
                    <th style="font-weight: bold;">Mulut (Tanpa halitosis)</th>
                    <th style="font-weight: bold;">Gigi Geligi</th>
                    <th style="font-weight: bold;">Anggota Badan</th>
                    <th style="font-weight: bold;">Kulit</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach($data as $d)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{$d->scholl_name}}</td>
                    <td>{{$d->class_name}}</td>
                    <td>{{$d->student_name}}</td>
                    <td>{{$d->admin_name}}</td>
                    <td>{{ date('d F Y H:i',strtotime($d->date))}}</td>
                    <td>{{$d->height_result}}</td>
                    <td>{{$d->weight_result}}</td>
                    <td>{{$d->nutrition_result}}</td>
                    <td>{{$d->eye_result}}</td>
                    <td>{{$d->nasal_result}}</td>
                    <td>{{$d->ear_result}}</td>
                    <td>{{$d->mouth_result}}</td>
                    <td>{{$d->teeth_result}}</td>
                    <td>{{$d->body_result}}</td>
                    <td>{{$d->skin_result}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>