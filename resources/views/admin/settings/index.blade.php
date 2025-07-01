@extends('layouts.app')

@section('title', 'Pengaturan - Kevin Laundry')
@section('page-title', 'Pengaturan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Pengaturan Aplikasi</h2>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- General Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Umum</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                                <input type="text" name="app_name" value="Kevin Laundry" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                                <input type="email" name="contact_email" value="admin@kevinlaundry.com" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="contact_phone" value="+62 812-3456-7890" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <input type="text" name="address" value="Jl. Contoh No. 123, Jakarta" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Order Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Waktu Default (hari)</label>
                                <input type="number" name="default_estimated_days" value="3" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Berat (kg)</label>
                                <input type="number" name="minimum_weight" value="0.5" step="0.1" min="0.1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Notifikasi</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="email_notifications" id="email_notifications" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                <label for="email_notifications" class="ml-2 block text-sm text-gray-900">
                                    Kirim notifikasi email ke customer
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="sms_notifications" id="sms_notifications" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="sms_notifications" class="ml-2 block text-sm text-gray-900">
                                    Kirim notifikasi SMS ke customer
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="admin_notifications" id="admin_notifications" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                <label for="admin_notifications" class="ml-2 block text-sm text-gray-900">
                                    Notifikasi pesanan baru untuk admin
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Sistem</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                                    Mode Maintenance
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="auto_backup" id="auto_backup" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                <label for="auto_backup" class="ml-2 block text-sm text-gray-900">
                                    Backup otomatis setiap hari
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8 space-x-4">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-save mr-1"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 