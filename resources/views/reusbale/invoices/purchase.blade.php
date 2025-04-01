<head>
    <title>Purchase From {{$purchase->provider?->name}}</title>
</head>
<div style="background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; max-width: 800px; margin: 0 auto;">
    <!-- Header -->
    <table style="width: 100%; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px;">
        <tr>
            <td>
                <h1 style="font-size: 24px; font-weight: bold; color: #4a5568;">Invoice</h1>
                <p style="color: #a0aec0;">Invoice #{{ $purchase->invoice_no }}</p>
                <p style="color: #a0aec0;">Date: {{ $purchase->purchase_date }}</p>
            </td>
            <td style="text-align: right;">
                <img src="/path-to-your-logo.png" alt="Company Logo" style="height: 64px;">
            </td>
        </tr>
    </table>

    <!-- Billing Information -->
    <table style="width: 100%; margin-top: 24px;">
        <tr>
            <td>
                <h2 style="font-weight: bold; color: #4a5568;">Billed From</h2>
                <p style="color: #718096;">{{ $purchase->provider?->name }}</p>
                <p style="color: #718096;">{{ $purchase->provider?->address }}</p>
                <p style="color: #718096;">Email: {{ $purchase->provider?->email }}</p>
            </td>
            <td style="text-align: right;">
                <h2 style="font-weight: bold; color: #4a5568;">Company</h2>
                <p style="color: #718096;">{{$settings['Tenant Name']}}</p>
                <p style="color: #718096;">{{$settings['Address']}}</p>
                <p style="color: #718096;">{{$settings['Zip']}}</p>
                <p style="color: #718096;">Email: {{$settings['Email']}}</p>
            </td>
        </tr>
    </table>

    <!-- Invoice Items -->
    <table style="width: 100%; margin-top: 24px; border-collapse: collapse; border: 1px solid #e2e8f0;">
        <thead>
            <tr style="background-color: #f7fafc;">
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: left; color: #4a5568;">Description</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Quantity</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Unit Price</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->products as $product)
            <tr>
                <td style="border: 1px solid #e2e8f0; padding: 8px; color: #718096;">{{ $product->product->name }}</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">{{ $product->quantity }}</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">${{ $product->price }}</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">${{ $product->quantity * $product->price }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f7fafc;">
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Subtotal</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $purchase->total }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Discount</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $purchase->discount }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Total</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $purchase->total - $purchase->discount }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div style="margin-top: 24px; text-align: center; color: #a0aec0;">
        <!-- <p>Thank you for your business!</p>
        <p>If you have any questions about this invoice, please contact us at info@company.com.</p> -->
        <livewire:footer-text-component/>
    </div>
</div>