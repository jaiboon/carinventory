
 //   var DOMAIN = "http://localhost/demo_inventory";

    function loadInventories() {

        if ($.fn.DataTable.isDataTable("#inventory-table")) {
       
            $('#inventory-table').DataTable().clear().destroy();
        }

        $('#inventory-table').DataTable({
           
            "ajax": {
                url: DOMAIN + "../services/get_inventory.php",
                dataSrc: ''
            },
            rowId: 'model_id',
            "columns": [
                {"data": "model_id"},
                {"data": "model_name"},
                {"data": "manufacturer_name"},
                {"data": "model_count"}
            ],
            "rowCallback": function (row, data) {

            }
        });
    }
    function addInventoryDetails() {
        $('#inventory-table tbody').on('click', 'tr', function () {
            var id = this.id;
            $.ajax({
                url: DOMAIN + "../services/get_inventory.php",
                method: "GET",
                data: {'id': id},
                success: function (data) {
                    data = JSON.parse(data);
                    var inventory_details = "";
                    inventory_details += '<div class="control-group"><label class="control-label">Model</label><div class="controls readonly">' + data.model_name + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Manufacturer</label><div class="controls readonly">' + data.manufacturer_name + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Color</label><div class="controls readonly">' + data.model_color + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Manufactured Year</label><div class="controls readonly">' + data.model_year + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Registration #</label><div class="controls readonly">' + data.model_regno + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Note</label><div class="controls readonly">' + data.model_note + '</div></div>';
                    inventory_details += '<div class="control-group"><label class="control-label">Count</label><div class="controls readonly">' + (data.model_count == null || data.model_count == 0 ? 'Sold Out' : data.model_count) + '</div></div>';
                    inventory_details += '<div class="control-group text-center"><img style="max-width:200px; margin: 10px;" src="images/' + data.image1 + '"/><img style="max-width:200px; margin: 10px;" src="images/' + data.image2 + '"/></div>';
                    inventory_details += '<div class="form-group text-center"><button type="button" class="btn btn-warning" onclick="soldOut(' + id + ', \'' + data.model_name + '\')">Sold Out</button></div>';
                    $('.modal-title').html(data.model_name);
                    $('.modal-body').html(inventory_details);
                    $('#model-button').click();
                }
            });

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }

        });
    }

   
    function soldOut(id, model_name) {
    $.ajax({
        url: DOMAIN + "../services/sold_out_inventory.php",
        method: "POST",
        data: {'id': id},
        success: function (data) {
            alert(data);
            switch (data) {
                
                case 'success':
                    var msg = '<div class="alert alert-info text-center">';
                    msg += '<strong>Success!</strong> Model ' + model_name + ' Sold Out';
                    msg += '</div>';
                 //   addSoldOutNotification(id);
                    alert("Data updated successfully");
                    break;
                case 'error':
                    var msg = '<div class="alert alert-danger text-center">';
                    msg += '<strong>Failed!</strong> Something went wrong, Please try again later.';
                    msg += '</div>';
                    alert("Somthing went wrong please try again later");
                    break;
            }

            loadInventories();
            addInventoryDetails();

        }
    });
}
loadInventories();
addInventoryDetails();



