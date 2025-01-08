<x-filament-panels::page>
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-t-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-extrabold">Invoice</h1>
                        <p class="text-lg font-medium mt-2">Invoice #12345</p>
                        <p class="text-sm">Date: {{ now()->format('d-m-Y') }}</p>
                    </div>
                    <div class="text-right">
                        <img src="/path-to-your-logo.png" alt="Company Logo" class="h-20 bg-white p-2 rounded shadow-md">
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t-4 border-blue-500 -mt-2"></div>

            <!-- Billing Information -->
            <div class="mt-8 grid grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h2 class="font-bold text-blue-800 text-lg">Billed To</h2>
                    <p class="text-gray-700">John Doe</p>
                    <p class="text-gray-700">123 Main Street</p>
                    <p class="text-gray-700">City, State, ZIP</p>
                    <p class="text-gray-700">Email: john.doe@example.com</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-right">
                    <h2 class="font-bold text-purple-800 text-lg">Company</h2>
                    <p class="text-gray-700">Your Company Name</p>
                    <p class="text-gray-700">456 Corporate Blvd</p>
                    <p class="text-gray-700">City, State, ZIP</p>
                    <p class="text-gray-700">Email: info@company.com</p>
                </div>
            </div>

            <!-- Invoice Items -->
            <table class="w-full mt-8 border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-4 text-left text-gray-800">Description</th>
                        <th class="border border-gray-300 p-4 text-right text-gray-800">Quantity</th>
                        <th class="border border-gray-300 p-4 text-right text-gray-800">Unit Price</th>
                        <th class="border border-gray-300 p-4 text-right text-gray-800">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white">
                        <td class="border border-gray-300 p-4 text-gray-700">Product/Service Name</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-700">2</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-700">$50.00</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-700">$100.00</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100">
                        <td colspan="3" class="border border-gray-300 p-4 text-right font-bold text-gray-800">Subtotal</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-800">$100.00</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td colspan="3" class="border border-gray-300 p-4 text-right font-bold text-gray-800">Tax (10%)</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-800">$10.00</td>
                    </tr>
                    <tr class="bg-gray-200">
                        <td colspan="3" class="border border-gray-300 p-4 text-right font-bold text-gray-900">Total</td>
                        <td class="border border-gray-300 p-4 text-right text-gray-900">$110.00</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500">
                <p>Thank you for your business!</p>
                <p>If you have any questions about this invoice, please contact us at info@company.com.</p>
            </div>
        </div>
    </div>
</x-filament-panels::page>
