<!DOCTYPE html>
<html>
<head>
	<title>Medical Report Siswa</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
        /* @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'); */
		table tr td,
		table tr th{
			font-size: 9pt;
		}
         . {
            font-family: 'Montserrat', sans-serif;
         }
	</style>
	<center>
		<h5>List Penggunaan Obat</h4>
	</center>

    <!-- nama siswa  -->
    <p style="margin-bottom: 0px;">
    <span class="text-dark-75 mr-2">Jenis Obat</span><span class="text-dark-75" style="margin-left: 35px;">{{$data->medicine}}</span>
    </p>
    <p style="margin-bottom: 20px;">
    <span class="text-dark-75 mr-2">Deskripsi Obat </span><span style="margin-left: 8px;" class="text-dark-75">{{$data->notes}}</span>
    </p>
   
 
	<table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Sakit</th>
                    <th>Tanggal</th>
                    <th>Dosis</th>
                    <th>Dokter</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach($data_medicine as $p)
                <tr>
                    <td>{{ $p->student_name }} <br> {{ $p->scholl_name }} |  {{ $p->class_name }} </td>
                    <td>{{ $p->category_name }}</td>
                    <td>{{ date('d M Y H:i',strtotime($p->created_at)) }}</td>
                    <td>{{ $p->dosis }}</td>
                    <td>{{ $p->admin_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
 
</body>
</html>























