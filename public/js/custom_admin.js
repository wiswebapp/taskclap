window.adminpath = "webadmin";

$(document).ready(function() {
    $( ".select2" ).select2();

    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .then( editor => {
        console.log( editor );
    })
    .catch( error => {
        console.error( error );
    });

    //For Order Detail Page
    $(".addMaterialCharge").click(function () {
        var inputText = "";
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge</label>';
        inputText += '<input type="number" name="material_charge" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge (Actual)</label>';
        inputText += '<input type="number" name="material_charge_actual" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge Description</label>';
        inputText += '<textarea name="material_description" class="form-control" required></textarea>';
        inputText += '</div>';
        $("#orderDetailId").val($(this).attr('data-id'));
        $(".chargeTypeBtn").html("Add Material Charge");
        $("#chargeType").val("add_material_charge");
        $(".chargeModalInput").html(inputText);
        $("#addChargesMdl").modal("show");
    });
    $(".addAdditionalCharge").click(function () {
        var inputText = "";
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Additional charge</label>';
        inputText += '<input type="number" name="additional_charge" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Additional charge Description</label>';
        inputText += '<textarea name="additional_charge_description" class="form-control" required></textarea>';
        inputText += '</div>';
        $("#orderDetailId").val($(this).attr('data-id'));
        $(".chargeTypeBtn").html("Add Additional Charge");
        $("#chargeType").val("add_additional_charge");
        $(".chargeModalInput").html(inputText);
        $("#addChargesMdl").modal("show");
    });

    $("#assignProviderBtn").click(function() {
        var userId = $(this).attr("data-userId");
        if (userId == "") {
            Swal.fire('Whoops !', 'Please select User first to do transaction !', 'info');
            return;
        }

        $("#wallet_user_id").val(userId);
        $("#addWalletTransaction").modal("show");
    });
});

/**
 * ------------------------------------------------------------------------
 *  Important Information
 *  Any Function should be written below this line
 * ------------------------------------------------------------------------
 */

/**
 * Function to generate the datatable
 *
 * @param string url
 * @param array coloumnsData
 * @param array filterData
 * @param array coloumnsData
 */
function generateDataTable(dataUrl, coloumnsData, filterData = [], coloumnsToExport = [1,2,3,4]) {

    $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 15,
        bFilter: true,
        ajax: {
            url: dataUrl,
            data: function (d) {
                d.filterData = filterData;
            }
        },
        columns: coloumnsData,
        dom: 'Bfrtip',
        order: [],
        'columnDefs': [
            {
                "targets": 0,
                "className": "text-center",
                "width": "18%",
                orderable: false,
           },
        ],
        buttons: [
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
        ],
    });
}

/**
 * Function to remove Data from the database
 *
 * @param string deleteUrl
 * @param integer id
 */
function removeDataFromDatabase(deleteUrl, id, refreshDataTable = true) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        icon: 'warning',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: deleteUrl + '/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function() {
                    Swal.fire('Please wait..','While we are removing your data !','info')
                },
                success : function(response) {
                    if (response.success) {
                        Swal.fire('Deleted','Data has been removed successfully !','success')
                        if (refreshDataTable) {
                            $('#data-table').DataTable().ajax.reload();
                        } else {
                            setTimeout(function() {
                                location.reload();
                            }, 1200);
                        }
                    } else {
                        Swal.fire('Whoops !','Something went wrong !')
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // Swal.fire('Whoops !','We encoutered some error !<br>' + XMLHttpRequest.responseJSON.message,'error')
                    Swal.fire('Whoops !','We encoutered some error !<br>Please contact site administrator','error')
                }
            });
        }
    });
}


/**
 * Function to generate the pie chart
 *
 * @param string chartElement
 * @param array chartLabel
 * @param array chartData
 */
function generatPieChart(chartElement, chartLabel, chartData) {
    var pieChartCanvas = $('#' + chartElement).get(0).getContext('2d');

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: {
            labels: chartLabel,
            datasets: chartData
        },
        options: {
            maintainAspectRatio : false,
            responsive : true,
        }
    });
}

/**
 * Function to generate the bar chart
 *
 * @param string chartElement
 * @param array chartLabel
 * @param array chartData
 */
function generatBarChart(chartElement, chartLabel, chartData) {
    var chartDataSet = [];
    var barChartCanvas = $('#' + chartElement).get(0).getContext('2d');

    chartData.forEach(function(row) {
        chartDataSet.push({
            label               : row.name,
            backgroundColor     : row.background,
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : row.value
        })
    })

    var barChartData = $.extend(true, {}, {
        labels: chartLabel,
        datasets: chartDataSet
    })

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
    })
}

/**
 * Function to Fetch categories and set to option value
 *
 * @param int selected
 */
function fetchAndSetCategory(selected = '') {
    var options = "<option value=''>Select Category</option>";
    $.ajax({
        type : "GET",
        dataType: "json",
        url : '/' + window.adminpath  + "/fetch/category",
        data : {},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(response) {
            if (response.success) {
                response.data.forEach(function (key) {
                    if (selected == key.id) {
                        options += "<option selected value='" + key.id + "'>" + key.name + "</option>";
                    } else {
                        options += "<option value='" + key.id + "'>" + key.name + "</option>";
                    }

                })
            }
            $("#category").html(options);
        }
    });
}

/**
 * Function to Fetch sub-categories and set to option value
 *
 * @param int cat
 * @param int selected
 */
function fetchAndSetSubCategory(cat, selected = '') {
    if (cat) {
        var options = "<option value=''>Select Sub Category</option>";
        $.ajax({
            type : "GET",
            dataType: "json",
            url : '/' + window.adminpath  + "/fetch/subcategory",
            data : {
                category: cat
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                if (response.success) {
                    response.data.forEach(function (key) {
                        if (selected == key.id) {
                            options += "<option selected value='" + key.id + "'>" + key.name + "</option>";
                        } else {
                            options += "<option value='" + key.id + "'>" + key.name + "</option>";
                        }
                    })
                }
                $("#subcategory").html(options);
            }
        });
    }
}

function initAutocomplete() {
    var lattitude = $("#address_lat").val();
    if (! lattitude || lattitude == "") {
        lattitude = "23.0225";
    }
    let longitude = $("#address_long").val();
    if (! longitude || longitude == "") {
        longitude = "72.5714";
    }

    const map = new google.maps.Map(document.getElementById("map-canvas"), {
      center: {
        lat: parseFloat(lattitude),
        lng: parseFloat(longitude)
    },
      zoom: 12,
      mapTypeId: "roadmap",
    });
    // Create the search box and link it to the UI element.
    const input = document.getElementById("map-canvas-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
      searchBox.setBounds(map.getBounds());
    });

    let marker;
    let markers = [];

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // For each place, get the icon, name and location.
      const bounds = new google.maps.LatLngBounds();

      places.forEach((place) => {
        const icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25),
        };

        // Create a marker for each place.
        markers.push(
          new google.maps.Marker({
            map,
            icon,
            title: place.name,
            position: place.geometry.location,
          })
        );
        markers[0].addListener("click", toggleBounce);

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
              marker.setAnimation(null);
            } else {
              marker.setAnimation(google.maps.Animation.BOUNCE);
            }
          }

        markers[0].addListener(markers, 'dragend', function(evt) {
            alert(evt.latLng.lat().toFixed(3));
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
        $("#address_lat").val(place.geometry['location'].lat());
        $("#address_long").val(place.geometry['location'].lng());

        if (place.geometry.viewport) {
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });

      map.fitBounds(bounds);
    });
}
