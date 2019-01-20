//var DOMAIN = "http://localhost/demo_inventory";
function addManufacturer() {
    var manufacturer_name = $('#manufacturer_name').val().trim();
    if (manufacturer_name == '') {
        $("#manufacturer_name").addClass("border-danger");
        $("#manufacturer_error").html("<span class='text-danger'>Please Enter Manufacturer Name</span>");
        //   alert("Please add manufacturer name");
    } else {
        $.ajax({
            url: DOMAIN + "../services/add_manufacturer.php",
            method: "POST",
            data: {'manufacturer_name': manufacturer_name},
            success: function (data) {
                switch (data) {
                    case 'success':
                        var msg = '<div class="alert alert-success text-center">';
                        msg += '<strong>Success!</strong> Data saved successfully.';
                        msg += '</div>';
                        break;
                    case 'error':
                        var msg = '<div class="alert alert-danger text-center">';
                        msg += '<strong>Failed!</strong> Something went wrong, Please try again later.';
                        msg += '</div>';
                        break;
                    case 'duplicate':
                        var msg = '<div class="alert alert-warning text-center">';
                        msg += '<strong>Warning!</strong> Entry already exist.';
                        msg += '</div>';
                        break;
                }
                $("#manufacturer_name").removeClass("border-danger");
                $("#manufacturer_error").html("");
                $('#alerts').html(msg);
                $("#alerts").show();
                $("#alerts").show().delay(5000).fadeOut();
            }
        });
    }
}