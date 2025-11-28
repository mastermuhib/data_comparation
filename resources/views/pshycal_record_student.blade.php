<!DOCTYPE html>
<html>
<head>
	<title>Pemeriksaan Fisik</title>
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
		<h5>Pemeriksaan Fisik</h5>
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
 
	<div class="row" style="margin-top: 30px;">
        <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4>Pemeriksaan Fisik</h4>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Tanggal Pemeriksaan</label>
                                                <p>{{ date('Y-m-d H:i',strtotime($data->date))}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <table class="table table-hover" style="width: 100%" border="0">
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Keadaan Umum</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Warna Conjunctiva
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->conjunctiva}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tinggi Badan (cm)
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->height}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Berat Badan (kg)
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->weight}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tekanan Darah (mm Hg)
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->blood_pressure}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Denyut Nadi ( / menit)
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->pulse}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Kepala</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kesehatan Rambut
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->hair_healthy}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Penglihatan</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tanpa Kacamata
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <p>{{$data->without_glasses_right}}</p>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <p>{{$data->without_glasses_left}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Dengan Kacamata
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <p>{{$data->with_glasses_right}}</p>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <p>{{$data->with_glasses_left}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Mata Juling
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->cockeye}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Radang Mata
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->eye_inflammation}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Buta Warna
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->color_blind}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Telingga/Hidung/Tenggorokan</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Daya Pendengaran
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <p>{{$data->hearing_power_right}}</p>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <p>{{$data->hearing_power_left}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Cerumen Telinga
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <p>{{$data->ear_wax_right}}</p>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <p>{{$data->ear_wax_left}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kelainan Hidung
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->nasal_abnormalities}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tenggorokan / tonsil
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->throat}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Gigi Mulut
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->mouth_teeth}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Dada</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Batuk Dada
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->chest_cough}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Jantung
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->heart}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Paru - paru
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->lungs}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Perut</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Hati
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->liver}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Limpa
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->spleen}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Nyeri Tekan
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->tenderness}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Anggota Gerak
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->motion_members}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kulit
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->skin}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kesimpulan
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->conclusion}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Diagnosa
                                                    </td>
                                                    <td colspan="2">
                                                        <p>{{$data->diagnose}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Dokter Pemeriksa
                                                    </td>
                                                    <td colspan="2">
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4>Kesimpulan Perkembangan Jasmani & Kesehatan Anak</h4>
                                    <br>
                                    <div class="row">
                                        <table class="table table-hover" style="width: 100%" border="0">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>
                                                    Pemeriksaan
                                                </th>
                                                <th>
                                                    Kesimpulan
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    Berat Badan
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->weight_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    2
                                                </td>
                                                <td>
                                                    Tinggi Badan
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->height_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    3
                                                </td>
                                                <td>
                                                    Gizi (lebih baik/baik/kurang)
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->nutrition_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    4
                                                </td>
                                                <td>
                                                    Mata / Penglihatan
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->eye_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    5
                                                </td>
                                                <td>
                                                    Hidung / Penciuman
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->nasal_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    6
                                                </td>
                                                <td>
                                                    Telinga / Pendengaran
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->ear_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    7
                                                </td>
                                                <td>
                                                    Mulut (Tanpa halitosis)
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->mouth_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    8
                                                </td>
                                                <td>
                                                    Gigi Geligi
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->teeth_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    9
                                                </td>
                                                <td>
                                                    Anggota Badan
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->body_result}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    10
                                                </td>
                                                <td>
                                                    Kulit
                                                </td>
                                                <td colspan="2">
                                                    <p>{{$data->skin_result}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>
</body>
</html>