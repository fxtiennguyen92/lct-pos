@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Reservation') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <button class="btn btn-danger text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#reservationContainer"
        aria-controls="reservationContainer">Offcanvas Right</button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="reservationContainer" aria-labelledby="reservationContainerLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-medium">Restaurant</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">
            <form id="submitForm" method="post" class="reservation-container">
                <div id="dateDiv">
                    <h5 class="text-center font-medium mb-4">Réservation</h5>
                    <div class="row">
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
                        <div class="form-group col-md-6 col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" class="form-control" maxlength="10" id="date" name="date"
                                placeholder="Date">
                        </div>
                        <div class="form-group col-md-6 col-6">
                            <label class="form-label">Place</label>
                            <select class="form-select" id="position" name="position">
                                <option value="1">En salle</option>
                                <option value="2">Terrase</option>
                            </select>
                        </div>
                        <div class="slot-container col-12">
                            <div id="loadingDiv" class="text-center" style="display: none;">
                                <div class="spinner-border" role="status"></div>
                            </div>
                            <div id="fullMessage" class="alert alert-warning" style="display: none">
                                Aucune place n'est disponible
                            </div>
                            <div class="input-group">
                                <ul id="slots" class="icheck-list">
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <button id="nextBtn" class="btn btn-info w-100 text-white"
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

                            <div class="form-group col-6">
                                <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="100" id="last_name"
                                    name="client_last_name" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="100" id="first_name"
                                    name="client_first_name" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="phone" class="form-label">Numéro de téléphone <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" maxlength="100" id="phone"
                                    placeholder="(+33) XX XX XX XX XX" name="client_phone" required>
                                <small class="text-danger">Si le numéro de téléphone est incorrect, votre
                                    réservation sera annulée.</small>
                            </div>
                            <div class="form-group col-12">
                                <label for="email" class="form-label">Address e-mail <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" maxlength="100" id="email"
                                    name="client_email" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="notes" class="form-label">Ajouter une demende particulière
                                    (facultatif)</label>
                                <textarea class="form-control" maxlength="500" rows="3" id="notes" name="client_notes"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <h6 class="text-warning mb-0">Cet établissement doit confirmer votre
                                        réservation</h6>
                                    Une fois que vous aurez envoyé votre demande, vous recevrez un e-mail lorsque
                                    cet
                                    établissement aura confirmé votre réservation.
                                </div>
                            </div>
                            <div class="col-3">
                                <button id="backBtn" class="btn btn-outline-black w-100">‹</button>
                            </div>
                            <div class="col-9">
                                <button id="sendBtn" class="btn btn-info w-100 text-white">Envoyer le demander</button>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('css')
    <link href="assets/node_modules/wizard/steps.css" rel="stylesheet">
    <link href="assets/node_modules/icheck/skins/all.css" rel="stylesheet">
    <link href="dist/css/pages/form-icheck.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
    <link href="external/reservation.css" rel="stylesheet">
@endpush

@push('js')
    <script src="dist/js/moment-with-locales.min.js"></script>
    <script src="assets/node_modules/icheck/icheck.min.js"></script>
    <script src="assets/node_modules/icheck/icheck.init.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="assets/node_modules/wizard/jquery.steps.min.js"></script>
    <script>
        $('#nextBtn').on('click', function() {
            if (!$('input[name=slot]').val()) {
                return false;
            }

            $('#chosenParty').html($('#party').val());
            $('#chosenDate').html(moment($('input[name=date]').val(), 'DD-MM-YYYY').format('dddd DD MMMM'));
            $('#chosenTime').html($('input[name=slot]').val());
            $('#chosenPosition').html($('#position option:selected').text());

            $('#infoDiv').show();
            $('#dateDiv').hide();
        });

        $('#backBtn').on('click', function() {
            $('#infoDiv').hide();
            $('#dateDiv').show();
        });

        $('#sendBtn').on('click', function() {
            // Get the form
            var form = $('#submitForm')[0];

            // Check form validity
            if (form.checkValidity() === false) {
                form.reportValidity();
                return;
            }

            $('#submitForm').attr('action', api + '/reserve');
            $('#submitForm').submit();

            // $.ajax({
            //     url: api + '/reserve',
            //     type: 'POST',
            //     data: $(form).serialize(),
            //     success: function(response) {
            //         $('#result').html('Submission successful: ' + response);
            //     },
            //     error: function(xhr, status, error) {
            //         $('#result').html('Submission failed: ' + error);
            //     }
            // });
        });

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

        function getSlots(api) {
            $('#fullMessage').hide();
            $('#loadingDiv').show();
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

                                    var classCss = 'check';
                                    if (status == false) {
                                        classCss = 'check disabled';
                                    } else {
                                        isChecked = firstChecked;
                                        firstChecked = false;
                                    }

                                    // Create a new anchor tag for each time
                                    const slot = $('<input>', {
                                        type: "radio",
                                        name: "slot",
                                        'data-radio': "iradio_line",
                                        'data-label': value,
                                        value: value,
                                        class: classCss,
                                        checked: isChecked,
                                        disabled: !status,
                                    });

                                    const li = $('<li>');
                                    // Append the anchor to the container
                                    tag = li.append(slot);
                                    slots.append(tag);
                                });
                            });

                            icheckfirstinit();
                            $('#nextBtn').show();
                            $('#loadingDiv').hide();
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

        $('#submitBtn').on('click', function() {

        })
    </script>
@endpush
