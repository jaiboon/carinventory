//var DOMAIN = "http://localhost/demo_inventory";

function loadManufacturer() {
    $.ajax({
        'url': DOMAIN + '../services/get_manufacturer.php',
        method: "GET",
        success: function (data) {
            // alert(data);
            data = JSON.parse(data);
            //alert(data['manufacturer_id']);
            console.log(data);
            var manufacturer = "<option>Select Manufacturer</option>";
            for (i = 0; i < data.length; i++) {
                manufacturer += "<option value='" + data[i].manufacturer_id + "'>" + data[i].manufacturer_name + "</option>";
            }
            $('#select_manufacturer').html(manufacturer);
        }
    });
}

loadManufacturer();

function addModel() {
   
    var image1 = $('#image1').prop('files')[0];
    var image2 = $('#image2').prop('files')[0];
    var form_data = new FormData();
    form_data.append('model_name', $('#model_name').val());
    form_data.append('manufacturer_id', $('#select_manufacturer').val());
    form_data.append('model_color', $('#model_color').val());
    form_data.append('model_year', $('#model_year').val());
    form_data.append('model_regno', $('#model_regno').val());
    form_data.append('model_note', $('#model_note').val());
    form_data.append('model_count', $('#model_count').val());
    form_data.append('image_file1', image1);
    form_data.append('image_file2', image2);
    $.ajax({
        'url': DOMAIN + '../services/add_model.php',
        method: "POST",
        data: form_data,
        processData: false,
        contentType: false,
        success: function (data) {
            switch (data) {
                case 'success':
                    var msg = '<div class="alert alert-success text-center">';
                    msg += '<strong>Success!</strong> ata saved successfully.';
                    msg += '</div>';
                    break;
                case 'error':
                    var msg = '<div class="alert alert-danger text-center">';
                    msg += '<strong>Failed!</strong> Something went wrong, Please try again later.';
                    msg += '</div>';
                    break;
            }
            $('#alerts').html(msg);
            $("#alerts").show();
            $("#alerts").show().delay(5000).fadeOut();
        }
    });
}
$(document).ready(function (e) {

    $(function () {
        $("#image1").change(function () {
            $("#message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
            {
                $('#previewing').attr('src', 'images/img/noimage.png');
                $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
         $("#image2").change(function () {
            $("#message2").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
            {
                $('#previewing2').attr('src', 'images/img/noimage.png');
                $("#message2").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded2;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoaded(e) {
        $("#image1").css("color", "green");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', e.target.result);
        $('#previewing').attr('width', '250px');
        $('#previewing').attr('height', '230px');
    }
      function imageIsLoaded2(e) {
        $("#image2").css("color", "green");
        $('#image_preview2').css("display", "block");
        $('#previewing2').attr('src', e.target.result);
        $('#previewing2').attr('width', '250px');
        $('#previewing2').attr('height', '230px');
    }
    
    
    
});
