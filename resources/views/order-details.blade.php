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
    </style>
</head>

<body class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">

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
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i>
                        Customer Information
                    </h2>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
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
                                            Quantity</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product ID</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->order_items as $item)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->product->title ?? 'Product #' . $item->product_id }}
                                                </div>
                                                @if ($item->product && $item->product->sku)
                                                    <div class="text-xs text-gray-500">SKU: {{ $item->product->sku }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->qty }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $item->product_id }}
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
                            <p class="text-sm text-gray-600 mb-3">Uploaded payment proof:</p>
                            <img src="{{ asset(Storage::url($order->payment_receipt)) }}" alt="Payment Receipt"
                                class="w-full rounded-lg shadow-md object-contain max-h-[500px] mx-auto border border-gray-200"
                                onerror="this.src='https://placehold.co/600x800?text=Image+Not+Found';">
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center text-yellow-700">
                            No receipt uploaded
                        </div>
                    @endif
                </div>

                <!-- Quick Actions (optional) -->
                {{-- <div class="card p-6">
                    <h3 class="font-medium mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('order.details', $order) }}"
                            class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                            Back to List
                        </a>
                        <!-- You can add more admin actions here (verify, change status, etc.) -->
                    </div>
                </div> --}}

            </div>

        </div>

        <!-- Timestamps footer -->
        <div class="mt-10 text-center text-sm text-gray-500">
            Created: {{ $order->created_at->format('M d, Y h:i A') }} •
            Last updated: {{ $order->updated_at->format('M d, Y h:i A') }}
        </div>

    </div>

</body>

</html>
