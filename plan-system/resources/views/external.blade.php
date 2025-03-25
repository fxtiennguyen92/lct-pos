<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link href="external/reservation.css" rel="stylesheet">
    <script src="external/reservation.js"></script>
</head>
<body>
    <div id="reservation"></div>
    <script src="external/reservation.js" defer></script>

    <div className="container">
        <div className="reservation-container">
            <h1>Reservation</h1>
            <form className="reservation-form">
                <div className="form-group">
                    <label htmlFor="party">Number of Guests</label>
                    <select id="party" name="party" required>
                        <option value="">Select number of guests</option>
                        <option value="1">1 Person</option>
                        <option value="2">2 People</option>
                        <option value="3">3 People</option>
                        <option value="4">4 People</option>
                        <option value="5">5 People</option>
                        <option value="6">6 People</option>
                        <option value="7">7 People</option>
                        <option value="8">8+ People (Please specify in notes)</option>
                    </select>
                </div>

                <div className="form-group">
                    <label htmlFor="date">Reservation Date</label>
                    <input type="date" id="date" name="date" required />
                </div>

                <div className="form-group">
                    <label htmlFor="time">Reservation Time</label>
                    <select id="time" name="time" required>
                        <option value="">Select time</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="11:30">11:30 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="12:30">12:30 PM</option>
                        <option value="13:00">1:00 PM</option>
                        <option value="13:30">1:30 PM</option>
                        <option value="18:00">6:00 PM</option>
                        <option value="18:30">6:30 PM</option>
                        <option value="19:00">7:00 PM</option>
                        <option value="19:30">7:30 PM</option>
                        <option value="20:00">8:00 PM</option>
                        <option value="20:30">8:30 PM</option>
                    </select>
                </div>

                <div className="form-group">
                    <label htmlFor="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Full Name" required />
                </div>

                <div className="form-group">
                    <label htmlFor="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required />
                </div>

                <div className="form-group">
                    <label htmlFor="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="(123) 456-7890" required />
                </div>

                <div className="form-group">
                    <label htmlFor="notes">Special Requests</label>
                    <textarea id="notes" name="notes" placeholder="Any special requests or dietary requirements?" rows={4}></textarea>
                </div>

                <button type="submit" className="submit-btn">Book My Table</button>

                <p className="form-disclaimer">
                    * We'll send a confirmation to your email. Please arrive 10 minutes before your reservation
                    time.
                </p>
            </form>
        </div>
    </div>
</body>
