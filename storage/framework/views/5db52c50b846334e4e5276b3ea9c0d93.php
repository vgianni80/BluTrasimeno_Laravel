<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Prenota - <?php echo e($propertyName); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --blu-primary: #1a3a5c;
            --blu-secondary: #2c5282;
            --blu-light: #e8f0f7;
            --blu-accent: #4a90b8;
            --gold: #c9a227;
            --text-dark: #2d3748;
            --text-light: #718096;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            color: var(--text-dark);
            background: linear-gradient(135deg, #f7fafc 0%, var(--blu-light) 100%);
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }
        
        /* Header */
        .site-header {
            background: var(--blu-primary);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .site-header .logo {
            height: 50px;
        }
        
        .site-header .nav-link {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.5px;
            transition: color 0.3s;
        }
        
        .site-header .nav-link:hover {
            color: white;
        }
        
        /* Hero */
        .hero {
            background: linear-gradient(rgba(26, 58, 92, 0.85), rgba(26, 58, 92, 0.9)), 
                        url('https://www.blutrasimeno.it/wp-content/uploads/2025/07/copertina09.jpg') center/cover;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Main Content */
        .main-content {
            padding: 3rem 0;
        }
        
        /* Calendar */
        .calendar-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(26, 58, 92, 0.1);
            overflow: hidden;
        }
        
        .calendar-header {
            background: var(--blu-primary);
            color: white;
            padding: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .calendar-header h4 {
            margin: 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
        }
        
        .calendar-header button {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s;
        }
        
        .calendar-header button:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            padding: 1rem;
            background: #f8f9fa;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: 500;
            color: var(--blu-primary);
            padding: 0.75rem 0.25rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.95rem;
            position: relative;
            border: 2px solid transparent;
        }
        
        .calendar-day:hover:not(.unavailable):not(.past) {
            border-color: var(--blu-accent);
            transform: scale(1.05);
        }
        
        .calendar-day.unavailable {
            background: #fef2f2;
            color: #c9a0a0;
            cursor: not-allowed;
        }
        
        .calendar-day.past {
            color: #cbd5e0;
            cursor: not-allowed;
        }
        
        .calendar-day.selected {
            background: var(--blu-primary);
            color: white;
            border-color: var(--blu-primary);
        }
        
        .calendar-day.in-range {
            background: var(--blu-light);
            color: var(--blu-primary);
        }
        
        .calendar-day .price {
            font-size: 0.65rem;
            color: var(--gold);
            font-weight: 500;
        }
        
        .calendar-day.selected .price {
            color: rgba(255,255,255,0.8);
        }
        
        /* Booking Form */
        .booking-form {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(26, 58, 92, 0.1);
            padding: 2rem;
        }
        
        .booking-form h5 {
            color: var(--blu-primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--blu-light);
        }
        
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--blu-accent);
            box-shadow: 0 0 0 3px rgba(74, 144, 184, 0.1);
        }
        
        /* Price Summary */
        .price-summary {
            background: var(--blu-light);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.95rem;
        }
        
        .price-row.total {
            border-top: 2px solid var(--blu-primary);
            margin-top: 0.75rem;
            padding-top: 1rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--blu-primary);
        }
        
        /* Button */
        .btn-book {
            background: var(--blu-primary);
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-book:hover {
            background: var(--blu-secondary);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 58, 92, 0.2);
        }
        
        .btn-book:disabled {
            background: #cbd5e0;
            transform: none;
            box-shadow: none;
        }
        
        /* Legend */
        .legend {
            display: flex;
            gap: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        /* Info Box */
        .info-box {
            background: var(--blu-light);
            border-left: 4px solid var(--blu-accent);
            padding: 1rem 1.25rem;
            border-radius: 0 0.5rem 0.5rem 0;
            font-size: 0.9rem;
        }
        
        /* Footer */
        .site-footer {
            background: var(--blu-primary);
            color: rgba(255,255,255,0.7);
            padding: 2rem 0;
            margin-top: 3rem;
            font-size: 0.9rem;
        }
        
        .site-footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        
        .site-footer a:hover {
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .calendar-day { font-size: 0.8rem; }
            .calendar-day .price { font-size: 0.55rem; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="https://www.blutrasimeno.it/">
                    <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" class="logo">
                </a>
                <nav class="d-none d-md-block">
                    <a href="https://www.blutrasimeno.it/lappartamento/" class="nav-link d-inline-block">L'Appartamento</a>
                    <a href="https://www.blutrasimeno.it/servizi/" class="nav-link d-inline-block">Servizi</a>
                    <a href="https://www.blutrasimeno.it/galleria-fotografica/" class="nav-link d-inline-block">Galleria</a>
                    <a href="https://www.blutrasimeno.it/contatti/" class="nav-link d-inline-block">Contatti</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <h1>Prenota il tuo Soggiorno</h1>
            <p>Scegli le date e vivi un'esperienza indimenticabile sul Lago Trasimeno</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row g-4">
                <!-- Calendario -->
                <div class="col-lg-8">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button onclick="changeMonth(-1)">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <h4 id="monthYear"></h4>
                            <button onclick="changeMonth(1)">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        <div class="calendar-grid" id="calendar">
                            <div class="calendar-day-header">Lun</div>
                            <div class="calendar-day-header">Mar</div>
                            <div class="calendar-day-header">Mer</div>
                            <div class="calendar-day-header">Gio</div>
                            <div class="calendar-day-header">Ven</div>
                            <div class="calendar-day-header">Sab</div>
                            <div class="calendar-day-header">Dom</div>
                        </div>
                        <div class="legend">
                            <div class="legend-item">
                                <div class="legend-color bg-white border"></div> Disponibile
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background:#fef2f2"></div> Non disponibile
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background:var(--blu-primary)"></div> Selezionato
                            </div>
                        </div>
                    </div>

                    <div class="info-box mt-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Seleziona la data di <strong>arrivo</strong>, poi la data di <strong>partenza</strong> per vedere il prezzo del soggiorno.
                    </div>
                </div>

                <!-- Form prenotazione -->
                <div class="col-lg-4">
                    <div class="booking-form">
                        <h5><i class="bi bi-calendar-check me-2"></i>Il tuo Soggiorno</h5>

                        <form method="POST" action="<?php echo e(route('public.booking.store')); ?>" id="bookingForm">
                            <?php echo csrf_field(); ?>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label">Check-in</label>
                                    <input type="date" name="check_in" id="checkIn" class="form-control" required readonly>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Check-out</label>
                                    <input type="date" name="check_out" id="checkOut" class="form-control" required readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ospiti</label>
                                <select name="guests" id="guests" class="form-select" required>
                                    <?php for($i = 1; $i <= ($maxGuests ?? 6); $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e($i == 2 ? 'selected' : ''); ?>><?php echo e($i); ?> <?php echo e($i == 1 ? 'ospite' : 'ospiti'); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Riepilogo prezzi -->
                            <div class="price-summary" id="priceSummary" style="display:none;">
                                <div class="price-row">
                                    <span><span id="priceNights">0</span> notti</span>
                                    <span>€ <span id="priceSubtotal">0</span></span>
                                </div>
                                <div class="price-row text-success" id="discountRow" style="display:none;">
                                    <span>Sconto <span id="discountPercent">0</span>%</span>
                                    <span>- € <span id="priceDiscount">0</span></span>
                                </div>
                                <div class="price-row" id="cleaningRow" style="display:none;">
                                    <span>Pulizie finali</span>
                                    <span>€ <span id="priceCleaning">0</span></span>
                                </div>
                                <div class="price-row total">
                                    <span>Totale</span>
                                    <span>€ <span id="priceTotal">0</span></span>
                                </div>
                            </div>

                            <div id="unavailableMessage" class="alert alert-danger" style="display:none;"></div>

                            <hr>

                            <h6 class="mb-3" style="color: var(--blu-primary); font-family: 'Cormorant Garamond', serif;">I tuoi Dati</h6>

                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" name="guest_name" class="form-control" placeholder="Nome *" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="guest_surname" class="form-control" placeholder="Cognome *" required>
                                </div>
                                <div class="col-12">
                                    <input type="email" name="guest_email" class="form-control" placeholder="Email *" required>
                                </div>
                                <div class="col-12">
                                    <input type="tel" name="guest_phone" class="form-control" placeholder="Telefono">
                                </div>
                                <div class="col-12">
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Note o richieste particolari"></textarea>
                                </div>
                            </div>

                            <div class="form-check mt-3">
                                <input type="checkbox" name="privacy" class="form-check-input" id="privacy" required>
                                <label class="form-check-label small" for="privacy">
                                    Accetto il trattamento dei dati ai sensi della 
                                    <a href="https://www.blutrasimeno.it/termsfeed/privacy-policy/" target="_blank">Privacy Policy</a> *
                                </label>
                            </div>

                            <button type="submit" class="btn btn-book btn-primary w-100 mt-4" id="submitBtn" disabled>
                                <i class="bi bi-send me-2"></i>Richiedi Prenotazione
                            </button>

                            <p class="text-muted small text-center mt-3 mb-0">
                                Riceverai conferma via email entro 24 ore
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" style="height: 40px;" class="mb-2">
                    <p class="mb-0">Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)<br>CIN: IT054055C204034007</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="https://www.blutrasimeno.it/termsfeed/privacy-policy/">Privacy Policy</a> · 
                    <a href="https://www.blutrasimeno.it/termsfeed/cookies-policy/">Cookies Policy</a>
                    <p class="mb-0 mt-2">©2025 Blu Trasimeno</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth() + 1;
        let selectedCheckIn = null;
        let selectedCheckOut = null;
        let calendarData = {};

        const monthNames = ['', 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 
                           'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

        document.addEventListener('DOMContentLoaded', function() {
            loadCalendar();
            document.getElementById('guests').addEventListener('change', calculatePrice);
        });

        function changeMonth(delta) {
            currentMonth += delta;
            if (currentMonth > 12) { currentMonth = 1; currentYear++; }
            if (currentMonth < 1) { currentMonth = 12; currentYear--; }
            loadCalendar();
        }

        async function loadCalendar() {
            document.getElementById('monthYear').textContent = `${monthNames[currentMonth]} ${currentYear}`;
            
            try {
                const response = await fetch(`<?php echo e(route('public.booking.calendar')); ?>?year=${currentYear}&month=${currentMonth}`);
                const data = await response.json();
                calendarData = {};
                data.days.forEach(d => calendarData[d.date] = d);
                renderCalendar(data.days);
            } catch (error) {
                console.error('Error loading calendar:', error);
            }
        }

        function renderCalendar(days) {
            const grid = document.getElementById('calendar');
            const headers = grid.querySelectorAll('.calendar-day-header');
            grid.innerHTML = '';
            headers.forEach(h => grid.appendChild(h));

            const firstDay = new Date(currentYear, currentMonth - 1, 1);
            let startDay = firstDay.getDay() || 7;
            for (let i = 1; i < startDay; i++) {
                grid.appendChild(document.createElement('div'));
            }

            days.forEach(day => {
                const div = document.createElement('div');
                div.className = 'calendar-day';
                div.dataset.date = day.date;

                if (day.isPast) div.classList.add('past');
                else if (!day.available) div.classList.add('unavailable');

                if (selectedCheckIn && day.date === selectedCheckIn) div.classList.add('selected');
                if (selectedCheckOut && day.date === selectedCheckOut) div.classList.add('selected');
                if (selectedCheckIn && selectedCheckOut && day.date > selectedCheckIn && day.date < selectedCheckOut) {
                    div.classList.add('in-range');
                }

                div.innerHTML = `
                    <span>${day.day}</span>
                    ${day.price && day.available ? `<span class="price">€${day.price}</span>` : ''}
                `;

                if (!day.isPast && day.available) {
                    div.addEventListener('click', () => selectDate(day.date));
                }

                grid.appendChild(div);
            });
        }

        function selectDate(date) {
            if (!selectedCheckIn || (selectedCheckIn && selectedCheckOut)) {
                selectedCheckIn = date;
                selectedCheckOut = null;
            } else if (date > selectedCheckIn) {
                selectedCheckOut = date;
            } else {
                selectedCheckIn = date;
                selectedCheckOut = null;
            }

            document.getElementById('checkIn').value = selectedCheckIn || '';
            document.getElementById('checkOut').value = selectedCheckOut || '';

            renderCalendar(Object.values(calendarData));
            
            if (selectedCheckIn && selectedCheckOut) {
                calculatePrice();
            } else {
                document.getElementById('priceSummary').style.display = 'none';
                document.getElementById('submitBtn').disabled = true;
            }
        }

        async function calculatePrice() {
            if (!selectedCheckIn || !selectedCheckOut) return;

            const guests = document.getElementById('guests').value;

            try {
                const response = await fetch('<?php echo e(route('public.booking.calculate')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        check_in: selectedCheckIn,
                        check_out: selectedCheckOut,
                        guests: guests
                    })
                });

                const data = await response.json();

                if (data.available) {
                    document.getElementById('priceSummary').style.display = 'block';
                    document.getElementById('unavailableMessage').style.display = 'none';
                    
                    document.getElementById('priceNights').textContent = data.pricing.nights;
                    document.getElementById('priceSubtotal').textContent = data.pricing.subtotal.toFixed(2);
                    document.getElementById('priceTotal').textContent = data.pricing.total.toFixed(2);

                    if (data.pricing.discount > 0) {
                        document.getElementById('discountRow').style.display = 'flex';
                        document.getElementById('discountPercent').textContent = data.pricing.discount_percent;
                        document.getElementById('priceDiscount').textContent = data.pricing.discount.toFixed(2);
                    } else {
                        document.getElementById('discountRow').style.display = 'none';
                    }

                    if (data.pricing.cleaning_fee > 0) {
                        document.getElementById('cleaningRow').style.display = 'flex';
                        document.getElementById('priceCleaning').textContent = data.pricing.cleaning_fee.toFixed(2);
                    } else {
                        document.getElementById('cleaningRow').style.display = 'none';
                    }

                    document.getElementById('submitBtn').disabled = false;
                } else {
                    document.getElementById('priceSummary').style.display = 'none';
                    document.getElementById('unavailableMessage').style.display = 'block';
                    document.getElementById('unavailableMessage').textContent = data.message;
                    document.getElementById('submitBtn').disabled = true;
                }
            } catch (error) {
                console.error('Error calculating price:', error);
            }
        }
    </script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/public/booking.blade.php ENDPATH**/ ?>