<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">

        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-8">Dashboard Overview</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-600
                        transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg hover:bg-amber-50 cursor-pointer">
                <a href="<?= base_url('customer') ?>" class="block h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-800 text-sm font-medium">Total Customers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalCustomers ?></p>
                        </div>
                        <i class="fa-solid fa-users text-amber-500 text-4xl opacity-50"></i>
                    </div>
                    <p class="text-right text-amber-600 hover:text-amber-700 text-xs mt-3 font-semibold">View All &rarr;</p>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-600
                        transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg hover:bg-amber-50 cursor-pointer">
                <a href="<?= base_url('petugas') ?>" class="block h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-800 text-sm font-medium">Total Petugas</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalPetugas ?></p>
                        </div>
                        <i class="fa-solid fa-screwdriver-wrench text-amber-500 text-4xl opacity-50"></i>
                    </div>
                    <p class="text-right text-amber-600 hover:text-amber-700 text-xs mt-3 font-semibold">View All &rarr;</p>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-600
                        transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg hover:bg-amber-50 cursor-pointer">
                <a href="<?= base_url('tickets') ?>" class="block h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-800 text-sm font-medium">Total Tickets</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalTickets ?></p>
                        </div>
                        <i class="fa-solid fa-ticket text-amber-500 text-4xl opacity-50"></i>
                    </div>
                    <p class="text-right text-amber-600 hover:text-amber-700 text-xs mt-3 font-semibold">View All &rarr;</p>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Tickets by Status</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">Open</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"><?= $ticketsOpen ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">In Progress</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800"><?= $ticketsProgress ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">Closed</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><?= $ticketsClosed ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Tickets by Priority</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">Low</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800"><?= $priorityLow ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">Medium</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"><?= $priorityMedium ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">High</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800"><?= $priorityHigh ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800">Urgent</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"><?= $priorityUrgent ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Tickets</h3>
            <?php if (empty($recentTickets)): ?>
                <p class="text-gray-700 text-center">No recent tickets.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($recentTickets as $ticket): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-700"><?= esc($ticket['code_ticket']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= esc($ticket['nama_customer_ticket']) ?> <br>
                                        <span class="text-gray-600 text-xs">HP: <?= esc($ticket['no_hp_customer_ticket']) ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($ticket['keluhan']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php
                                            if ($ticket['status'] == 'open') echo 'bg-blue-100 text-blue-800';
                                            else if ($ticket['status'] == 'progress') echo 'bg-yellow-100 text-yellow-800';
                                            else if ($ticket['status'] == 'closed') echo 'bg-green-100 text-green-800';
                                            ?> capitalize">
                                            <?= esc($ticket['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php
                                            if ($ticket['prioritas'] == 'low') echo 'bg-gray-100 text-gray-800';
                                            else if ($ticket['prioritas'] == 'medium') echo 'bg-blue-100 text-blue-800';
                                            else if ($ticket['prioritas'] == 'high') echo 'bg-orange-100 text-orange-800';
                                            else if ($ticket['prioritas'] == 'urgent') echo 'bg-red-100 text-red-800';
                                            ?> capitalize">
                                            <?= esc($ticket['prioritas']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= esc($ticket['nama_petugas_ticket']) ?> (<?= esc($ticket['role_petugas_ticket']) ?>)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>