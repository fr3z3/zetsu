@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Form Booking Lapangan</h2>

    <form class="mt-4" id="booking-form" method="POST" action="{{ route('booking.submit') }}">
    @csrf
    <input type="hidden" name="tanggal" id="input-tanggal" required>
    <input type="hidden" name="jam" id="input-waktu" required>
    <input type="hidden" name="lapangan" id="input-lapangan" required>
    

        <!-- Dropdown Jenis Lapangan -->
        <div class="mb-4">
            <label class="form-label">Jenis Lapangan</label>
            <select class="form-select" id="jenis-lapangan" required>
                <option value="">-- Pilih Jenis Lapangan --</option>
                <option value="futsal">Futsal</option>
                <option value="badminton">Badminton</option>
                <option value="basket">Basket</option>
                <option value="tenis">Tenis</option>
            </select>
        </div>

        <!-- Pilihan Lapangan -->
        <div class="mb-4" id="pilihan-lapangan">
            <label class="form-label">Pilih Lapangan</label>
            <div class="row" id="lapangan-options"></div>
        </div>

        <div id="booking-section" style="display:none;">
            <div class="row">
                <!-- Kalender -->
                <div class="col-lg-6 col-12 mb-4">
                    <div class="border rounded shadow-sm p-3">
                        <div id="calendar-container" style="display:none;">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>

                <!-- Slot Waktu -->
                <div class="col-lg-6 col-12 mb-4" id="slot-container" style="display:none;">
                    <div class="border rounded shadow-sm p-3">
                        <h5 class="mb-3 text-center fw-semibold">Waktu Tersedia - <span id="selected-date"></span></h5>
                        <div class="row text-center fw-medium">
                            <div class="col-4">Morning</div>
                            <div class="col-4">Afternoon</div>
                            <div class="col-4">Evening</div>
                        </div>
                        <hr>
                        <div class="row" id="slot-row"></div>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-3" id="payment-method" style="display:none;">
                <label class="form-label">Metode Pembayaran</label>
                <div class="form-check"><input class="form-check-input" type="radio" name="pembayaran" value="cash" required> Cash</div>
                <div class="form-check"><input class="form-check-input" type="radio" name="pembayaran" value="transfer"> Transfer</div>
                <div class="form-check"><input class="form-check-input" type="radio" name="pembayaran" value="qris"> QRIS</div>
            </div>

            <!-- Sebelum </form> -->
                    <!-- Sebelum </form> -->
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary" id="submit-btn" style="display:none;">Booking Sekarang</button>
        </div>
    </form> <!-- Pindahkan tutup form di sini, setelah tombol submit -->
</div>

<!-- Modal Struk Booking -->
<div class="modal fade" id="strukModal" tabindex="-1" aria-labelledby="strukModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="strukModalLabel">Struk Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="struk-body">
        <!-- Isi struk akan di-generate dari JS -->
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" id="btn-selesai" data-bs-dismiss="modal">Selesai</button>
      <button id="btn-download" class="btn btn-primary">Download Struk</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<style>
    .time-slot-btn.btn-success {
        background-color: #198754 !important;
        color: white !important;
    }
    #calendar {
        max-width: 500px;
        margin: 0 auto;
    }
    .pilih-lapangan-card.border-success {
        border: 2px solid #198754 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarContainer = document.getElementById('calendar-container');
    const calendarEl = document.getElementById('calendar');
    const slotContainer = document.getElementById('slot-container');
    const selectedDateEl = document.getElementById('selected-date');
    const inputTanggal = document.getElementById('input-tanggal');
    const inputWaktu = document.getElementById('input-waktu');
    const inputLapangan = document.getElementById('input-lapangan');
    const bookingSection = document.getElementById('booking-section');
    const paymentMethod = document.getElementById('payment-method');
    const submitBtn = document.getElementById('submit-btn');
    const slotRow = document.getElementById('slot-row');

    const timeSlots = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '19:00', '20:00', '21:00' ];

    let calendar;

    const lapanganData = {
        futsal: [
            { nama: 'Lapangan 1', harga: 100000, gambar: 'images/putsal.jpg' },
            { nama: 'Lapangan 2', harga: 95000, gambar: 'images/futsal1.webp' },
            { nama: 'Lapangan 3', harga: 90000, gambar: 'images/futsal2.jpg' },
        ],
        badminton: [
            { nama: 'Lapangan 1', harga: 60000, gambar: 'images/badmin.webp' },
            { nama: 'Lapangan 2', harga: 65000, gambar: 'images/badmin.webp' },
            { nama: 'Lapangan 3', harga: 70000, gambar: 'images/badmin.webp' },
        ],
        basket: [
            { nama: 'Lapangan 1', harga: 120000, gambar: 'images/basket.jpeg' },
            { nama: 'Lapangan 2', harga: 110000, gambar: 'images/basket1.jpg' },
            { nama: 'Lapangan 3', harga: 115000, gambar: 'images/basket2.jpg' },
        ],
        tenis: [
            { nama: 'Lapangan 1', harga: 85000, gambar: 'images/tenis.jpg' },
            { nama: 'Lapangan 2', harga: 90000, gambar: 'images/tenis.jpg' },
            { nama: 'Lapangan 3', harga: 95000, gambar: 'images/tenis.jpg' },
        ],
    };

    const jenisLapanganSelect = document.getElementById('jenis-lapangan');
    const lapanganOptionsContainer = document.getElementById('lapangan-options');

    jenisLapanganSelect.addEventListener('change', function () {
        const jenis = this.value;
        lapanganOptionsContainer.innerHTML = '';

        if (lapanganData[jenis]) {
            lapanganData[jenis].forEach((lapangan) => {
                const fullName = `${jenis.charAt(0).toUpperCase() + jenis.slice(1)} - ${lapangan.nama}`;
                const card = `
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 pilih-lapangan-card" data-nama="${fullName}">
                            <img src="${lapangan.gambar}" class="card-img-top" alt="${lapangan.nama}">
                            <div class="card-body">
                                <h5 class="card-title">${fullName}</h5>
                                <p class="card-text">Harga: Rp${lapangan.harga.toLocaleString()} / jam</p>
                                <button type="button" class="btn btn-outline-primary w-100">Pilih</button>
                            </div>
                        </div>
                    </div>
                `;
                lapanganOptionsContainer.innerHTML += card;
            });

            document.querySelectorAll('.pilih-lapangan-card').forEach(card => {
                card.querySelector('button').addEventListener('click', function () {
                    inputLapangan.value = card.dataset.nama;
                    document.querySelectorAll('.pilih-lapangan-card').forEach(c => c.classList.remove('border-success'));
                    card.classList.add('border-success');

                    bookingSection.style.display = 'block';
                    calendarContainer.style.display = 'block';

                    if (!calendar) {
                        calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            headerToolbar: {
                                left: 'today',
                                center: 'title',
                                right: 'prev,next'
                            },
                            dateClick: function(info) {
                                const selectedDate = info.dateStr;
                                inputTanggal.value = selectedDate;
                                selectedDateEl.textContent = selectedDate;
                                slotContainer.style.display = 'block';
                                slotRow.innerHTML = '';

                                fetch(`/api/booked-slots?tanggal=${selectedDate}&lapangan=${encodeURIComponent(inputLapangan.value)}`)
    .then(response => response.json())
    .then(booked => {
        slotRow.innerHTML = '';  // Kosongkan slotRow sebelum diupdate

        // Loop untuk semua timeSlots
        timeSlots.forEach((time, index) => {
            let durasi = parseInt(document.getElementById('input-durasi')?.value || 1);
            let canUse = true;

            // Cek apakah semua slot dalam durasi tidak bentrok
            for (let i = 0; i < durasi; i++) {
                const nextSlot = timeSlots[index + i];
                if (!nextSlot || booked.includes(nextSlot)) {
                    canUse = false;
                    break;
                }
            }

            // Tetap tampilkan semua slot waktu
            slotRow.innerHTML += `
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn w-100 ${canUse ? 'btn-outline-info time-slot-btn' : 'btn-secondary disabled'}" data-time="${time}" ${canUse ? '' : 'disabled'}>
                        ${time}
                    </button>
                </div>
            `;
        });

        // Event listener untuk memilih slot waktu
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                inputWaktu.value = this.dataset.time;
                document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('btn-success'));
                this.classList.add('btn-success');

                if (!document.getElementById('durasi-container')) {
                    const durasiHTML = `
                        <div class="mt-3" id="durasi-container">
                            <label class="form-label">Berapa Jam Main?</label>
                            <input type="number" min="1" max="5" class="form-control" id="input-durasi" name="durasi" placeholder="Contoh: 2" required>
                        </div>
                    `;
                    paymentMethod.insertAdjacentHTML('beforebegin', durasiHTML);
                    document.getElementById('input-durasi').addEventListener('input', function () {
                        if (calendar) {
                            const currentDate = calendar.getDate();
                            calendar.dispatch({ type: 'dateClick', date: currentDate });
                        }
                    });
                }

                paymentMethod.style.display = 'block';
                submitBtn.style.display = 'block';
            });
        });
    });
                            }
                        });

                        calendar.render();
                    }
                });
            });
        }
    });

    let bookedSlots = {};
    const bookingSubmitUrl = "{{ route('booking.submit') }}";

    // Submit form booking
    document.getElementById('submit-btn').addEventListener('click', function(e) {
    e.preventDefault();

    const durasiInput = document.getElementById('input-durasi');
    if (!durasiInput || durasiInput.value === '') {
        Swal.fire('Durasi belum diisi', 'Silakan isi berapa jam main.', 'warning');
        return;
    }

    const pembayaranInput = document.querySelector('input[name="pembayaran"]:checked');
    if (!pembayaranInput) {
        Swal.fire('Metode pembayaran belum dipilih', 'Silakan pilih metode pembayaran.', 'warning');
        return;
    }

    const formElement = document.getElementById('booking-form'); // ✅ Perbaikan di sini
    const formData = new FormData(formElement);

    fetch(formElement.action, {
    method: 'POST',
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
})

    .then(response => {
        if (!response.ok) throw response;
        return response.json();
    })
    .then(data => {
        const booking = data.data;
        const strukBody = document.getElementById('struk-body');
        strukBody.innerHTML = `
            <p><strong>Lapangan:</strong> ${booking.lapangan}</p>
            <p><strong>Tanggal:</strong> ${booking.tanggal}</p>
            <p><strong>Waktu:</strong> ${booking.jam}</p>
            <p><strong>Durasi:</strong> ${booking.durasi} jam</p>
            <p><strong>Pembayaran:</strong> ${booking.pembayaran}</p>
            <p><strong>Status:</strong> ${booking.status}</p>
        `;

        const strukModal = new bootstrap.Modal(document.getElementById('strukModal'));
        strukModal.show();

        formElement.reset();
        bookingSection.style.display = 'none';
    })
    .catch(error => {
        error.text().then(errText => {
            console.error("Raw error response:", errText);
            Swal.fire('Gagal', 'Terjadi kesalahan saat memproses booking.', 'error');
        });
    });
});


    // Tombol Selesai - reload halaman (PENTING: Dipasang hanya 1x)
    document.getElementById('btn-selesai').addEventListener('click', function () {
        location.reload();
    });

    // Tombol Download text
            document.getElementById('btn-download').addEventListener('click', function () {
            const lapangan = document.querySelector('#struk-body p:nth-child(1)')?.textContent || '';
            const tanggal = document.querySelector('#struk-body p:nth-child(2)')?.textContent || '';
            const waktu = document.querySelector('#struk-body p:nth-child(3)')?.textContent || '';
            const durasi = document.querySelector('#struk-body p:nth-child(4)')?.textContent || '';
            const pembayaran = document.querySelector('#struk-body p:nth-child(5)')?.textContent || '';

            const strukText = 
        `${lapangan}
        ${tanggal}
        ${waktu}
        ${durasi}
        ${pembayaran}`;

            const blob = new Blob([strukText], { type: 'text/plain' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'struk-booking.txt';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
});

</script>
@endpush

