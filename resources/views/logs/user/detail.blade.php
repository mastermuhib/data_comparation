<!-- Pop Up Detail -->
<style>
.ll {
    height: 30px;
    border: 1px solid black;
    margin: 10px;
    padding: 5px;
}

.cl {
    background-color: rgb(192, 168, 168);
}

</style>
<div class="card mb-5">
    <div class="card-content">
        <div class="card-body">
            <!-- <h3>No Transaction : </h3> -->
            <hr>
            <table class="ll" style="width:80%">
                <tr class="ll">
                    <td class="ll cl">Admin Name</td>
                    <td class="ll">{{$log->admin->name}}</td>
                </tr>
                <tr class="ll">
                    <td class="ll cl">Actifity</td>
                    <td class="ll">{{$log->actifity}}</td>
                </tr>
                <tr class="ll">
                    <td class="ll cl">Object Type</td>
                    <td class="ll">{{$log->type_object}}</td>
                </tr>
                <tr class="ll">
                    <td class="ll cl">Object Name</td>
                    <td class="ll">{{$log->object_name}}</td>
                </tr>
                <tr class="ll">
                    <td class="ll cl">Date</td>
                    <td class="ll">{{$log->created_at}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- End Pop Up Detail -->
