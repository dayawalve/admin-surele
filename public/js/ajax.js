$('.VerifyUser').click(function (e) {
    e.preventDefault();
    var trid = $(this).closest('tr').attr('id');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to verify the user?!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sure!",
        allowOutsideClick: false
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: base_url + "/admin/Ajax/VerifyUser",
                data: {
                    'id': trid
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: "Done",
                            text: response.msg,
                            icon: "success",
                            confirmButtonText: "Ok",
                            confirmButtonColor: "#50cd89",
                            allowOutsideClick: false
                        }).then(function (result) {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error!", response.msg, "error");
                    }
                }
            });
        }
    });
});