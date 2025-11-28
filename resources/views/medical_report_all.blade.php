<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
	    <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="8" style="font-weight: bolder;font-size: 20px;text-align: center;">{{ $title }}</th>
                </tr>
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Sekolah</th>
                    <th style="font-weight: bold;">Kelas</th>
                    <th style="font-weight: bold;">Murid</th>
                    <th style="font-weight: bold;">Perawat</th>
                    <th style="font-weight: bold;">Keluhan</th>
                    <th style="font-weight: bold;">Tindakan</th>
                    <th style="font-weight: bold;">Tanggal</th>
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
                    <td>{{ strip_tags($d->problem) }}</td>
                    <td>{{ strip_tags($d->solving) }}</td>
                    <td>{{ date('d F Y H:i',strtotime($d->record_date))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>























