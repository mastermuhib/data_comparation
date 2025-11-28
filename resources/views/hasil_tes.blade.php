<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<link href="./asset/images/styles/bootstrap_print.min.css" rel="stylesheet" id="bootstrap-css">
<link href="./asset/images/styles/poppins.css" rel="stylesheet" id="bootstrap-css">
<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->


<!------ Include the above in your HEAD tag ---------->
<style type="text/css">

body {
  font-family: "Poppins", sans-serif !important;
}

h1, h2, h3, h4, h5, h6 {
  font-family: "Poppins", sans-serif !important;
}
.bottom-top {
    border-bottom: 1px solid black;border-top: 1px solid black;
    padding: 15px;
}

#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.p-anti{
    margin-left: 20px;
    margin-top : 2px;
    margin-bottom : 2px;
}

.invoice .company-details .name {
    margin-top: -60px;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: -80px;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 3px;
    background: none;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}
.text-center{
    text-align: center;
}
.text-right{
    text-align: right;
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
<!--Author      : @arboshiki-->
<div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            
                <div class="row">
                    <div class="col">
                        <!-- <a target="_blank" href="https://lobianijs.com"> -->
                            <img style="width: 15%" src="./assets/images/ipeka.png" data-holder-rendered="true" />
                            <!-- </a> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-dark font-weight-bolder">info@genikalab.id | www.genikalab.id</h5>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div class="row">
                     <h3 class="text-dark font-weight-bolder text-right">Penanggung Jawab : Genika </h3>
                </div>
                <div class="row" style="border-bottom: 3px solid black">
                </div>
            
            <main>
                <div class="row" style="padding-top: 20px;">
                    <table style="width: 100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="15%">Nama Pasien</td>
                            <td width="25%">: {{$pasien[0]->patient_name}} </td>
                            <td width="5%"></td>
                            <td width="20%">Nomor Lab</td>
                            <td width="25%">: <b>{{$nomor}} </b></td>
                        </tr>
                        <tr>
                            <td width="15%">Tanggal Order</td>
                            <td width="25%">:  {{date('d/m/Y H:i',strtotime($tanggal))}}</td>
                            <td width="5%"></td>
                            <td width="20%">Jenis Kelamin</td>
                            <td width="25%">: 
                                @if($pasien[0]->gender == 1)
                                Laki - Laki
                                @elseif($pasien[0]->gender == 2)
                                Perempuan
                                @else
                                Belum Memilih
                                @endif
                            </td>      
                        </tr>
                        <tr>
                            <td width="15%">Tanggal Cetak</td>
                            <td width="25%">: <b>
                                {{date('d/m/Y',strtotime($tanggal_ambil))}}
                            </b></td>
                            <td width="5%"></td>
                            <td width="20%">Tanggal Lahir / Umur</td>
                            <td width="25%">: 
                                @if($pasien[0]->birthday != null)
                                {{date('d/m/Y',strtotime($pasien[0]->birthday))}} 
                                @endif
                            <span style="margin-left: 20px">{{getUmur($pasien[0]->birthday)}}</span></td>
                        </tr>
                        <tr>
                            <td width="15%">Nomor MR</td>
                            <td width="25%">: - </td>
                            <td width="5%"></td>
                            <td width="20%">Dokter Pengirim</td>
                            <td width="25%">: {{$dokter}} </td>
                        </tr>
                    </table>
                </div>
                <div class="row" style="border-bottom: 3px solid black">
                </div>
                <div class="row">
                    <div class="text-center">
                        <h2 class="text-dark font-weight-bolder"><b>HASIL PEMERIKSAAN LABORATORIUM</b></h2>
                    </div>
                </div>
                <div class="row" style="border-bottom: 1px solid black">
                </div>
                <div class="row">
                    <table style="width: 100%;line-height: 2px;" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <td width="35%" class="bottom-top" style="padding: 15px;padding-left: 0px;"><b>PEMERIKSAAN</b></td>
                                <td width="15%" class="bottom-top" style="padding: 15px;padding-left: 0px;"><b>HASIL</b></td>
                                <td width="20%" class="bottom-top" style="padding: 15px;padding-left: 0px;"><b>NILAI RUJUKAN</b></td>
                                <td width="10%" class="bottom-top" style="padding: 15px;padding-left: 0px;"><b>SATUAN</b></td>
                                <td width="20%" class="bottom-top" style="padding: 15px;padding-left: 0px;"><b>KETERANGAN</b></td>
                            </tr>
                        </thead>
                        @foreach($hasil as $k=>$v)
                        <tr>
                            <td width="35%" class="bottom-top" style="padding: 15px;padding-left: 0px;">{{$hasil[$k]['TEST_NM']}}</td>
                            <td width="15%" class="bottom-top" style="padding: 15px;padding-left: 0px;">{{$hasil[$k]['RESULT_VALUE']}}</td>
                            <td width="20%" class="bottom-top" style="padding: 15px;padding-left: 0px;">{{$hasil[$k]['REF_RANGE']}}</td>
                            <td width="20%" class="bottom-top" style="padding: 15px;padding-left: 0px;">{{$hasil[$k]['UNIT']}}</td>
                            <td width="30%" class="bottom-top" style="padding: 15px;padding-left: 0px;">{{$hasil[$k]['TEST_COMMENT']}}</td>
                        </tr>
                        @endforeach
                        
                    </table>
                </div>
                <div class="row">
                    <div class="text-right">
                        <p>Jakarta, {{date('d-m-Y H:i')}}</p>
                        <p>diverifikasi oleh,</p>
                        <p style="margin-top: 40px;">
                            @if(count($hasil) > 0)
                            {{ $hasil[0]['VALIDATE_BY'] }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <p class="font-weight-bolder" style="margin-bottom: 2px;font-size: 14px"><b>
                            Hasil pemeriksaan ini dihasilkan oleh sistem secara otomatis dan telah divalidasi sehingga tidak membutuhkan tanda tangan</b>
                        </p>
                        <p style="font-size: 12px;margin-top: 0px;">
                            This result is generated by sistem and has been validated therefore not require signature
                        </p>
                    </div>
                </div>
            </main>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>


</body>
</html>





















