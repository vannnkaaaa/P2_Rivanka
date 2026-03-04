<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rivanka - Job Application Letter</title>
    <link rel="stylesheet" href="{{ asset('css/preview.css') }}">
    <style>
        body {
            text-align: left;
        }

        .elemen-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .elemen-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .elemen-row input {
            flex: 1;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 4px 6px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 10px;
            width: 22px;
            height: 28px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-remove:hover {
            background-color: #c82333;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 5px;
            width: fit-content;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        #p-penerima,
        #p-paragraf1,
        #p-paragraf2,
        #p-paragraf3 {
            white-space: pre-line;
        }
    </style>
</head>

<body>

    <h3 class="title">Data Surat Lamaran</h3>

    <div class="container">

        <!-- ================= LEFT FORM ================= -->
        <div class="left">

            <!-- ================= SECTION A ================= -->
            <div id="step-a" class="step">

                <div class="form-group">
                    <label>Kota & Tanggal</label>
                    <input type="text" id="tanggal">
                </div>

                <div class="form-group">
                    <label>Subjek Surat</label>
                    <input type="text" id="subject">
                </div>

                <div class="form-group">
                    <label>Penerima & Alamat</label>
                    <textarea id="penerima"></textarea>
                </div>

                <div class="form-group">
                    <label>Parapraf 1 (Pembuka)</label>
                    <textarea id="paragraf1"></textarea>
                </div>

                <div class="form-group">
                    <label>Paragraf 2 (Isi)</label>
                    <textarea id="paragraf2"></textarea>
                </div>

                <div class="form-group">
                    <label>Paragraf 3 (Penutup)</label>
                    <textarea id="paragraf3"></textarea>
                </div>


                <div class="form-group">
                    <label>Nama Penyusun</label>
                    <input type="text" id="n-penyusun">
                </div>

                <div>
                    <div class="form-actions">
                        <button type="button" id="btnSave">Simpan Data </button>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="btnPrint">Cetak Surat ( PDF )</button>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="btnClear">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT PREVIEW ================= -->
        <div class="right">

            <div class="info-header">
                <img id="p-logo" class="logo" style="display:none;">

                <div class="info-text">
                    <h2><span id="p-fase">JOB APPLICATION LETTER</span></h2>
                    <br>
                    <p><span id="p-tanggal">30 Januari 2026</span></p>
                </div>
            </div>

            <!-- A -->
            <h5><span id="p-subject">Lamaran Pekerjaan</span></h5>
            <p>Dear,</p>
            <p><span id="p-penerima">Yth. HRD PT Maju Jaya Sejahtera
                    Jl. Sudirman No. 123
                    Jakarta Selatan
                </span></p>
            <br>
            <p><span id="p-paragraf1">Dengan hormat, berdasarkan informasi lowongan pekerjaan yang saya peroleh, 
                dengan ini saya mengajukan lamaran pekerjaan di perusahaan Bapak/Ibu.</span></p>
            <br>
            <p><span id="p-paragraf2">Saya merupakan lulusan Teknik Sistem Informasi yang 
                memiliki ketertarikan di bidang teknologi dan pengembangan sistem. Saya terbiasa bekerja secara mandiri maupun dalam tim.</span></p>
            <br>
            <p><span id="p-paragraf3">Demikian surat lamaran ini saya sampaikan. Besar harapan saya dapat diberikan kesempatan 
                untuk mengikuti tahapan seleksi selanjutnya.<span></p>
            <br><br>
            <p>Hormat saya,</p>
            <br>
            <p><strong><span id="p-penyusun">Nama Penyusun</span></strong></p>
        </div>


    </div>

    <script>
        function addElemen() {
            const container = document.getElementById('elemenContainer');
            const newRow = document.createElement('div');
            newRow.className = 'elemen-row';
            newRow.innerHTML = `
                <input type="text" class="elemen-input" placeholder="Masukkan elemen">
                <button type="button" class="btn-remove" onclick="removeElemen(this)">✕</button>
            `;
            container.appendChild(newRow);
            updateElemenPreview();
        }

        function removeElemen(button) {
            button.parentElement.remove();
            updateElemenPreview();
        }

        function updateElemenPreview() {
            const inputs = document.querySelectorAll('.elemen-input');
            const previewDiv = document.getElementById('p-elemen');

            let elemens = [];
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    elemens.push(input.value.trim());
                }
            });

            if (elemens.length > 0) {
                previewDiv.innerHTML = '<ul style="margin: 5px 0; padding-left: 20px;">' +
                    elemens.map(e => `<li>${e}</li>`).join('') +
                    '</ul>';
            } else {
                previewDiv.innerHTML = '-';
            }
        }

        // ========== CAPAIAN PEMBELAJARAN ==========

        // Fungsi untuk menambah Capaian Pembelajaran baru
        function addCP() {
            const container = document.getElementById('cpContainer');
            const newRow = document.createElement('div');
            newRow.className = 'elemen-row';
            newRow.innerHTML = `
                <input type="text" class="cp-input" placeholder="Masukkan capaian pembelajaran">
                <button type="button" class="btn-remove" onclick="removeCP(this)">✕</button>
            `;
            container.appendChild(newRow);
            updateCPPreview();
        }

        // Fungsi untuk menghapus Capaian Pembelajaran
        function removeCP(button) {
            button.parentElement.remove();
            updateCPPreview();
        }

        // Fungsi untuk update preview Capaian Pembelajaran
        function updateCPPreview() {
            const inputs = document.querySelectorAll('.cp-input');
            const previewDiv = document.getElementById('p-cp');

            let cps = [];
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    cps.push(input.value.trim());
                }
            });

            if (cps.length > 0) {
                previewDiv.innerHTML = '<ul style="margin: 5px 0; padding-left: 20px;">' +
                    cps.map(c => `<li>${c}</li>`).join('') +
                    '</ul>';
            } else {
                previewDiv.innerHTML = '-';
            }
        }

        // ========== TUJUAN PEMBELAJARAN ==========

        // Fungsi untuk menambah Tujuan Pembelajaran baru
        function addTujuan() {
            const container = document.getElementById('tujuanContainer');
            const newRow = document.createElement('div');
            newRow.className = 'elemen-row';
            newRow.innerHTML = `
                <input type="text" class="tujuan-input" placeholder="Masukkan tujuan pembelajaran">
                <button type="button" class="btn-remove" onclick="removeTujuan(this)">✕</button>
            `;
            container.appendChild(newRow);
            updateTujuanPreview();
        }

        // Fungsi untuk menghapus Tujuan Pembelajaran
        function removeTujuan(button) {
            button.parentElement.remove();
            updateTujuanPreview();
        }

        // Fungsi untuk update preview Tujuan Pembelajaran
        function updateTujuanPreview() {
            const inputs = document.querySelectorAll('.tujuan-input');
            const previewDiv = document.getElementById('p-tujuan');

            let tujuans = [];
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    tujuans.push(input.value.trim());
                }
            });

            if (tujuans.length > 0) {
                previewDiv.innerHTML = '<ul style="margin: 5px 0; padding-left: 20px;">' +
                    tujuans.map(t => `<li>${t}</li>`).join('') +
                    '</ul>';
            } else {
                previewDiv.innerHTML = '-';
            }
        }

        // Event listener untuk update preview saat mengetik
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('elemen-input')) {
                updateElemenPreview();
            } else if (e.target.classList.contains('cp-input')) {
                updateCPPreview();
            } else if (e.target.classList.contains('tujuan-input')) {
                updateTujuanPreview();
            }
        });
    </script>
    <script src="{{ asset('js/preview.js') }}"></script>
</body>

</html>