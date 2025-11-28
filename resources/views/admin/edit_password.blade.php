<!-- Pop Up Edit -->
<section class="multiple-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title mt-2">Ganti Password</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_edit_password">@csrf
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="control-label">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="control-label">Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password"  class="form-control form-control-lg" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                    <button type="button" class="btn btn-danger float-right" id="batalkan_password" style="margin-right: 10px">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Pop Up Edit -->
<script>
    $("#form_edit_password").validate({
    rules: {
        new_password: {
            minlength: 6
        },
        confirm_password: {
            equalTo: "#new_password"
        }
    },
    messages: {
        new_password: {
            minlength: "password minimal 6 character"
        },
        confirm_password: {
            equalTo: "password not match"
        }
    },
    submitHandler: function(form) {
        $.ajax({ //line 28
            type: 'POST',
            url: '/update-password',
            dataType: 'json',
            data: new FormData($("#form_edit_password")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == 200) {
                    document.getElementById("form_edit_password").reset();
                    $("#edit_password").hide();
                    $("#message").remove();
                    show_toast(data.message, 1);

                    data_tabel()
                } else if (data.code == 500) {
                    document.getElementById("form_edit_password").reset();
                    $("#message").remove();
                    show_toast(data.message, 0);
                } else {
                    alert("maaf ada yang salah!!!");
                }
            }
        });
    }
});
</script>