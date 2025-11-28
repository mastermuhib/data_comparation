<!DOCTYPE html>
<html>
<head>
	<title>Medikal Record</title>
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
		<h5>Medikal Record</h5>
	</center>

    <!-- nama siswa  -->
   

    <table class='table table-bordered mr-4'>
        <tr>
            <td><span class="text-dark-75 mr-2">Nama</span></td>
            <td>:</td>
            <td>{{$user->student_name}}</td>
        </tr>
        <tr>
            <td><span class="text-dark-75 mr-2">NPM</span></td>
            <td>:</td>
            <td>{{$user->nisn}}</td>
        </tr>
        <tr>
            <td><span class="text-dark-75 mr-2">Email</span></td>
            <td>:</td>
            <td>{{$user->email}}</td>
        </tr>
        <tr>
            <td><span class="text-dark-75 mr-2">Nomer HP</span></td>
            <td>:</td>
            <td>{{$user->phone}}</td>
        </tr>
        <tr>
            <td><span class="text-dark-75 mr-2">Alamat</span></td>
            <td>:</td>
            <td>{{$user->address}}</td>
        </tr>
    </table>
 
	<table class='table table-bordered mr-4'>
        <thead>
            <tr>
                <th>No</th>
                <th>Keluhan</th>
                <th>Tindakan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($data_medicine as $p)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$p->problem}}</td>
                <td>{{$p->solving}}</td>
                <td>{{ date('d F Y H:i',strtotime($p->record_date))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>