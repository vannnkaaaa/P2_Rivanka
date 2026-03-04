document.addEventListener("DOMContentLoaded", () => {
  /* ======================
    VALIDATION
  ====================== */
  const isFilled = (id) => {
    const el = document.getElementById(id);
    if (!el) return false;

    if (el.type === "file") {
      return el.files.length > 0;
    }
    return el.value.trim() !== "";
  };

  const validateFields = (fields, msg) => {
    for (let id of fields) {
      if (!isFilled(id)) {
        alert(msg);
        document.getElementById(id).focus();
        return false;
      }
    }
    return true;
  };

  /* ======================
    LIVE PREVIEW TEXT
  ====================== */
  const bindText = (inputId, previewId) => {
    const i = document.getElementById(inputId);
    const p = document.getElementById(previewId);
    if (!i || !p) return;

    i.addEventListener("input", () => {
      // ganti \n dengan <br> untuk HTML
      p.innerHTML = i.value ? i.value.replace(/\n/g, "<br>") : "-";
    });
  };

  [
    ["kota_tanggal", "p-kota_tanggal"],
    ["subjek", "p-subjek"],
    ["penerima", "p-penerima"],
    ["pembuka", "p-pembuka"],
    ["isi", "p-isi"],
    ["penutup", "p-penutup"],
    ["penyusun", "p-penyusun"]

  ].forEach(([i, p]) => bindText(i, p));

  /* ======================
    RESET FUNCTIONALITY
  ====================== */
  const resetForm = () => {
    // Array semua field input
    const fields = [
      'kota_tanggal',
      'subjek',
      'penerima',
      'pembuka',
      'isi',
      'penutup',
      'penyusun'
    ];

    // Reset semua input field
    fields.forEach(fieldId => {
      const el = document.getElementById(fieldId);
      if (el) {
        el.value = '';
      }
    });

    // Reset preview ke nilai default
    document.getElementById('p-kota_tanggal').innerHTML = 'Bandung, 30 Januari 2026';
    document.getElementById('p-subjek').innerHTML = 'Programmer';
    document.getElementById('p-penerima').innerHTML = 'HRD Manager<br>Jl.Antapani No.5<br>Bandung';
    document.getElementById('p-pembuka').innerHTML = 'Berdasarkan informasi yang saya peroleh melalui LinkedIn perusahaan pada [Tanggal], saya bermaksud mengajukan lamaran pekerjaan sebagai [Nama Posisi] di [Nama Perusahaan].';
    document.getElementById('p-isi').innerHTML = 'Saya adalah lulusan [Jurusan] dengan pengalaman [Jumlah Tahun] tahun di bidang terkait. Selama pengalaman sebelumnya, saya berhasil [Sebutkan pencapaian/keahlian khusus], yang saya yakin sesuai dengan kebutuhan tim [Nama Perusahaan].';
    document.getElementById('p-penutup').innerHTML = 'Terima kasih atas pertimbangan Bapak/Ibu. Saya sangat berharap dapat mendiskusikan kualifikasi saya lebih detail dalam sesi wawancara. Hormat saya, [Nama Anda]';
    document.getElementById('p-penyusun').innerHTML = 'Rizqiaa';

    // Focus ke field pertama
    document.getElementById('kota_tanggal').focus();

    // Show confirmation message
    console.log('Form berhasil direset!');
  };

  // Attach reset button click event
  const resetBtn = document.getElementById('btnBackD');
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      if (confirm('Apakah Anda yakin ingin mereset form? Data yang sudah diisi akan hilang.')) {
        resetForm();
      }
    });
  }

  /* ======================
    SAVE FUNCTIONALITY
  ====================== */
  const saveBtn = document.getElementById('btnSimpan');
  if (saveBtn) {
    saveBtn.addEventListener('click', () => {
      const fields = [
        'kota_tanggal',
        'subjek',
        'penerima',
        'pembuka',
        'isi',
        'penutup',
        'penyusun'
      ];

      // Collect form data
      const formData = {};
      fields.forEach(fieldId => {
        const el = document.getElementById(fieldId);
        if (el) {
          formData[fieldId] = el.value;
        }
      });

      // Save to localStorage
      localStorage.setItem('suratData', JSON.stringify(formData));
      alert('Surat berhasil disimpan!');
    });
  }

  /* ======================
    PRINT FUNCTIONALITY
  ====================== */
  const printBtn = document.getElementById('btnPrint');
  if (printBtn) {
    printBtn.addEventListener('click', () => {
      // Validate required fields
      const fields = ['kota_tanggal', 'subjek', 'penerima', 'pembuka', 'isi', 'penutup', 'penyusun'];
      if (!validateFields(fields, 'Mohon lengkapi semua field sebelum mencetak!')) {
        return;
      }

      // Trigger print dialog
      window.print();
    });
  }

  /* ======================
    LOAD SAVED DATA
  ====================== */
  const loadSavedData = () => {
    const savedData = localStorage.getItem('suratData');
    if (savedData) {
      const data = JSON.parse(savedData);
      const fields = [
        'kota_tanggal',
        'subjek',
        'penerima',
        'pembuka',
        'isi',
        'penutup',
        'penyusun'
      ];

      fields.forEach(fieldId => {
        const el = document.getElementById(fieldId);
        if (el && data[fieldId]) {
          el.value = data[fieldId];
          // Trigger preview update
          el.dispatchEvent(new Event('input'));
        }
      });
    }
  };

  // Load saved data on page load
  loadSavedData();
});

/* ======================
  PRINT BUTTON
====================== */
document.getElementById("btnPrint").addEventListener("click", () => {
  window.print();
});

