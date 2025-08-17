<hr class="border-gray-200 my-6">
<h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Customer</h3>

<div class="flex space-x-2 mb-4">
    <button type="button" id="btnPilihCustomer" class="px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
        Pilih Customer
    </button>
    <button type="button" id="btnCustomCustomer" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
        Custom Input
    </button>
</div>

<div id="pilihCustomerContainer">
    <div class="mb-4">
        <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Customer:</label>
        <select name="customer_id" id="customer_id"
            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
            <?= $validation->hasError('customer_id') ? 'border-red-500' : '' ?>">
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
</div>


<div id="detailCustomerContainer">
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
    <div class="mt-4">
        <label for="alamat_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Alamat Customer:</label>
        <textarea name="alamat_customer_ticket" id="alamat_customer_ticket" rows="3"
            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
            <?= $validation->hasError('alamat_customer_ticket') ? 'border-red-500' : '' ?>"
            placeholder="Alamat customer"><?= old('alamat_customer_ticket') ?></textarea>
        <?php if ($validation->hasError('alamat_customer_ticket')): ?>
            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_customer_ticket') ?></p>
        <?php endif; ?>
    </div>
</div>


<hr class="border-gray-200 my-6">
<h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Tiket</h3>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === Bagian Opsi Customer ===
        const btnPilihCustomer = document.getElementById('btnPilihCustomer');
        const btnCustomCustomer = document.getElementById('btnCustomCustomer');
        const pilihCustomerContainer = document.getElementById('pilihCustomerContainer');
        const detailCustomerContainer = document.getElementById('detailCustomerContainer');

        const customerIdSelect = document.getElementById('customer_id');
        const namaCustomerInput = document.getElementById('nama_customer_ticket');
        const alamatCustomerInput = document.getElementById('alamat_customer_ticket');
        const noHpCustomerInput = document.getElementById('no_hp_customer_ticket');

        // Fungsi untuk mengosongkan input customer
        const clearCustomerFields = () => {
            customerIdSelect.value = '';
            namaCustomerInput.value = '';
            alamatCustomerInput.value = '';
            noHpCustomerInput.value = '';
        };

        // Fungsi untuk mengatur tampilan mode "Pilih Customer"
        const setPilihMode = () => {
            pilihCustomerContainer.style.display = 'block';
            namaCustomerInput.readOnly = true;
            alamatCustomerInput.readOnly = true;
            noHpCustomerInput.readOnly = true;
            customerIdSelect.setAttribute('required', 'required'); // Wajib memilih customer

            // Styling tombol
            btnPilihCustomer.classList.remove('bg-gray-200', 'text-gray-700');
            btnPilihCustomer.classList.add('bg-amber-600', 'text-white');
            btnCustomCustomer.classList.remove('bg-amber-600', 'text-white');
            btnCustomCustomer.classList.add('bg-gray-200', 'text-gray-700');

            // Panggil event change jika ada customer yang sudah terpilih
            if (customerIdSelect.value) {
                customerIdSelect.dispatchEvent(new Event('change'));
            }
        };

        // Fungsi untuk mengatur tampilan mode "Custom Input"
        const setCustomMode = () => {
            clearCustomerFields();
            pilihCustomerContainer.style.display = 'none';
            namaCustomerInput.readOnly = false;
            alamatCustomerInput.readOnly = false;
            noHpCustomerInput.readOnly = false;
            customerIdSelect.removeAttribute('required'); // Tidak wajib memilih customer

            // Styling tombol
            btnCustomCustomer.classList.remove('bg-gray-200', 'text-gray-700');
            btnCustomCustomer.classList.add('bg-amber-600', 'text-white');
            btnPilihCustomer.classList.remove('bg-amber-600', 'text-white');
            btnPilihCustomer.classList.add('bg-gray-200', 'text-gray-700');
        };

        // Event listener untuk tombol
        btnPilihCustomer.addEventListener('click', setPilihMode);
        btnCustomCustomer.addEventListener('click', setCustomMode);

        // Inisialisasi tampilan awal (default ke mode "Pilih")
        setPilihMode();

        // === Bagian Detail Customer dari Select ===
        customerIdSelect.addEventListener('change', function() {
            const customerId = this.value;
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
                        // Tampilkan notifikasi error
                    });
            } else {
                // Kosongkan field jika "-- Pilih Customer --" dipilih
                namaCustomerInput.value = '';
                alamatCustomerInput.value = '';
                noHpCustomerInput.value = '';
            }
        });

        // === Bagian Detail Petugas (Kode ini tetap sama) ===
        const petugasIdSelect = document.getElementById('petugas_id');
        const namaPetugasInput = document.getElementById('nama_petugas_ticket');
        const noHpPetugasInput = document.getElementById('no_hp_petugas_ticket');
        const rolePetugasInput = document.getElementById('role_petugas_ticket');

        petugasIdSelect.addEventListener('change', function() {
            const petugasId = this.value;
            if (petugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${petugasId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Petugas not found');
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
                    });
            } else {
                namaPetugasInput.value = '';
                noHpPetugasInput.value = '';
                rolePetugasInput.value = '';
            }
        });

        // === Memuat ulang data jika ada old input (setelah validasi gagal) ===
        <?php if (old('customer_id')): ?>
            customerIdSelect.dispatchEvent(new Event('change'));
        <?php endif; ?>
        <?php if (old('petugas_id')): ?>
            petugasIdSelect.dispatchEvent(new Event('change'));
        <?php endif; ?>
    });
</script>