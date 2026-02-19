<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #{{ $order->id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f9fafb;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .status-badge {
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .approved {
            background: #dbeafe;
            color: #1e40af;
        }

        .shipped {
            background: #d1fae5;
            color: #065f46;
        }

        .delivered {
            background: #dcfce7;
            color: #166534;
        }

        .cancel {
            background: #fee2e2;
            color: #991b1b;
        }

        .verified {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .unverified {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        /* Fullscreen image styles */
        .fullscreen-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .fullscreen-overlay.active {
            display: flex;
        }

        .fullscreen-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .close-fullscreen {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
            transition: color 0.3s ease;
        }

        .close-fullscreen:hover {
            color: #ff4444;
        }

        .fullscreen-caption {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            font-size: 16px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            margin: 0 auto;
            width: fit-content;
            border-radius: 8px;
        }

        .receipt-image {
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .receipt-image:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }
    </style>
</head>

<body class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">

    <!-- Fullscreen Image Overlay -->
    <div id="fullscreenOverlay" class="fullscreen-overlay" onclick="closeFullscreen()">
        <span class="close-fullscreen" onclick="closeFullscreen(event)">&times;</span>
        <img id="fullscreenImage" class="fullscreen-image" src="" alt="Payment Receipt Fullscreen">
        <div id="fullscreenCaption" class="fullscreen-caption"></div>
    </div>

    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Order #{{ $order->id }}
                </h1>
                <p class="text-gray-600 mt-1">
                    Placed on {{ $order->created_at->format('M d, Y • h:i A') }}
                </p>
            </div>

            <div class="mt-4 sm:mt-0 flex items-center gap-4">
                <span class="status-badge {{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>

                <span class="status-badge {{ $order->veri_status }}">
                    Payment: {{ ucfirst($order->veri_status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left / Center – Customer & Payment Info -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Customer Information -->
                <div class="card p-6">
                    <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i>
                        Customer Information
                    </h2>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-lg">
                        <div>
                            <dt class="text-gray-600 font-medium">Name</dt>
                            <dd class="mt-1 text-gray-900">{{ $order->user->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600 font-medium">Email</dt>
                            <dd class="mt-1 text-gray-900">{{ $order->user->email ?? '—' }}</dd>
                        </div>
                        @if ($order->user->phone ?? false)
                            <div>
                                <dt class="text-gray-600 font-medium">Phone</dt>
                                <dd class="mt-1 text-gray-900">{{ $order->user->phone }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Order Items -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-indigo-600"></i>
                        Order Items
                    </h2>

                    @if ($order->order_items->isEmpty())
                        <p class="text-gray-500 py-4">No items found in this order.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $calculatedTotal = 0;
                                    @endphp
                                    @foreach ($order->order_items as $item)
                                        @php
                                            // Calculate price after discount
                                            $originalPrice = $item->product->price ?? 0;
                                            $discount = $item->product->discount ?? 0;
                                            $priceAfterDiscount = $originalPrice - ($originalPrice * $discount / 100);
                                            $subtotal = $priceAfterDiscount * $item->qty;
                                            $calculatedTotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->product->title ?? 'Product #' . $item->product_id }}
                                                </div>
                                                @if ($item->product && $item->product->sku ?? false)
                                                    <div class="text-xs text-gray-500">SKU: {{ $item->product->sku }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($discount > 0)
                                                    <span class="line-through text-gray-400">Rs. {{ number_format($originalPrice, 2) }}</span>
                                                    <br>
                                                    <span class="text-green-600">Rs. {{ number_format($priceAfterDiscount, 2) }}</span>
                                                    <span class="text-xs text-green-500">({{ $discount }}% off)</span>
                                                @else
                                                    Rs. {{ number_format($originalPrice, 2) }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->qty }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                Rs. {{ number_format($subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total Amount:</span>
                                <span class="text-green-700">Rs. {{ number_format($order->Total_amt, 2) }}</span>
                            </div>
                            @if(abs($calculatedTotal - floatval($order->Total_amt)) > 0.01)
                                <div class="flex justify-between text-sm text-red-600 mt-2">
                                    <span>Note:</span>
                                    <span>Calculated total (Rs. {{ number_format($calculatedTotal, 2) }}) doesn't match order total</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right sidebar – Payment Receipt -->
            <div class="space-y-6">

                <div class="card p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-receipt text-purple-600"></i>
                        Payment Receipt
                    </h2>

                    @if ($order->payment_receipt)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 mb-3">Uploaded payment proof (click to view fullscreen):</p>
                            <img src="{{ asset(Storage::url($order->payment_receipt)) }}" alt="Payment Receipt"
                                class="w-full rounded-lg shadow-md object-contain max-h-[500px] mx-auto border border-gray-200 receipt-image"
                                onerror="this.src='https://placehold.co/600x800?text=Image+Not+Found';"
                                onclick="openFullscreen(this, 'Payment Receipt for Order #{{ $order->id }}')">
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center text-yellow-700">
                            No receipt uploaded
                        </div>
                    @endif
                </div>

                <!-- Order Summary Card -->
                <div class="card p-6">
                    <h3 class="font-medium mb-3">Order Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Rs. {{ number_format($calculatedTotal ?? $order->Total_amt, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="status-badge {{ $order->veri_status }} text-xs">
                                {{ ucfirst($order->veri_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Status:</span>
                            <span class="status-badge {{ $order->status }} text-xs">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between font-semibold">
                                <span>Total:</span>
                                <span class="text-green-700">Rs. {{ number_format($order->Total_amt, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Timestamps footer -->
        <div class="mt-10 text-center text-sm text-gray-500">
            Created: {{ $order->created_at->format('M d, Y h:i A') }} •
            Last updated: {{ $order->updated_at->format('M d, Y h:i A') }}
        </div>

    </div>

    <script>
        // Function to open fullscreen image
        function openFullscreen(imgElement, caption) {
            const overlay = document.getElementById('fullscreenOverlay');
            const fullscreenImg = document.getElementById('fullscreenImage');
            const fullscreenCaption = document.getElementById('fullscreenCaption');

            fullscreenImg.src = imgElement.src;
            fullscreenCaption.textContent = caption || 'Payment Receipt';
            overlay.classList.add('active');

            // Prevent body scrolling when fullscreen is open
            document.body.style.overflow = 'hidden';
        }

        // Function to close fullscreen
        function closeFullscreen(event) {
            if (event) {
                event.stopPropagation();
            }
            const overlay = document.getElementById('fullscreenOverlay');
            overlay.classList.remove('active');

            // Restore body scrolling
            document.body.style.overflow = 'auto';
        }

        // Close fullscreen with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeFullscreen();
            }
        });

        // Prevent closing when clicking on the image itself
        document.getElementById('fullscreenImage').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>

</body>

</html>
