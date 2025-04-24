@extends('empty')

@push('content')
    <button id="reservationBtn">Reservation</button>

    <!-- Page content -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="reservationContainer" aria-labelledby="reservationContainerLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-medium">Restaurant</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">
            <form id="reservationForm" method="post" class="reservation-container">
                <div id="dateDiv">
                    <h5 class="text-center font-medium mb-4">Réservation</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="dateErrorMessageDiv" class="alert-reservation alert alert-danger"
                                style="display: none"></div>
                        </div>
                        <div class="form-group col-12">
                            <label for="party" class="form-label">Nombre de personnes</label>
                            <select class="form-select" id="party" name="party">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" class="form-control" maxlength="10" id="date" name="date"
                                placeholder="Date">
                        </div>
                        <div class="form-group col-6">
                            <label class="form-label">Place</label>
                            <select class="form-select" id="position" name="position">
                                <option value="1">En salle</option>
                                <option value="2">Terrase</option>
                            </select>
                        </div>
                        <div class="slot-container col-12">
                            <div id="loadingDiv" class="text-center" style="display: none;">
                                <div class="spinner-border spinner-border-sm" role="status"></div>
                            </div>
                            <div id="fullMessage" class="alert alert-warning" style="display: none">
                                Aucune place n'est disponible
                            </div>
                            <div id="slotDiv" class="input-group">
                                <ul id="slots" class="icheck-list">
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" id="nextBtn" class="btn btn-black w-100 text-white"
                                style="display: none;">Suivant</button>
                        </div>
                    </div>
                </div>
                <div id="infoDiv" style="display: none;">
                    <h5 class="text-center font-medium mb-4">Coordonnées</h5>
                    <section>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="reservation-info">
                                    <h6 class="text-uppercase mb-0"><strong id="chosenDate"></strong>, <strong
                                            id="chosenTime"></strong></h6>
                                    <p class="mb-0">Nombre de personnes: <strong id="chosenParty"></strong> - <span
                                            id="chosenPosition"></span></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert-reservation alert alert-warning">
                                    <h6 class="text-warning mb-2">Cet établissement doit confirmer votre
                                        réservation</h6>
                                    Une fois que vous aurez envoyé votre demande, vous recevrez un e-mail lorsque
                                    cet
                                    établissement aura confirmé votre réservation.
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="client_email" class="form-label">Address e-mail <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" maxlength="100" id="client_email"
                                    name="client_email" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="client_phone" class="form-label">Numéro de téléphone <span
                                        class="text-danger">*</span></label>
                                <label for="client_phone" class="form-label text-danger">Si le numéro de téléphone est
                                    incorrect, votre
                                    réservation sera annulée.</label>
                                <input type="tel" class="form-control mb-2" maxlength="30" id="client_phone"
                                    placeholder="(+33) XX XX XX XX XX" name="client_phone" required>

                            </div>
                            <div class="form-group col-6">
                                <label for="client_last_name" class="form-label">Nom <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="100" id="client_last_name"
                                    name="client_last_name" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="client_first_name" class="form-label">Prénom</label>
                                <input type="text" class="form-control" maxlength="100" id="client_first_name"
                                    name="client_first_name">
                            </div>

                            <div class="form-group col-12">
                                <label for="client_notes" class="form-label">Ajouter une demande particulière
                                    (facultatif)</label>
                                <textarea class="form-control" maxlength="300" rows="2" id="client_notes" id="client_notes"
                                    name="client_notes"></textarea>
                            </div>

                            <div id="submittingDiv" class="col-12 text-center mb-2" style="display: none">
                                <div class="d-flex align-items-center">
                                    <strong>Réservation en cours ...</strong>
                                    <div class="spinner-border spinner-border-sm ms-auto" role="status"
                                        aria-hidden="true"></div>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="button" id="backBtn" class="btn btn-outline-black w-100">‹</button>
                            </div>
                            <div class="col-9">
                                <button type="button" id="sendBtn" class="btn btn-black w-100 text-white">Envoyer le
                                    demander</button>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('css')
    <link href="dist/css/pages/ui-bootstrap-page.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
    <link href="external/reservation.css" rel="stylesheet">
@endpush

@push('js')
    <script src="assets/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/waves.js"></script>
    <script src="dist/js/custom.min.js"></script>

    <script src="dist/js/moment-with-locales.min.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script>
        const api = 'external/demoResto/main';

        $('#date').val(moment().format('DD-MM-YYYY'));
        getSlots(api);

        $('#party').on('change', function() {
            getSlots(api);
        });
        $('#date').on('change', function() {
            getSlots(api);
        });
        $('#position').on('change', function() {
            getSlots(api);
        });
        $('#date').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            time: false,
            lang: 'fr',
            cancelText: 'Annuler',
            minDate: new Date(),
        });

        // Select the button by ID
        $("#reservationBtn")
            .attr("data-bs-toggle", "offcanvas")
            .attr("data-bs-target", "#reservationContainer")
            .attr("aria-controls", "reservationContainer");

        // Handle button move to client info screen
        $('#nextBtn').on('click', function() {
            if (!$('input[name=slot]:checked').val()) {
                return false;
            }

            $('#dateErrorMessageDiv').html('').hide();

            $('#chosenParty').html($('#party').val());
            $('#chosenDate').html(moment($('input[name=date]').val(), 'DD-MM-YYYY').format('dddd DD MMMM'));
            $('#chosenTime').html($('input[name=slot]:checked').val());
            $('#chosenPosition').html($('#position option:selected').text());

            $('#dateDiv').hide();
            $('#infoDiv').show();
        });

        // Handle button back to screen of choosing slot
        $('#backBtn').on('click', function() {
            $('#infoDiv').hide();
            $('#dateDiv').show();
        });

        // Handle button send request
        $('#sendBtn').on('click', function() {
            // Get the form
            var form = $('#reservationForm')[0];

            // Check form validity
            if (form.checkValidity() === false) {
                form.reportValidity();
                return false;
            }

            $('#infoDiv input, #infoDiv textarea').attr('readonly', true);
            $('#infoDiv button').attr('disabled', true);
            $('#submittingDiv').show();

            // Submit
            $.ajax({
                url: api + '/reserve',
                type: 'POST',
                data: $('#reservationForm').serialize(),
                success: function(response) {
                    //
                },
                error: function(xhr, status, ) {
                    console.log(xhr.responseJSON);
                    if (xhr.status === 422) {
                        const response = xhr.responseJSON;

                        // Unavailable date
                        if (response.error == 'date') {
                            $('#infoDiv').hide();

                            $('#dateErrorMessageDiv').html(response.message).show();
                            $('#dateDiv').show();
                            getSlots(api);

                            $('#infoDiv input, #infoDiv textarea').attr('readonly', false);
                            $('#infoDiv button').attr('disabled', false);
                            $('#submittingDiv').hide();
                        }

                        // Invalid info
                        const errors = response.errors;
                        Object.keys(errors).forEach(function(key) {
                            const errorMessages = errors[key];

                            console.log('Field name:', key);
                            console.log('Error messages:', errorMessages);

                            $('#' + key).addClass('is-invalid');
                            var $divErrorMessage = $("<div>", {
                                "class": "invalid-feedback",
                                "text": errorMessages
                            })
                            $('#' + key).parent().append($divErrorMessage);
                        });
                    }
                }
            }).always(function() {
                $('#infoDiv input, #infoDiv textarea').attr('readonly', false);
                $('#infoDiv button').attr('disabled', false);
                $('#submittingDiv').hide();
            });
        });

        // Handle invalid inputs - focus
        $('input').on('focus', function() {
            // Store the original value when focusing on an input with is-invalid class
            if ($(this).hasClass('is-invalid')) {
                $(this).data('originalValue', $(this).val());
            }
        });
        // Handle invalid inputs - blur
        $('input').on('blur', function() {
            // When losing focus, check if this input had is-invalid class and if value changed
            if ($(this).hasClass('is-invalid')) {
                const originalValue = $(this).data('originalValue');
                const currentValue = $(this).val();

                // If value has changed, remove the is-invalid class
                if (originalValue !== currentValue) {
                    $(this).removeClass('is-invalid');
                    $(this).parent().find('.invalid-feedback').remove();
                }
            }
        });

        // Handle invalid textareas
        $('textarea').on('blur', function() {
            $(this).removeClass('is-invalid');
            $(this).parent().find('.invalid-feedback').remove();
        });

        // Get reservation slots
        function getSlots(api) {
            $('#fullMessage').hide();
            $('#loadingDiv').show();
            $('#slotDiv').hide();
            $('#nextBtn').hide();
            
            var party = $('#party').val();
            var date = $('#date').val();

            var hasPosition = false;
            var position = null;
            if ($("#position").length > 0) {
                hasPosition = true;
                position = $('#position').val();
            }

            if (party != '' && date != '' && ((hasPosition == true && position != null) || hasPosition == false)) {
                var url = api + '/calendar';
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        'start_date': date,
                        'party': party,
                        'position': position
                    },
                    success: function(response) {
                        const slots = $('#slots');
                        slots.empty();

                        if (response.success) {
                            $.each(response.all, function(idxDate, date) {
                                var firstChecked = true;
                                date.forEach(time => {
                                    var value = Object.keys(time)[0];
                                    var status = time[value];
                                    var isChecked = false;

                                    var classCss = '';
                                    if (status == false) {
                                        classCss = 'disabled';
                                    } else {
                                        isChecked = firstChecked;
                                        firstChecked = false;
                                    }

                                    // Create a new anchor tag for each time
                                    const slot = $('<input>', {
                                        type: "radio",
                                        name: "slot",
                                        value: value,
                                        id: value,
                                        class: classCss,
                                        checked: isChecked,
                                        disabled: !status,
                                    });
                                    const label = $('<label>', {
                                        text: value,
                                        for: value
                                    });

                                    const li = $('<li>', {
                                        class: 'slot-button',
                                    });
                                    // Append the anchor to the container
                                    tag = li.append(slot).append(label);
                                    slots.append(tag);
                                });
                            });

                            $('#nextBtn').show();
                            $('#loadingDiv').hide();
                            $('#slotDiv').show();
                        } else {
                            $('#fullMessage').show();
                            $('#nextBtn').hide();
                            $('#loadingDiv').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        const slots = $('#slots');
                        slots.empty();
                        $('#nextBtn').hide();
                        $('#loadingDiv').hide();
                    }
                });
            }

            return false;
        }
    </script>
@endpush
