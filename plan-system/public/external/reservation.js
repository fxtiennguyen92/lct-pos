

document.addEventListener("DOMContentLoaded", function () {
    const host = "http://localhost/lct-pos/plan-system/public";

    // Load additional styles and scripts
    loadCSS(host + "/dist/css/pages/form-icheck.css");
    loadCSS(host + "/external/reservation.css");
    
    loadScript(host + "/assets/node_modules/jquery/dist/jquery.min.js", function () {
        console.log("jQuery loaded!");

        loadScript(host + "/assets/node_modules/icheck/icheck.min.js");
        loadScript(host + "/assets/node_modules/icheck/icheck.init.js");
    });
    // loadScript(host + "/assets/node_modules/jquery/dist/jquery.min.js");
    // loadScript(host + "/assets/node_modules/icheck/icheck.min.js");
    // loadScript(host + "/assets/node_modules/icheck/icheck.init.js");
    

    // Create the form dynamically and inject it into the page
    const formContainer = document.getElementById("reservation");
    if (formContainer) {
        formContainer.innerHTML = `
            <div className="reservation-container">
                <h1>Reservation</h1>
                <form id="submitForm" className="reservation-form">
                    <div className="form-group">
                        <label htmlFor="party">Nombre de personnes</label>
                        <select id="party" name="party" required>
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

                    <div className="form-group">
                        <label htmlFor="date">Date</label>
                        <input type="date" id="date" name="date" min="<?= date('Y-m-d'); ?>"/>
                    </div>

                    <!-- Location -->

                    <div class="form-group">
                        <label>Heure</label>
                        <div class="input-group">
                            <ul id="slots" class="icheck-list">
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        `;

        const form = document.getElementById("submitForm");
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(form);

            fetch("https://yourbackend.com/api/reservation", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert("Reservation successful!");
            })
            .catch(error => {
                alert("Reservation failed. Please try again.");
            });
        });

        document.getElementById('party').addEventListener('change', function() {
            getSlots();
        });
        
        document.getElementById('date').addEventListener('change', function() {
            getSlots();
        });
    }
});

// Function to load CSS dynamically
function loadCSS(url) {
    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = url;
    document.head.appendChild(link);
}

// Function to load additional JS dynamically
function loadScript(url, callback) {
    const script = document.createElement("script");
    script.src = url;
    script.async = true;
    script.onload = callback;
    document.body.appendChild(script);

    
}


function getSlots() {
    var party = document.getElementById('party').value;
    var date = document.getElementById('date').value;

    var hasPosition = false;
    var position = null;
    var positionElement = document.getElementById('position');
    if (positionElement) {
        hasPosition = true;
        position = positionElement.value;
    }

    if (party !== '' && date !== '' && ((hasPosition && position !== null) || !hasPosition)) {
        var url = "external/demoResto/main/calendar";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url + '?start_date=' + date + '&party=' + party + '&position=' + position, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var slotsContainer = document.getElementById('slots');
                slotsContainer.innerHTML = '';

                const slots = response.all;
                Object.keys(response.all).forEach((d) => {
                    slots[d].forEach(function(time) {
                        var value = Object.keys(time)[0];
                        var status = time[value];

                        var classCss = 'check';
                        if (!status) {
                            classCss = 'check disabled';
                        }

                        var input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'slot';
                        input.dataset.radio = 'iradio_line';
                        input.dataset.label = value;
                        input.value = value;
                        input.className = classCss;
                        input.disabled = !status;

                        var li = document.createElement('li');
                        li.appendChild(input);
                        slotsContainer.appendChild(li);
                    });
                });

                icheckfirstinit(); // Assuming icheckfirstinit is defined elsewhere
            } else {
                alert('Error');
                var slotsContainer = document.getElementById('slots');
                slotsContainer.innerHTML = '';
                console.error('Request failed. Status: ' + xhr.status);
            }
        };
        xhr.onerror = function() {
            alert('Error');
            console.error('Network error occurred');
        };
        xhr.send();
    }

    return false;
}