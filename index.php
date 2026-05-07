<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kurban Self-Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Booking Kurban</h4>
                    </div>
                    <div class="card-body">
                        <form id="bookingForm">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp (628...)</label>
                                <input type="number" name="whatsapp" class="form-control" placeholder="62812345678" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Layanan</label>
                                <select name="layanan" class="form-control" required>
                                    <option value="Beli + Potong">Beli Hewan + Potong</option>
                                    <option value="Hanya Potong">Hanya Potong (Bawa Sendiri)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Pesanan</button>
                        </form>
                        <div id="responseMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            data.action = "booking_self_service"; // Sesuai dengan logika di GAS

            const submitBtn = this.querySelector('button');
            submitBtn.disabled = true;
            submitBtn.innerText = "Mengirim...";

            // Kirim data ke proses.php (Jembatan ke GAS)
            fetch('proses.php', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                const msg = document.getElementById('responseMessage');
                if(res.status === "SUCCESS") {
                    msg.innerHTML = `<div class="alert alert-success">Booking Berhasil! Silakan tunggu konfirmasi panitia melalui WhatsApp.</div>`;
                    this.reset();
                } else {
                    msg.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan: ${res.message}</div>`;
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Gagal terhubung ke server.</div>`;
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = "Kirim Pesanan";
            });
        });
    </script>
</body>
</html>