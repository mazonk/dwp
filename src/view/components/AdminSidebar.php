<?php require_once 'session_config.php'; ?>
<div class="w-1/6 bg-gray-800 p-6 min-h-screen">
    <ul class="space-y-4">
        <li><a href="<?= $_SESSION['baseRoute']; ?>home" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white mb-8"><- Back to Home</a></li>
        <li><a href="?section=company-venues" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white">Company & Venues</a></li>
        <li><a href="?section=content-management" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white">Content Management</a></li>
        <li><a href="?section=movie-management" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white">Movie Management</a></li>
        <li><a href="?section=scheduling" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white">Scheduling</a></li>
        <li><a href="?section=bookings-invoices" class="block py-2 px-3 rounded text-gray-300 hover:bg-gray-700 hover:text-white">Bookings & Invoices</a></li>
    </ul>
</div>