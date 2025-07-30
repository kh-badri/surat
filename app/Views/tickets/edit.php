<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= $title ?>
        </h2>

        <form action="<?= base_url('tickets/update/' . $ticket['id']) ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code_ticket" class="block text-gray-700 text-sm font-bold mb-2">Kode Tiket:</label>
                    <input type="text" name="code_ticket" id="code_ticket" readonly
                        value="<?= old('code_ticket', $ticket['code_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="tanggal_buat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Buat:</label>
                    <input type="datetime-local" name="tanggal_buat" id="tanggal_buat" readonly
                        value="<?= old('tanggal_buat', date('Y-m-d\TH:i', strtotime($ticket['tanggal_buat']))) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-gray-100 cursor-not-allowed">
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Customer</h3>

            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Customer:</label>
                <select name="customer_id" id="customer_id"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               <?= $validation->hasError('customer_id') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Customer --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"
                            <?= (old('customer_id', $ticket['customer_id']) == $customer['id']) ? 'selected' : '' ?>>
                            <?= esc($customer['id_customer']) ?> - <?= esc($customer['nama_customer']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('customer_id')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('customer_id') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Nama Customer:</label>
                    <input type="text" name="nama_customer_ticket" id="nama_customer_ticket"
                        value="<?= old('nama_customer_ticket', $ticket['nama_customer_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                  <?= $validation->hasError('nama_customer_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nama customer">
                    <?php if ($validation->hasError('nama_customer_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_customer_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="no_hp_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Customer:</label>
                    <input type="text" name="no_hp_customer_ticket" id="no_hp_customer_ticket"
                        value="<?= old('no_hp_customer_ticket', $ticket['no_hp_customer_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                  <?= $validation->hasError('no_hp_customer_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nomor HP customer">
                    <?php if ($validation->hasError('no_hp_customer_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_customer_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-4">
                <label for="alamat_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Alamat Customer:</label>
                <textarea name="alamat_customer_ticket" id="alamat_customer_ticket" rows="3"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('alamat_customer_ticket') ? 'border-red-500' : '' ?>"
                    placeholder="Alamat customer"><?= old('alamat_customer_ticket', $ticket['alamat_customer_ticket']) ?></textarea>
                <?php if ($validation->hasError('alamat_customer_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_customer_ticket') ?></p>
                <?php endif; ?>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Tiket</h3>

            <div class="mb-4">
                <label for="keluhan" class="block text-gray-700 text-sm font-bold mb-2">Keluhan Singkat:</label>
                <input type="text" name="keluhan" id="keluhan"
                    value="<?= old('keluhan', $ticket['keluhan']) ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                              <?= $validation->hasError('keluhan') ? 'border-red-500' : '' ?>"
                    required placeholder="Contoh: Internet mati, koneksi lambat, tidak bisa login">
                <?php if ($validation->hasError('keluhan')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('keluhan') ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Detail (Opsional):</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('deskripsi') ? 'border-red-500' : '' ?>"
                    placeholder="Jelaskan masalah secara lebih detail"><?= old('deskripsi', $ticket['deskripsi']) ?></textarea>
                <?php if ($validation->hasError('deskripsi')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('deskripsi') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                   <?= $validation->hasError('status') ? 'border-red-500' : '' ?>" required>
                        <option value="open" <?= (old('status', $ticket['status']) == 'open') ? 'selected' : '' ?>>Open</option>
                        <option value="progress" <?= (old('status', $ticket['status']) == 'progress') ? 'selected' : '' ?>>Progress</option>
                        <option value="closed" <?= (old('status', $ticket['status']) == 'closed') ? 'selected' : '' ?>>Closed</option>
                    </select>
                    <?php if ($validation->hasError('status')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('status') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="prioritas" class="block text-gray-700 text-sm font-bold mb-2">Prioritas:</label>
                    <select name="prioritas" id="prioritas"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                   <?= $validation->hasError('prioritas') ? 'border-red-500' : '' ?>" required>
                        <option value="low" <?= (old('prioritas', $ticket['prioritas']) == 'low') ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= (old('prioritas', $ticket['prioritas']) == 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= (old('prioritas', $ticket['prioritas']) == 'high') ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= (old('prioritas', $ticket['prioritas']) == 'urgent') ? 'selected' : '' ?>>Urgent</option>
                    </select>
                    <?php if ($validation->hasError('prioritas')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('prioritas') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Petugas</h3>

            <div class="mb-4">
                <label for="petugas_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Petugas:</label>
                <select name="petugas_id" id="petugas_id"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               <?= $validation->hasError('petugas_id') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Petugas --</option>
                    <?php foreach ($petugas as $p): ?>
                        <option value="<?= $p['id_petugas'] ?>"
                            <?= (old('petugas_id', $ticket['petugas_id']) == $p['id_petugas']) ? 'selected' : '' ?>>
                            <?= esc($p['nama_petugas']) ?> (<?= esc($p['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('petugas_id')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('petugas_id') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas:</label>
                    <input type="text" name="nama_petugas_ticket" id="nama_petugas_ticket"
                        value="<?= old('nama_petugas_ticket', $ticket['nama_petugas_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                  <?= $validation->hasError('nama_petugas_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nama petugas">
                    <?php if ($validation->hasError('nama_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="no_hp_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Petugas:</label>
                    <input type="text" name="no_hp_petugas_ticket" id="no_hp_petugas_ticket"
                        value="<?= old('no_hp_petugas_ticket', $ticket['no_hp_petugas_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                  <?= $validation->hasError('no_hp_petugas_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nomor HP petugas">
                    <?php if ($validation->hasError('no_hp_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-6">
                <label for="role_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Role Petugas:</label>
                <input type="text" name="role_petugas_ticket" id="role_petugas_ticket"
                    value="<?= old('role_petugas_ticket', $ticket['role_petugas_ticket']) ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                              <?= $validation->hasError('role_petugas_ticket') ? 'border-red-500' : '' ?>"
                    required placeholder="Role petugas">
                <?php if ($validation->hasError('role_petugas_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role_petugas_ticket') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Update Tiket
                </button>
                <a href="<?= base_url('tickets') ?>" class="w-full sm:w-auto text-center inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800 py-3 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerIdSelect = document.getElementById('customer_id');
        const namaCustomerInput = document.getElementById('nama_customer_ticket');
        const alamatCustomerInput = document.getElementById('alamat_customer_ticket');
        const noHpCustomerInput = document.getElementById('no_hp_customer_ticket');

        const petugasIdSelect = document.getElementById('petugas_id');
        const namaPetugasInput = document.getElementById('nama_petugas_ticket');
        const noHpPetugasInput = document.getElementById('no_hp_petugas_ticket');
        const rolePetugasInput = document.getElementById('role_petugas_ticket');

        // Fungsi untuk mengisi detail customer
        function fetchCustomerDetails(customerId) {
            if (customerId) {
                fetch(`<?= base_url('tickets/getcustomerdetails/') ?>${customerId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Customer not found');
                        }
                        return response.json();
                    })
                    .then(data => {
                        namaCustomerInput.value = data.nama_customer || '';
                        alamatCustomerInput.value = data.alamat || '';
                        noHpCustomerInput.value = data.no_hp || '';
                    })
                    .catch(error => {
                        console.error('Error fetching customer details:', error);
                        namaCustomerInput.value = '';
                        alamatCustomerInput.value = '';
                        noHpCustomerInput.value = '';
                        alert('Gagal mengambil detail customer. Mohon masukkan manual.');
                    });
            } else {
                // Clear fields if no customer selected
                namaCustomerInput.value = '';
                alamatCustomerInput.value = '';
                noHpCustomerInput.value = '';
            }
        }

        // Fungsi untuk mengisi detail petugas
        function fetchPetugasDetails(petugasId) {
            if (petugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${petugasId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Petugas not found');
                        }
                        return response.json();
                    })
                    .then(data => {
                        namaPetugasInput.value = data.nama_petugas || '';
                        noHpPetugasInput.value = data.no_hp || '';
                        rolePetugasInput.value = data.role || '';
                    })
                    .catch(error => {
                        console.error('Error fetching petugas details:', error);
                        namaPetugasInput.value = '';
                        noHpPetugasInput.value = '';
                        rolePetugasInput.value = '';
                        alert('Gagal mengambil detail petugas. Mohon masukkan manual.');
                    });
            } else {
                // Clear fields if no petugas selected
                namaPetugasInput.value = '';
                noHpPetugasInput.value = '';
                rolePetugasInput.value = '';
            }
        }

        // Event listener untuk customer dropdown
        customerIdSelect.addEventListener('change', function() {
            fetchCustomerDetails(this.value);
        });

        // Event listener untuk petugas dropdown
        petugasIdSelect.addEventListener('change', function() {
            fetchPetugasDetails(this.value);
        });

        // PENTING UNTUK EDIT FORM: Panggil fungsi lookup saat halaman dimuat
        // Jika ada old input (setelah validasi gagal), gunakan old input
        // Jika tidak, gunakan nilai dari $ticket yang dimuat pertama kali
        const initialCustomerId = oldInput.customer_id || customerIdSelect.value;
        const initialPetugasId = oldInput.petugas_id || petugasIdSelect.value;

        // Panggil fetchDetails hanya jika ada nilai yang terpilih
        if (initialCustomerId) {
            fetchCustomerDetails(initialCustomerId);
        }
        if (initialPetugasId) {
            fetchPetugasDetails(initialPetugasId);
        }
    });

    // Helper untuk mengambil nilai old() dari PHP ke JavaScript
    // Ini diperlukan karena old() hanya berfungsi di sisi PHP
    const oldInput = {
        customer_id: "<?= old('customer_id') ?>",
        nama_customer_ticket: "<?= old('nama_customer_ticket') ?>",
        alamat_customer_ticket: "<?= old('alamat_customer_ticket') ?>",
        no_hp_customer_ticket: "<?= old('no_hp_customer_ticket') ?>",
        petugas_id: "<?= old('petugas_id') ?>",
        nama_petugas_ticket: "<?= old('nama_petugas_ticket') ?>",
        no_hp_petugas_ticket: "<?= old('no_hp_petugas_ticket') ?>",
        role_petugas_ticket: "<?= old('role_petugas_ticket') ?>"
    };
</script>

<?= $this->endSection() ?>