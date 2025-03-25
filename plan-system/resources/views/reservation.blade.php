@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Reservation') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="reservation-container">
                    <h2 class="text-center mb-4">Reservation</h2>
                    <form id="submitForm" method="post" class="reservation-form row">
                        <div class="form-group col-md-4 col-12">
                            <label for="party" class="form-label">Nombre de personnes</label>
                            <select class="form-select" id="party" name="party">
                                <option value="1">1</option>
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
                        <div class="form-group col-md-4 col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" class="form-control" maxlength="10" id="date" name="date"
                                placeholder="Date">
                        </div>
                        <div class="form-group col-md-4 col-6">
                            <label class="form-label">Place</label>
                            <select class="form-select" id="position" name="position">
                                <option value="1">En salle</option>
                                <option value="2">Terrase</option>
                            </select>
                        </div>
                        <div class="slot-container">
                            <div id="fullMessage" class="alert alert-warning" style="display: none">
                                Aucune place n'est disponible
                            </div>
                            <div class="input-group">
                                <ul id="slots" class="icheck-list">
                                </ul>
                            </div>
                        </div>

                        <div id="infoDiv" class="col-12 row">
                            <div class="col-12">
                                <h4 class="font-medium">Coordonnées</h4>
                                <ul>
                                    <li class="text-danger">Si le numéro de téléphone est incorrect, votre réservation sera annulée.</li>
                                </ul>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label for="last_name" class="form-label">Nom</label>
                                <input type="text" class="form-control" maxlength="100" id="last_name"
                                    name="client_last_name" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="first_name" class="form-label">Prénom</label>
                                <input type="text" class="form-control" maxlength="100" id="first_name"
                                    name="client_first_name" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="phone" class="form-label">Numéro de téléphone</label>
                                <input type="text" class="form-control" maxlength="100" id="phone"
                                    name="client_phone" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="email" class="form-label">Address e-mail</label>
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
                                    <h6 class="text-warning mb-0">Cet établissement doit confirmer votre réservation</h6>
                                    Une fois que vous aurez envoyé votre demande, vous recevrez un e-mail lorsque cet
                                    établissement aura confirmé votre réservation.
                                </div>
                                <button id="submitBtn" type="button" class="btn btn-info font-medium w-100 text-white">Envoyer le
                                    demande</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    <link href="assets/node_modules/icheck/skins/all.css" rel="stylesheet">
    <link href="dist/css/pages/form-icheck.css" rel="stylesheet">
    <link href="external/reservation.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
@endpush

@push('js')
    <script src="dist/js/moment-with-locales.min.js"></script>
    <script src="assets/node_modules/icheck/icheck.min.js"></script>
    <script src="assets/node_modules/icheck/icheck.init.js"></script>
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
        })

        

        function getSlots(api) {
            $('#fullMessage').hide();
            $('#infoDiv').hide();
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
                            $('#infoDiv').show();
                        } else {
                            $('#fullMessage').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error');
                        const slots = $('#slots');
                        slots.empty();

                        console.error('Ajax request failed:', error);
                    }
                });
            }

            return false;
        }
        
        $('#submitBtn').on('click', function() {
            $('#submitForm').attr('action', api + '/reserve');
            $('#submitForm').submit();
        })
    </script>
@endpush
