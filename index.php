
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/bootstrap.min.js"></script>


    </head>
    <body class="container">
        <div class="jumbotron text-center">
            <h2>Car Inventory System</h2>
        </div>
        <div id="alerts" style="display:none;">
        </div>
        <div id="tabs">
            <ul>
                <li><a href="#manufacturer">Add Manufacturer</a></li>
                <li><a href="#model" >Add Model</a></li>
                <li><a href="#inventory" onclick="loadInventories()">View Inventory</a></li>
            </ul>
            <div id="inventory">
                <table id="inventory-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Manufacturer Name</th>
                            <th>Model Name</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                </table>
                <!-- Trigger the modal with a button -->
                <button style="display:none;" id="model-button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="manufacturer">
                <form  action="">
                    <div class="form-group">
                        <label for="manufacturer_name">Manufacturer Name:</label>
                        <input type="text" class="form-control" id="manufacturer_name" placeholder="Enter Manufacturer Name" name="manufacturer_name">
                        <small id="manufacturer_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-default" onclick="addManufacturer()">Add</button>
                    </div>
                </form>
            </div>

            <div id="model">
                <form id="model-form">

                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="model_name">Model Name:</label>
                            <input type="text" class="form-control input-sm" id="model_name" name="model_name" >
                            <small id="model_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="select-manufacturer">Select Manufacturer:</label>
                            <select class="form-control " id="select_manufacturer" name="select_manufacturer"  >
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="model_color">Color:</label>
                            <input type="text" class="form-control input-sm" id="model_color" name="model_color">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_year">Manufacturing Year:</label>
                            <input type="text" class="form-control input-sm" id="model_year" name="model_year">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="model_reg-no">Registration Number:</label>
                            <input type="text" class="form-control input-sm" id="model_regno" name="model_regno">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_count">Count:</label>
                            <input type="number" class="form-control input-sm" id="model_count" min="0" value="0" name="model_count">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="model_note">Note:</label>
                            <input type="text" class="form-control input-sm" id="model_note" name="model_note">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="image-1">Picture 1:</label>
                            <input type="file" name="image" id="image1" required>
                        </div>
                        <div class="form-group col-md-6">
                            <div id="image_preview"><img id="previewing" src="images/img/noimage.png" /></div>
                            <div id="message"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="image-2">Picture 2:</label>
                            <input type="file" name="image" id="image2" required>
                        </div>
                        <div class="form-group col-md-6">
                            <div id="image_preview2"><img id="previewing2" src="images/img/noimage.png" /></div>
                            <div id="message2"></div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary" onclick="addModel()" >Add Model</button>
                    </div>
                </form>
            </div>

        </div>

    </body>
    <script>
        $(function () {
            $("#tabs").tabs();
        });

    </script>
    <script type="text/javascript" src="js/model.js"></script>
    <script type="text/javascript" src="js/manufacturer.js"></script>
    <script type="text/javascript" src="js/inventory.js"></script>

</html>