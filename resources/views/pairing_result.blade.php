<!DOCTYPE html>
<html>
    <body>
    <!-- nama siswa  -->
	    <table class='table table-bordered mr-4'>
            <thead>
                <tr>
                    <th colspan="{!! $coloumn !!}" style="font-weight: bolder;font-size: 20px;text-align: center;">Hasil Pairing</th>
                </tr>
                <tr>
                    @for($i = 0;$i <= $coloumn;$i++)
                    <th style="font-weight: bold;">No</th>
                    @endfor
                    
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach($data as $d)
                <tr>
                    @for($i = 0;$i <= $coloumn;$i++)
                    <td style="font-weight: bold;">
                        <?php
                        $pairing = (isset($d['col'.$i])) ? $d['col'.$i] : "" ; 
                        ?>
                        {{ $pairing }}
                    </td>
                    @endfor
                </tr>
               
                @endforeach
            </tbody>
        </table>
    </body>
</html>