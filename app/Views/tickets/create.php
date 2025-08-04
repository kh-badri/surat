<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= $title ?>
        </h2>

        <form action="<?= base_url('tickets/store') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code_ticket" class="block text-gray-800 text-sm font-bold mb-2">Kode Tiket:</label>
                    <input type="text" name="code_ticket" id="code_ticket"
                        value="<?= old('code_ticket', $code_ticket_generated) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('code_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Kode tiket otomatis">
                    <?php if ($validation->hasError('code_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('code_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="tanggal_buat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Buat:</label>
                    <input type="datetime-local" name="tanggal_buat" id="tanggal_buat"
                        value="<?= old('tanggal_buat', date('Y-m-d\TH:i')) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('tanggal_buat') ? 'border-red-500' : '' ?>"
                        required>
                    <?php if ($validation->hasError('tanggal_buat')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('tanggal_buat') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Customer</h3>

            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Customer:</label>
                <select name="customer_id" id="customer_id"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('customer_id') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Customer --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"
                            <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>>
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
                        value="<?= old('nama_customer_ticket') ?>"
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
                        value="<?= old('no_hp_customer_ticket') ?>"
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
                    placeholder="Alamat customer"><?= old('alamat_customer_ticket') ?></textarea>
                <?php if ($validation->hasError('alamat_customer_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_customer_ticket') ?></p>
                <?php endif; ?>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Tiket</h3>

            <div class="mb-4">
                <label for="keluhan" class="block text-gray-700 text-sm font-bold mb-2">Keluhan Singkat:</label>
                <input type="text" name="keluhan" id="keluhan"
                    value="<?= old('keluhan') ?>"
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
                    placeholder="Jelaskan masalah secara lebih detail"><?= old('deskripsi') ?></textarea>
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
                        <option value="open" <?= old('status', 'open') == 'open' ? 'selected' : '' ?>>Open</option>
                        <option value="progress" <?= old('status') == 'progress' ? 'selected' : '' ?>>Progress</option>
                        <option value="closed" <?= old('status') == 'closed' ? 'selected' : '' ?>>Closed</option>
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
                        <option value="low" <?= old('prioritas', 'low') == 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= old('prioritas') == 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= old('prioritas') == 'high' ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= old('prioritas') == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                    </select>
                    <?php if ($validation->hasError('prioritas')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('prioritas') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Informasi Petugas</h3>
                <button type="button" id="add-petugas-btn" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Petugas
                </button>
            </div>

            <!-- Petugas 1 Block (Default) -->
            <div class="petugas-block border border-gray-200 rounded-lg p-4 mb-4">
                <h4 class="text-lg font-medium text-gray-700 mb-3">Petugas 1</h4>
                <div class="mb-4">
                    <label for="petugas_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Petugas:</label>
                    <select name="petugas_id" id="petugas_id"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('petugas_id') ? 'border-red-500' : '' ?>" required>
                        <option value="">-- Pilih Petugas --</option>
                        <?php foreach ($petugas as $p): ?>
                            <option value="<?= $p['id_petugas'] ?>"
                                <?= old('petugas_id') == $p['id_petugas'] ? 'selected' : '' ?>>
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
                            value="<?= old('nama_petugas_ticket') ?>"
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
                            value="<?= old('no_hp_petugas_ticket') ?>"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                    <?= $validation->hasError('no_hp_petugas_ticket') ? 'border-red-500' : '' ?>"
                            required placeholder="Nomor HP petugas">
                        <?php if ($validation->hasError('no_hp_petugas_ticket')): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_petugas_ticket') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="role_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Role Petugas:</label>
                    <input type="text" name="role_petugas_ticket" id="role_petugas_ticket"
                        value="<?= old('role_petugas_ticket') ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('role_petugas_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Role petugas">
                    <?php if ($validation->hasError('role_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Petugas 2 Block (Hidden by default) -->
            <div id="petugas-2-block" class="petugas-block border border-gray-200 rounded-lg p-4 mb-4 hidden">
                <h4 class="text-lg font-medium text-gray-700 mb-3">Petugas 2</h4>
                <div class="mb-4">
                    <label for="petugas_id_2" class="block text-gray-700 text-sm font-bold mb-2">Pilih Petugas:</label>
                    <select name="petugas_id_2" id="petugas_id_2"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('petugas_id_2') ? 'border-red-500' : '' ?>">
                        <option value="">-- Pilih Petugas --</option>
                        <?php foreach ($petugas as $p): ?>
                            <option value="<?= $p['id_petugas'] ?>"
                                <?= old('petugas_id_2') == $p['id_petugas'] ? 'selected' : '' ?>>
                                <?= esc($p['nama_petugas']) ?> (<?= esc($p['role']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($validation->hasError('petugas_id_2')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('petugas_id_2') ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_petugas_ticket_2" class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas:</label>
                        <input type="text" name="nama_petugas_ticket_2" id="nama_petugas_ticket_2"
                            value="<?= old('nama_petugas_ticket_2') ?>"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                    <?= $validation->hasError('nama_petugas_ticket_2') ? 'border-red-500' : '' ?>"
                            placeholder="Nama petugas">
                        <?php if ($validation->hasError('nama_petugas_ticket_2')): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_petugas_ticket_2') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="no_hp_petugas_ticket_2" class="block text-gray-700 text-sm font-bold mb-2">No. HP Petugas:</label>
                        <input type="text" name="no_hp_petugas_ticket_2" id="no_hp_petugas_ticket_2"
                            value="<?= old('no_hp_petugas_ticket_2') ?>"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                    <?= $validation->hasError('no_hp_petugas_ticket_2') ? 'border-red-500' : '' ?>"
                            placeholder="Nomor HP petugas">
                        <?php if ($validation->hasError('no_hp_petugas_ticket_2')): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_petugas_ticket_2') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="role_petugas_ticket_2" class="block text-gray-700 text-sm font-bold mb-2">Role Petugas:</label>
                    <input type="text" name="role_petugas_ticket_2" id="role_petugas_ticket_2"
                        value="<?= old('role_petugas_ticket_2') ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('role_petugas_ticket_2') ? 'border-red-500' : '' ?>"
                        placeholder="Role petugas">
                    <?php if ($validation->hasError('role_petugas_ticket_2')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role_petugas_ticket_2') ?></p>
                    <?php endif; ?>
                </div>
                <button type="button" id="remove-petugas-2-btn" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm6 4a1 1 0 10-2 0v3a1 1 0 102 0v-3z" clip-rule="evenodd" />
                    </svg>
                    Hapus Petugas 2
                </button>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Buat Tiket
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

        const petugasIdSelect1 = document.getElementById('petugas_id'); // Petugas 1
        const namaPetugasInput1 = document.getElementById('nama_petugas_ticket');
        const noHpPetugasInput1 = document.getElementById('no_hp_petugas_ticket');
        const rolePetugasInput1 = document.getElementById('role_petugas_ticket');

        const petugas2Block = document.getElementById('petugas-2-block');
        const addPetugasBtn = document.getElementById('add-petugas-btn');
        const removePetugas2Btn = document.getElementById('remove-petugas-2-btn');

        const petugasIdSelect2 = document.getElementById('petugas_id_2'); // Petugas 2
        const namaPetugasInput2 = document.getElementById('nama_petugas_ticket_2');
        const noHpPetugasInput2 = document.getElementById('no_hp_petugas_ticket_2');
        const rolePetugasInput2 = document.getElementById('role_petugas_ticket_2');

        // Function to populate customer details
        function populateCustomerDetails() {
            const customerId = customerIdSelect.value;
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
                        displayMessage('Gagal mengambil detail customer. Mohon masukkan manual.', 'error');
                    });
            } else {
                namaCustomerInput.value = '';
                alamatCustomerInput.value = '';
                noHpCustomerInput.value = '';
            }
        }

        // Function to populate petugas details for a specific set of fields
        function populatePetugasDetails(petugasId, namaInput, noHpInput, roleInput) {
            if (petugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${petugasId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Petugas not found');
                        }
                        return response.json();
                    })
                    .then(data => {
                        namaInput.value = data.nama_petugas || '';
                        noHpInput.value = data.no_hp || '';
                        roleInput.value = data.role || '';
                    })
                    .catch(error => {
                        console.error('Error fetching petugas details:', error);
                        namaInput.value = '';
                        noHpInput.value = '';
                        roleInput.value = '';
                        displayMessage('Gagal mengambil detail petugas. Mohon masukkan manual.', 'error');
                    });
            } else {
                namaInput.value = '';
                noHpInput.value = '';
                roleInput.value = '';
            }
        }

        // Function to display temporary messages (instead of alert)
        function displayMessage(message, type = 'info') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `px-4 py-3 rounded relative mt-4 ${type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' : 'bg-blue-100 border border-blue-400 text-blue-700'}`;
            messageDiv.innerHTML = `<strong class="font-bold">${type === 'error' ? 'Error!' : 'Info!'}</strong><span class="block sm:inline"> ${message}</span>`;
            document.querySelector('form').prepend(messageDiv);
            setTimeout(() => messageDiv.remove(), 5000);
        }

        // Event Listeners for Customer
        customerIdSelect.addEventListener('change', populateCustomerDetails);

        // Event Listeners for Petugas 1
        petugasIdSelect1.addEventListener('change', function() {
            populatePetugasDetails(this.value, namaPetugasInput1, noHpPetugasInput1, rolePetugasInput1);
        });

        // Event Listener for "Tambah Petugas" button
        addPetugasBtn.addEventListener('click', function() {
            petugas2Block.classList.remove('hidden');
            addPetugasBtn.classList.add('hidden'); // Hide "Tambah Petugas" button after showing the second block
            // Optionally make fields in petugas 2 block required when shown
            petugasIdSelect2.setAttribute('required', 'required');
            namaPetugasInput2.setAttribute('required', 'required');
            noHpPetugasInput2.setAttribute('required', 'required');
            rolePetugasInput2.setAttribute('required', 'required');
        });

        // Event Listener for "Hapus Petugas 2" button
        removePetugas2Btn.addEventListener('click', function() {
            petugas2Block.classList.add('hidden');
            addPetugasBtn.classList.remove('hidden'); // Show "Tambah Petugas" button again
            // Clear fields and remove 'required' attribute when hidden
            petugasIdSelect2.value = '';
            namaPetugasInput2.value = '';
            noHpPetugasInput2.value = '';
            rolePetugasInput2.value = '';
            petugasIdSelect2.removeAttribute('required');
            namaPetugasInput2.removeAttribute('required');
            noHpPetugasInput2.removeAttribute('required');
            rolePetugasInput2.removeAttribute('required');
        });

        // Event Listener for Petugas 2 (only if it's visible or was previously filled)
        petugasIdSelect2.addEventListener('change', function() {
            populatePetugasDetails(this.value, namaPetugasInput2, noHpPetugasInput2, rolePetugasInput2);
        });


        // Initial population if old data exists (e.g., after validation failure)
        <?php if (old('customer_id')): ?>
            populateCustomerDetails();
        <?php endif; ?>

        <?php if (old('petugas_id')): ?>
            populatePetugasDetails(petugasIdSelect1.value, namaPetugasInput1, noHpPetugasInput1, rolePetugasInput1);
        <?php endif; ?>

        // If old data for petugas 2 exists, show the block and populate it
        <?php if (old('petugas_id_2')): ?>
            petugas2Block.classList.remove('hidden');
            addPetugasBtn.classList.add('hidden');
            petugasIdSelect2.setAttribute('required', 'required');
            namaPetugasInput2.setAttribute('required', 'required');
            noHpPetugasInput2.setAttribute('required', 'required');
            rolePetugasInput2.setAttribute('required', 'required');
            populatePetugasDetails(petugasIdSelect2.value, namaPetugasInput2, noHpPetugasInput2, rolePetugasInput2);
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>