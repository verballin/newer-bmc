<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Ujian</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- CSS libraries sama seperti sebelumnya -->
    <!-- <link href="<?= base_url('brem/img/icon bmc.png') ?>" rel="icon" /> -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?= base_url('brem/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('brem/css/style.css') ?>" rel="stylesheet" />

    <style>
        .timer-warning {
            color: #ff6b6b !important;
            font-weight: bold;
            animation: blink 1s infinite;
        }

        .timer-critical {
            color: #ff0000 !important;
            font-weight: bold;
            animation: blink 0.5s infinite;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0.3;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
        }

        .timer-container {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff6b6b;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 1000;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Loading Overlay untuk Auto Submit -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <h5>Mengumpulkan Jawaban...</h5>
            <p>Waktu ujian telah habis. Jawaban sedang dikumpulkan secara otomatis.</p>
            <small class="text-muted">Mohon tunggu, jangan tutup halaman ini.</small>
        </div>
    </div>

    <!-- Fixed Timer Display -->
    <div class="timer-container" id="timerContainer">
        <i class="fas fa-clock"></i>
        Sisa Waktu: <span id="timer-display"><?= sprintf("%02d:%02d", $pengaturan['waktu'], 0) ?></span>
    </div>

    <div class="container py-5">
        <h3 class="mb-4 text-center"><?= esc($pengaturan['nama_ujian']) ?></h3>

        <!-- Basic Info -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Durasi Ujian:</strong> <?= esc($pengaturan['waktu']) ?> menit |
                    <strong>Total Soal:</strong> <?= count($soal_list) ?> soal
                </div>
            </div>
        </div>

        <!-- Warning ketika waktu hampir habis -->
        <div id="timeWarning" class="alert alert-warning d-none">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Peringatan!</strong> Waktu ujian tinggal sedikit. Pastikan jawaban Anda sudah tersimpan.
        </div>

        <!-- Progress Indicator -->
        <div class="progress-container mb-4">
            <div class="progress" style="height: 8px;">
                <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
            </div>
            <small class="text-muted">Soal dijawab: <span id="answered-count">0</span> dari <?= count($soal_list) ?></small>
        </div>

        <!-- Form ujian dengan CSRF token yang benar -->
        <form id="exam-form" action="<?= site_url('pengaturanujian/simpanjawaban/' . $pengaturan['id_pengaturan']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pengaturan" value="<?= esc($pengaturan['id_pengaturan']) ?>">
            <input type="hidden" name="auto_submit" id="autoSubmit" value="0">

            <?php foreach ($soal_list as $index => $soal): ?>
                <div class="card mb-4 soal-card" data-soal-id="<?= $soal['soal_id'] ?>">
                    <div class="card-body">
                        <h5 class="card-title">Soal <?= $index + 1 ?></h5>
                        <div class="soal-content">
                            <p><?= $soal['pertanyaan'] ?></p>
                            <?php if (!empty($soal['gambar'])): ?>
                                <img src="<?= base_url('uploads/' . $soal['gambar']) ?>" class="img-fluid mt-2 img-thumbnail" alt="Gambar soal" style="max-width: 300px;">
                            <?php endif; ?>
                        </div>

                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input jawaban-radio" type="radio"
                                    name="jawaban[<?= $soal['soal_id'] ?>]"
                                    value="A" id="soal<?= $soal['soal_id'] ?>A"
                                    onchange="updateProgress()">
                                <label class="form-check-label" for="soal<?= $soal['soal_id'] ?>A">
                                    A. <?= $soal['a'] ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input jawaban-radio" type="radio"
                                    name="jawaban[<?= $soal['soal_id'] ?>]"
                                    value="B" id="soal<?= $soal['soal_id'] ?>B"
                                    onchange="updateProgress()">
                                <label class="form-check-label" for="soal<?= $soal['soal_id'] ?>B">
                                    B. <?= $soal['b'] ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input jawaban-radio" type="radio"
                                    name="jawaban[<?= $soal['soal_id'] ?>]"
                                    value="C" id="soal<?= $soal['soal_id'] ?>C"
                                    onchange="updateProgress()">
                                <label class="form-check-label" for="soal<?= $soal['soal_id'] ?>C">
                                    C. <?= $soal['c'] ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input jawaban-radio" type="radio"
                                    name="jawaban[<?= $soal['soal_id'] ?>]"
                                    value="D" id="soal<?= $soal['soal_id'] ?>D"
                                    onchange="updateProgress()">
                                <label class="form-check-label" for="soal<?= $soal['soal_id'] ?>D">
                                    D. <?= $soal['d'] ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Tombol submit -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-success btn-lg" id="submitBtn" onclick="submitExamManually()">
                    <i class="fas fa-paper-plane"></i> Kumpulkan Jawaban
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        // Global variables
        let timerInterval;
        let isSubmitted = false;
        let isTimeUp = false;
        let waktu = <?= $pengaturan['waktu'] ?> * 60; // Convert to seconds

        // Elements
        const timerDisplayEl = document.getElementById('timer-display');
        const examForm = document.getElementById('exam-form');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const timeWarning = document.getElementById('timeWarning');
        const autoSubmitInput = document.getElementById('autoSubmit');
        const submitBtn = document.getElementById('submitBtn');

        // Enhanced timer initialization function
        function initializeExamTimer(durasiMenit) {
            let timeLeft = durasiMenit * 60; // Convert to seconds

            // Update timer display every second
            timerInterval = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    isTimeUp = true;
                    handleTimeUp();
                    return;
                }

                // Update display timer
                updateTimerDisplay(timeLeft);
                timeLeft--;
                waktu = timeLeft; // Sync with global variable
            }, 1000);

            // Initial display update
            updateTimerDisplay(timeLeft);
        }

        // Handle when time is up - FIXED
        function handleTimeUp() {
            console.log('Timer habis, memulai auto submit...');

            // Prevent multiple submissions
            if (isSubmitted) {
                console.log('Form sudah di-submit, batalkan auto submit');
                return;
            }

            // Show alert that time is up
            alert('Waktu ujian telah habis! Jawaban akan dikumpulkan secara otomatis.');

            // Disable all inputs to prevent answer changes
            disableAllInputs();

            // Set auto submit flag BEFORE submitting
            autoSubmitInput.value = '1';

            // Auto submit exam
            autoSubmitExam();
        }

        // Update timer display with enhanced styling
        function updateTimerDisplay(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;

            if (timerDisplayEl) {
                timerDisplayEl.textContent = timeString;

                // Update fixed timer background color based on time remaining
                const fixedTimer = timerDisplayEl.closest('.timer-container');
                if (fixedTimer) {
                    if (seconds <= 60) { // Last minute - red
                        fixedTimer.style.background = '#dc3545';
                        fixedTimer.style.animation = 'blink 0.5s infinite';
                    } else if (seconds <= 300) { // Last 5 minutes - orange
                        fixedTimer.style.background = '#fd7e14';
                        fixedTimer.style.animation = 'blink 1s infinite';
                    } else {
                        fixedTimer.style.background = '#ff6b6b';
                        fixedTimer.style.animation = 'none';
                    }
                }
            }

            // Show warning at 5 minutes
            if (seconds === 300) {
                timeWarning.classList.remove('d-none');
            }

            // Final warning at 1 minute
            if (seconds === 60) {
                if (confirm('Waktu ujian tinggal 1 menit! Pastikan jawaban Anda sudah lengkap.')) {
                    // User clicked OK
                }
            }
        }

        // Disable all form inputs
        function disableAllInputs() {
            const inputs = document.querySelectorAll('input[type="radio"], input[type="checkbox"]');
            inputs.forEach(input => {
                input.disabled = true;
            });

            // Disable submit button
            if (submitBtn) {
                submitBtn.disabled = true;
            }
        }

        // Auto submit exam function - COMPLETELY REWRITTEN
        function autoSubmitExam() {
            console.log('Memulai autoSubmitExam...');

            if (isSubmitted) {
                console.log('Form sudah di-submit, keluar dari autoSubmitExam');
                return;
            }

            isSubmitted = true;

            // Show loading overlay
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }

            // Collect all form data manually
            const formData = new FormData();

            // Add hidden fields
            formData.append('id_pengaturan', '<?= $pengaturan['id_pengaturan'] ?>');
            formData.append('auto_submit', '1');

            // Add all selected answers
            const selectedAnswers = document.querySelectorAll('input[name^="jawaban["]:checked');
            console.log('Jawaban yang dipilih:', selectedAnswers.length);

            selectedAnswers.forEach(function(input) {
                formData.append(input.name, input.value);
                console.log('Menambahkan jawaban:', input.name, '=', input.value);
            });

            // Create AJAX request instead of form.submit()
            fetch('<?= site_url('pengaturanujian/simpanjawaban/' . $pengaturan['id_pengaturan']) ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    console.log('Respon dari server diterima');
                    // Hide loading overlay
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }

                    // Redirect to results page or reload
                    if (data.includes('hasilujian') || data.includes('nilai')) {
                        // If response contains result page, show it
                        document.open();
                        document.write(data);
                        document.close();
                    } else {
                        // Otherwise redirect
                        window.location.href = '<?= site_url('ujian') ?>';
                    }
                })
                .catch(error => {
                    console.error('Error dalam auto submit:', error);

                    // Hide loading overlay
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }

                    alert('Terjadi kesalahan saat mengumpulkan jawaban. Akan mencoba lagi...');

                    // Fallback: try traditional form submit
                    try {
                        examForm.submit();
                    } catch (submitError) {
                        console.error('Form submit juga gagal:', submitError);
                        location.reload();
                    }
                });
        }

        // Manual submit function - IMPROVED
        function submitExamManually() {
            if (isSubmitted) {
                console.log('Form sudah di-submit sebelumnya');
                return;
            }

            if (confirm('Apakah Anda yakin ingin mengumpulkan jawaban?')) {
                isSubmitted = true;
                clearInterval(timerInterval);

                // Update submit button
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengumpulkan...';
                }

                // Make sure auto_submit is not set for manual submission
                autoSubmitInput.value = '0';

                // Submit form normally for manual submission
                try {
                    examForm.submit();
                } catch (error) {
                    console.error('Error submitting form:', error);
                    alert('Terjadi kesalahan saat mengumpulkan jawaban. Silakan coba lagi.');
                    isSubmitted = false; // Reset flag
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kumpulkan Jawaban';
                    }
                }
            }
        }

        // Function to update progress
        function updateProgress() {
            const totalSoal = <?= count($soal_list) ?>;
            const answeredInputs = document.querySelectorAll('.jawaban-radio:checked');
            const answeredCount = answeredInputs.length;

            const answeredCountEl = document.getElementById('answered-count');
            const progressBarEl = document.getElementById('progress-bar');

            if (answeredCountEl) {
                answeredCountEl.textContent = answeredCount;
            }

            if (progressBarEl) {
                const progressPercentage = (answeredCount / totalSoal) * 100;
                progressBarEl.style.width = progressPercentage + '%';
            }
        }

        // Prevent leaving page without submitting
        window.addEventListener('beforeunload', function(e) {
            if (!isSubmitted && !isTimeUp) {
                e.preventDefault();
                e.returnValue = 'Anda yakin ingin meninggalkan halaman ujian?';
                return e.returnValue;
            }
        });

        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                console.log('User meninggalkan tab ujian');
                // Optional: add logging or warning
            }
        });

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, menginisialisasi timer...');
            const durasiMenit = <?= $pengaturan['waktu'] ?>;
            initializeExamTimer(durasiMenit);
            updateProgress(); // Initial progress update

            // Add event listeners to all radio buttons
            const radioButtons = document.querySelectorAll('.jawaban-radio');
            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', updateProgress);
            });
        });

        // Prevent multiple form submissions
        if (examForm) {
            examForm.addEventListener('submit', function(e) {
                if (isSubmitted) {
                    console.log('Mencegah multiple submission');
                    e.preventDefault();
                    return false;
                }
            });
        }
    </script>
</body>

</html>