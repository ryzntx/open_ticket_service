(function () {
  const scriptTag = document.currentScript;
  const preselectedCategory = scriptTag.getAttribute("data-category");

  const style = document.createElement("style");
  style.textContent = `
    :root {
      --accent: #2563eb;
      --bg: #ffffff;
      --panel: #f8fafc;
      --muted: #6b7280;
      --radius: 12px;
      font-family: Inter, system-ui, sans-serif;
    }
    .support.floating-btn {
      position: fixed; right: 20px; bottom: 20px;
      background: var(--accent); color: white; border: none;
      padding: 14px 18px; border-radius: 999px;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
      cursor: pointer; display: inline-flex; gap: 8px; align-items: center;
      font-weight: 600; z-index: 1000;
    }
    .support.ticket-panel {
      position: fixed; right: 20px; bottom: 80px; width: 380px;
      max-width: calc(100% - 40px); background: var(--bg);
      border-radius: var(--radius);
      box-shadow: 0 20px 50px rgba(2, 6, 23, 0.2);
      overflow: hidden; transform-origin: bottom right;
      z-index: 1000; transition: transform 0.2s, opacity 0.18s;
      opacity: 0; transform: scale(0.95) translateY(8px);
      pointer-events: none;
    }
    .support.ticket-panel.open {opacity: 1; transform: scale(1) translateY(0); pointer-events: auto;}
    .support.panel-header {padding: 14px 16px; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; background: rgba(37, 99, 235, 0.04);}
    .support.panel-title {font-weight: 700;}
    .support.close-btn {background: transparent; border: none; font-size: 16px; cursor: pointer; color: var(--muted);}
    .support.panel-body {padding: 12px 16px 16px; max-height: 80vh; overflow-y: auto;}
    .support label {display: block; font-size: 13px; margin-bottom: 6px; font-weight: 600;}
    .support input, textarea, select {width: 100%; padding: 9px 10px; border-radius: 8px; border: 1px solid #e6eef8; background: var(--panel); font-size: 14px; margin-bottom: 12px; box-sizing: border-box;}
    .support textarea {min-height: 80px;}
    .support.actions {display: flex; gap: 8px; justify-content: flex-end;}
    .support.btn {padding: 8px 12px; border-radius: 10px; border: none; cursor: pointer; font-weight: 700;}
    .support.btn.primary {background: var(--accent); color: white;}
    .support.btn.ghost {background: transparent; border: 1px solid #e6eef8;}
    .support.alert {padding: 10px; border-radius: 6px; margin-bottom: 12px; font-size: 14px; display: none;}
    .support.alert.success {background: #d1fae5; color: #065f46;}
    .support.alert.error {background: #fee2e2; color: #991b1b;}
    @media (max-width: 480px) {
      .support.ticket-panel {
        width: 100%;
        max-width: none;
        right: 0;
        bottom: 0;
        border-radius: 0;
      }
      .support.floating-btn {
        right: 10px;
        bottom: 10px;
        padding: 12px 16px;
        font-size: 14px;
      }
    }
    #cf-turnstile {
      display: flex;
      justify-content: center;
      margin: 12px 0;
    }
  `;
  document.head.appendChild(style);

  // FilePond CSS
  const filePondCSS = document.createElement('link');
  filePondCSS.rel = 'stylesheet';
  filePondCSS.href = 'https://unpkg.com/filepond@^4/dist/filepond.min.css';
  document.head.appendChild(filePondCSS);

  // FilePond JS
  const filePondScript = document.createElement('script');
  filePondScript.src = 'https://unpkg.com/filepond@^4/dist/filepond.min.js';
  document.head.appendChild(filePondScript);

  const btn = document.createElement("button");
  btn.className = "support floating-btn";
  btn.textContent = "Buat Tiket Bantuan";
  document.body.appendChild(btn);

  const panel = document.createElement("div");
  panel.className = "support ticket-panel";
  panel.innerHTML = `
    <div class="support panel-header">
      <div class="support panel-title">Buat Tiket Bantuan</div>
      <button class="support close-btn">&times;</button>
    </div>
    <div class="support panel-body">
      <div id="alertBox" class="support alert"></div>
      <form id="ticketForm" enctype="multipart/form-data" class="support">
        <label>Nama (wajib)</label>
        <input type="text" name="sender_name" required placeholder="Masukkan nama Anda">
        <label>Email (wajib)</label>
        <input type="email" name="sender_email" required placeholder="Masukkan email Anda">
        <label>Kategori (wajib)</label>
        <select name="category_id" id="categorySelect" required>
          <option value="">Memuat kategori...</option>
        </select>
        <label>Judul (wajib)</label>
        <input type="text" name="title" id="title" required placeholder="Contoh: Login gagal di SIAKAD">
        <label>Deskripsi (wajib)</label>
        <textarea name="description" id="description" required placeholder="Jelaskan masalah secara rinci..."></textarea>
        <label>Prioritas (wajib)</label>
        <select name="priority" required>
          <option value="">Pilih prioritas</option>
          <option value="low">Rendah</option>
          <option selected value="medium">Sedang</option>
          <option value="high">Tinggi</option>
        </select>
        <label>Lampiran (opsional)</label>
        <input type="file" name="attachment" id="filepondInput" accept=".jpg,.jpeg,.png,.pdf" placeholder="Pilih file jika ada">
        <div id="cf-turnstile"></div>
        <div class="support actions">
          <button type="button" class="support btn ghost">Batal</button>
          <button type="submit" id="submitBtn" class="support btn primary">Kirim</button>
        </div>
      </form>
    </div>`;
  document.body.appendChild(panel);

  // Load Cloudflare Turnstile script
  const turnstileScript = document.createElement('script');
  turnstileScript.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onTurnstileLoad';
  turnstileScript.async = true;
  document.head.appendChild(turnstileScript);

  window.onTurnstileLoad = function () {
    turnstile.render('#cf-turnstile', {
      sitekey: '0x4AAAAAABpOlQqYdzZGOcrd',
      callback: function (token) {
        document.getElementById('ticketForm').dataset.turnstileToken = token;
      }
    });
  };

  let pond;

  // Initialize FilePond after the script is loaded
  filePondScript.onload = function () {
    pond = FilePond.create(document.getElementById('filepondInput'), {
      onprocessfilestart: () => {
        const submitBtn = document.querySelector('#submitBtn');
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.dataset.originalText = submitBtn.innerHTML;
          submitBtn.innerHTML = 'Mengunggah...';
        }
      },
      onprocessfileprogress: () => {
        const submitBtn = document.querySelector('#submitBtn');
        if (submitBtn && submitBtn.innerHTML !== 'Mengunggah...') {
          submitBtn.innerHTML = 'Mengunggah...';
        }
      },
      onprocessfile: () => {
        const submitBtn = document.querySelector('#submitBtn');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.dataset.originalText || 'Kirim';
        }
      },
      onprocessfileabort: () => {
        const submitBtn = document.querySelector('#submitBtn');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.dataset.originalText || 'Kirim';
        }
      }
    });

    FilePond.setOptions({
      server: {
        url: 'https://support.unsub.ac.id/filepond/api',
        process: {
          url: "/process",
          headers: (file) => {
            // Send the original file name which will be used for chunked uploads
            return {
              "Upload-Name": file.name,
              // "X-CSRF-TOKEN": "{{ csrf_token() }}",
            }
          },
        },
        revert: '/process',
        patch: "?patch=",
        headers: {
          // 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      },
      acceptedFileTypes: ['image/*'],
    });
  };

  // Toggle panel visibility
  btn.addEventListener("click", () => panel.classList.toggle("open"));
  panel.querySelector(".close-btn").addEventListener("click", () => panel.classList.remove("open"));
  panel.querySelector(".btn.ghost").addEventListener("click", () => panel.classList.remove("open"));

  // Load categories
  fetch("https://support.unsub.ac.id/api/categories")
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("categorySelect");
      select.innerHTML = '<option value="">Pilih kategori</option>';
      data.data.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.id;
        option.textContent = `${cat.name}`;
        option.setAttribute("data-slug", cat.slug);
        if (cat.slug === preselectedCategory) {
          option.selected = true;
        }
        select.appendChild(option);
      });
    })
    .catch(() => {
      const select = document.getElementById("categorySelect");
      select.innerHTML = '<option value="">Gagal memuat kategori</option>';
    });

  // Fetch placeholder for title and description based on category selection on page load
  const categorySelect = document.getElementById('categorySelect');
  if (categorySelect) {
    const selectedCategoryId = categorySelect.value;
    if (selectedCategoryId) {
      // fetch category placeholder
      fetch(`https://support.unsub.ac.id/api/categories/${selectedCategoryId}`)
        .then(response => response.json())
        .then(data => {
          // Update the title field with the category placeholder
          const titleField = document.getElementById('title');
          titleField.placeholder = data.data.title_placeholder || '';
          // Update the description field with the category placeholder
          const descriptionField = document.getElementById('description');
          descriptionField.placeholder = data.data.desc_placeholder || '';
        })
        .catch(error => {
          console.error('Error fetching category placeholder:', error);
          // Reset the title and description fields if there's an error
          const titleField = document.getElementById('title');
          titleField.placeholder = '';
          const descriptionField = document.getElementById('description');
          descriptionField.placeholder = '';
        });
    } else {
      // Reset the title field if no category is selected
      const titleField = document.getElementById('title');
      titleField.placeholder = '';
      // Reset the description field if no category is selected
      const descriptionField = document.getElementById('description');
      descriptionField.placeholder = '';
    }
  }

  // Listener for category selection change
  categorySelect.addEventListener('change', function () {
    const selectedCategoryId = this.value;
    if (selectedCategoryId) {
      // fetch category placeholder
      fetch(`https://support.unsub.ac.id/api/categories/${selectedCategoryId}`)
        .then(response => response.json())
        .then(data => {
          // Update the title field with the category placeholder
          const titleField = document.getElementById('title');
          titleField.placeholder = data.data.title_placeholder || '';
          // Update the description field with the category placeholder
          const descriptionField = document.getElementById('description');
          descriptionField.placeholder = data.data.desc_placeholder || '';
        })
        .catch(error => {
          console.error('Error fetching category placeholder:', error);
          // Reset the title and description fields if there's an error
          const titleField = document.getElementById('title');
          titleField.placeholder = '';
          const descriptionField = document.getElementById('description');
          descriptionField.placeholder = '';
        });
    } else {
      // Reset the title field if no category is selected
      const titleField = document.getElementById('title');
      titleField.placeholder = '';
      // Reset the description field if no category is selected
      const descriptionField = document.getElementById('description');
      descriptionField.placeholder = '';
    }
  });

  // Handle form submission
  document.addEventListener("submit", (e) => {
    if (e.target.id === "ticketForm") {
      e.preventDefault();
      const alertBox = document.getElementById("alertBox");
      const submitBtn = document.getElementById("submitBtn");
      const originalBtnText = submitBtn.textContent;
      const formData = new FormData(e.target);

      // Tampilkan loading
      submitBtn.disabled = true;
      submitBtn.textContent = "Mengirim...";
      alertBox.style.display = "none";

      fetch("https://support.unsub.ac.id/api/tickets", {
        method: "POST",
        body: formData,
        headers: {
          'Accept': 'application/json'
        }
      })
        .then(async response => {
          const result = await response.json();
          if (response.ok) {
            alertBox.textContent = result.message + ` Cek email anda untuk pemberitahuan selanjutnya.` || "Tiket berhasil dikirim!";
            alertBox.className = "support alert success";
            alertBox.style.display = "block";
            e.target.reset();
            // Remove filepond file
            if (pond) {
              pond.removeFiles();
            }
            // Reset turnstile token
            if (window.turnstile) {
              window.turnstile.reset();
            }
          } else {
            throw new Error(result.message || "Terjadi kesalahan");
          }
        })
        .catch(err => {
          console.error("Error:", err);
          alertBox.textContent = "Error: " + err.message || "Terjadi kesalahan, silakan coba lagi.";
          alertBox.className = "support alert error";
          alertBox.style.display = "block";
        })
        .finally(() => {
          // Kembalikan tombol seperti semula
          submitBtn.disabled = false;
          submitBtn.textContent = originalBtnText;
        });
    }
  });
})();
