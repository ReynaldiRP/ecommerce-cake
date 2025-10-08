<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\PaymentStatusHistory;
use App\Models\Topping;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EnhancedOrderSeeder extends Seeder
{
    private array $orderStatuses = [
        'Menunggu pembayaran' => [
            'weight' => 20,
            'next_statuses' => ['Pesanan dikonfirmasi', 'Pesanan dibatalkan'],
            'description' => 'Menunggu konfirmasi pembayaran dari pelanggan'
        ],
        'Pesanan dikonfirmasi' => [
            'weight' => 18,
            'next_statuses' => ['Pesanan diproses', 'Pesanan dibatalkan'],
            'description' => 'Pesanan telah dikonfirmasi dan pembayaran valid'
        ],
        'Pesanan diproses' => [
            'weight' => 15,
            'next_statuses' => ['Pesanan dikemas'],
            'description' => 'Pesanan sedang dalam proses pembuatan'
        ],
        'Pesanan dikemas' => [
            'weight' => 12,
            'next_statuses' => ['Pesanan dikirim'],
            'description' => 'Pesanan telah selesai dan sedang dikemas'
        ],
        'Pesanan dikirim' => [
            'weight' => 8,
            'next_statuses' => ['Pesanan diterima'],
            'description' => 'Pesanan sedang dalam perjalanan ke alamat tujuan'
        ],
        'Pesanan diterima' => [
            'weight' => 1,
            'next_statuses' => [],
            'description' => 'Pesanan telah selesai dan diterima pelanggan'
        ],
        'Pesanan dibatalkan' => [
            'weight' => 1,
            'next_statuses' => [],
            'description' => 'Pesanan dibatalkan karena berbagai alasan'
        ],
        'Pesanan kadaluwarsa' => [
            'weight' => 1,
            'next_statuses' => [],
            'description' => 'Pesanan kadaluwarsa karena tidak ada pembayaran'
        ]
    ];

    private array $paymentStatuses = [
        'Menunggu pembayaran' => [
            'weight' => 25,
            'description' => 'Menunggu pelanggan melakukan pembayaran'
        ],
        'Pesanan terbayar' => [
            'weight' => 60,
            'description' => 'Pembayaran telah berhasil dikonfirmasi'
        ],
        'Pembayaran kedaluwarsa' => [
            'weight' => 10,
            'description' => 'Pembayaran kedaluwarsa karena melewati batas waktu'
        ],
        'Pembayaran dibatalkan' => [
            'weight' => 5,
            'description' => 'Pembayaran dibatalkan oleh pelanggan atau sistem'
        ]
    ];

    private array $cancellationReasons = [
        'payment_timeout' => [
            'weight' => 35,
            'description' => 'Pesanan dibatalkan karena pelanggan tidak melakukan pembayaran dalam batas waktu yang ditentukan',
            'cancellation_stage' => 'Menunggu pembayaran',
            'hours_delay' => [24, 72]
        ],
        'customer_request' => [
            'weight' => 25,
            'description' => 'Pesanan dibatalkan atas permintaan pelanggan',
            'cancellation_stage' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi'],
            'hours_delay' => [1, 24]
        ],
        'payment_failed' => [
            'weight' => 15,
            'description' => 'Pesanan dibatalkan karena pembayaran gagal atau tidak valid',
            'cancellation_stage' => 'Menunggu pembayaran',
            'hours_delay' => [2, 12]
        ],
        'out_of_stock' => [
            'weight' => 10,
            'description' => 'Pesanan dibatalkan karena bahan atau produk tidak tersedia',
            'cancellation_stage' => ['Pesanan dikonfirmasi', 'Pesanan diproses'],
            'hours_delay' => [2, 24]
        ],
        'address_invalid' => [
            'weight' => 8,
            'description' => 'Pesanan dibatalkan karena alamat pengiriman tidak valid atau tidak dapat dijangkau',
            'cancellation_stage' => ['Pesanan dikonfirmasi', 'Pesanan dikemas'],
            'hours_delay' => [4, 48]
        ],
        'technical_issue' => [
            'weight' => 4,
            'description' => 'Pesanan dibatalkan karena masalah teknis dalam sistem',
            'cancellation_stage' => ['Menunggu pembayaran'],
            'hours_delay' => [1, 6]
        ],
        'duplicate_order' => [
            'weight' => 3,
            'description' => 'Pesanan dibatalkan karena pesanan duplikat terdeteksi',
            'cancellation_stage' => ['Menunggu pembayaran'],
            'hours_delay' => [0, 4]
        ]
    ];

    private array $paymentMethods = [
        'Transfer Bank' => 40,
        'E-Wallet (GoPay)' => 25,
        'E-Wallet (OVO)' => 15,
        'E-Wallet (DANA)' => 10,
        'Cash' => 8,
        'Kartu Kredit' => 2
    ];

    private array $customizedCakes = [
        'Black Forest Cake',
        'Red Velvet Cake',
        'Tiramisu Cake',
        'Mocha Cake',
        'Traditional Tiered Cake',
        'Naked Cake',
        'Semi-Naked Cake',
    ];

    private array $deliveryMethods = [
        'Dikirim' => 70,
        'Ambil di toko' => 30
    ];

    public function run(): void
    {
        // Get required data
        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'pelanggan');
        })->get();

        $cakes = Cake::with('discount')->get();
        $cakeSizes = CakeSize::all();
        $flavours = Flavour::all();
        $toppings = Topping::all();

        $faker = Factory::create('id_ID'); // Using Indonesian locale for realistic addresses

        // Create 150 orders with realistic distribution
        for ($i = 0; $i < 150; $i++) {
            $this->createRealisticOrder($users, $cakes, $cakeSizes, $flavours, $toppings, $faker);
        }
    }

    private function weightedRandom(array $weights, $faker): string
    {
        $totalWeight = array_sum($weights);
        $random = $faker->numberBetween(1, $totalWeight);

        $currentWeight = 0;
        foreach ($weights as $item => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $item;
            }
        }

        return array_key_first($weights); // fallback
    }

    private function createRealisticOrder($users, $cakes, $cakeSizes, $flavours, $toppings, $faker)
    {
        // Generate realistic creation date (last 6 months with higher recent activity)
        $createdAt = $this->generateRealisticDate($faker);

        // Select order status based on weights and order age
        $orderStatus = $this->selectOrderStatus($createdAt, $faker);

        // Select delivery method
        $deliveryMethod = $this->weightedRandom($this->deliveryMethods, $faker);

        // Create the order
        $order = Order::create([
            'user_id' => $users->random()->id,
            'order_code' => $this->generateOrderCode(),
            'estimated_delivery_date' => $this->calculateDeliveryDate($createdAt, $deliveryMethod),
            'method_delivery' => $deliveryMethod,
            'user_address' => $this->generateIndonesianAddress($faker),
            'cake_recipient' => $faker->name,
            'status' => $orderStatus,
            'total_price' => 0,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        // Create order items (1-3 items per order, weighted towards 1-2 items)
        $itemCount = $faker->randomElement([1, 1, 1, 2, 2, 3]);
        $totalPrice = 0;

        for ($j = 0; $j < $itemCount; $j++) {
            $cake = $cakes->random();
            $quantity = $faker->randomElement([1, 1, 1, 2, 2, 3]); // Weighted towards 1-2 pieces

            // Determine if cake is customized
            $isCustomized = in_array($cake->name, $this->customizedCakes);

            $size = $isCustomized ? $cakeSizes->random() : null;
            $flavour = $isCustomized ? $flavours->random() : null;
            $selectedToppings = $isCustomized ? $this->selectToppings($toppings, $faker) : collect();

            // Calculate item price
            $basePrice = $cake->base_price;
            $sizePrice = $size ? $size->price : 0;
            $flavourPrice = $flavour ? $flavour->price : 0;
            $toppingsPrice = $selectedToppings->sum('price');

            $itemPrice = ($basePrice + $sizePrice + $flavourPrice + $toppingsPrice) * $quantity;
            $totalPrice += $itemPrice;

            // Create order item
            $orderItem = $order->orderItems()->create([
                'cake_id' => $cake->id,
                'cake_size_id' => $size?->id,
                'cake_flavour_id' => $flavour?->id,
                'quantity' => $quantity,
                'price' => $itemPrice,
                'created_at' => $order->created_at,
                'updated_at' => $order->created_at,
            ]);

            // Attach toppings if any
            if ($selectedToppings->isNotEmpty()) {
                $orderItem->cakeTopping()->attach($selectedToppings->pluck('id')->toArray());
            }
        }

        // Update total price
        $order->update(['total_price' => $totalPrice]);

        // Create order status history
        $this->createOrderStatusHistory($order, $faker);

        // Create payment and payment status history
        $this->createPaymentWithHistory($order, $faker);
    }

    private function generateRealisticDate($faker): Carbon
    {
        // 70% of orders in last 3 months, 30% in 3-6 months ago
        if ($faker->boolean(70)) {
            return Carbon::instance($faker->dateTimeBetween('-3 months', 'now'));
        } else {
            return Carbon::instance($faker->dateTimeBetween('-6 months', '-3 months'));
        }
    }

    private function selectOrderStatus($createdAt, $faker): string
    {
        $orderAge = Carbon::parse($createdAt)->diffInDays(now());

        // Newer orders are more likely to be in early stages
        if ($orderAge < 7) {
            // Recent orders: more likely to be in early stages, higher cancellation rate
            $weights = [
                'Menunggu pembayaran' => 25,
                'Pesanan dikonfirmasi' => 20,
                'Pesanan diproses' => 15,
                'Pesanan dikemas' => 12,
                'Pesanan dikirim' => 8,
                'Pesanan diterima' => 5,
                'Pesanan dibatalkan' => 10, // Higher cancellation for recent orders
                'Pesanan kadaluwarsa' => 5,
            ];
        } elseif ($orderAge < 30) {
            // Medium age orders: mixed stages, moderate cancellation
            $weights = [
                'Pesanan diproses' => 20,
                'Pesanan dikemas' => 18,
                'Pesanan dikirim' => 15,
                'Pesanan diterima' => 25,
                'Pesanan dibatalkan' => 15, // Moderate cancellation
                'Pesanan kadaluwarsa' => 7,
            ];
        } else {
            // Older orders: mostly completed, some historical cancellations
            $weights = [
                'Pesanan diterima' => 65,
                'Pesanan dibatalkan' => 25, // Historical cancellations
                'Pesanan kadaluwarsa' => 10,
            ];
        }

        return $this->weightedRandom($weights, $faker);
    }
    private function calculateDeliveryDate($createdAt, $deliveryMethod): Carbon
    {
        $baseDate = Carbon::parse($createdAt);

        if ($deliveryMethod === 'Dikirim') {
            // Delivery: 2-5 days
            return $baseDate->addDays(rand(2, 5));
        } else {
            // Pickup: 1-3 days
            return $baseDate->addDays(rand(1, 3));
        }
    }

    private function generateOrderCode(): string
    {
        return 'ORD-' . strtoupper(Str::random(8));
    }

    private function generateIndonesianAddress($faker): string
    {
        $streets = [
            'Jl. Merdeka',
            'Jl. Sudirman',
            'Jl. Thamrin',
            'Jl. Gatot Subroto',
            'Jl. Ahmad Yani',
            'Jl. Diponegoro',
            'Jl. Veteran',
            'Jl. Pahlawan',
            'Jl. Raya Kebayoran',
            'Jl. Kemang Raya',
            'Jl. Senopati'
        ];

        $areas = [
            'Kebayoran Baru',
            'Senayan',
            'Kemang',
            'Menteng',
            'Kelapa Gading',
            'PIK',
            'BSD',
            'Serpong',
            'Pondok Indah',
            'Gandaria'
        ];

        $street = $faker->randomElement($streets);
        $number = $faker->numberBetween(1, 999);
        $area = $faker->randomElement($areas);
        $city = $faker->randomElement(['Jakarta Selatan', 'Jakarta Pusat', 'Tangerang', 'Depok']);

        return "{$street} No. {$number}, {$area}, {$city}";
    }

    private function selectToppings($toppings, $faker)
    {
        // 60% chance of having toppings, 40% chance of none
        if ($faker->boolean(40)) {
            return collect();
        }

        // 1-3 toppings, weighted towards 1-2
        $count = $faker->randomElement([1, 1, 1, 2, 2, 3]);
        return $toppings->random($count);
    }

    private function createOrderStatusHistory($order, $faker)
    {
        $currentStatus = $order->status;
        $statusFlow = $this->generateStatusFlow($currentStatus, $order->created_at, $faker);

        foreach ($statusFlow as $statusData) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $statusData['status'],
                'description' => $statusData['description'],
                'created_at' => $statusData['created_at'],
                'updated_at' => $statusData['created_at'],
            ]);
        }
    }

    private function generateStatusFlow($finalStatus, $startDate, $faker): array
    {
        $flow = [];
        $currentDate = Carbon::parse($startDate);

        if ($finalStatus === 'Pesanan dibatalkan') {
            return $this->generateCancellationFlow($startDate, $faker);
        }

        // Define logical status progression for successful orders
        $statusProgression = [
            'Menunggu pembayaran' => [],
            'Pesanan dikonfirmasi' => ['Menunggu pembayaran'],
            'Pesanan diproses' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi'],
            'Pesanan dikemas' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi', 'Pesanan diproses'],
            'Pesanan dikirim' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi', 'Pesanan diproses', 'Pesanan dikemas'],
            'Pesanan diterima' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi', 'Pesanan diproses', 'Pesanan dikemas', 'Pesanan dikirim'],
            'Pesanan kadaluwarsa' => [],
        ];

        $requiredStatuses = $statusProgression[$finalStatus] ?? [];
        $allStatuses = array_merge($requiredStatuses, [$finalStatus]);

        foreach ($allStatuses as $status) {
            $flow[] = [
                'status' => $status,
                'description' => $this->orderStatuses[$status]['description'],
                'created_at' => $currentDate->copy(),
            ];

            // Add realistic time between status changes
            $hoursToAdd = match ($status) {
                'Menunggu pembayaran' => $faker->numberBetween(1, 24),
                'Pesanan dikonfirmasi' => $faker->numberBetween(1, 4),
                'Pesanan diproses' => $faker->numberBetween(12, 48),
                'Pesanan dikemas' => $faker->numberBetween(2, 8),
                'Pesanan dikirim' => $faker->numberBetween(2, 24),
                'Pesanan diterima' => $faker->numberBetween(1, 6),
                default => $faker->numberBetween(1, 6),
            };

            $currentDate->addHours($hoursToAdd);
        }

        return $flow;
    }

    private function generateCancellationFlow($startDate, $faker): array
    {
        $flow = [];
        $currentDate = Carbon::parse($startDate);

        // Select cancellation reason using weighted selection
        $reasonKeys = array_keys($this->cancellationReasons);
        $reasonWeights = array_column($this->cancellationReasons, 'weight');
        $selectedReasonKey = $reasonKeys[array_search($this->weightedRandom(array_combine($reasonKeys, $reasonWeights), $faker), $reasonKeys)];

        // Get the actual reason data
        $reasonData = $this->cancellationReasons[$selectedReasonKey];

        // Determine cancellation stage
        $cancellationStage = is_array($reasonData['cancellation_stage'])
            ? $faker->randomElement($reasonData['cancellation_stage'])
            : $reasonData['cancellation_stage'];

        // Build flow up to cancellation point
        $statusesToCancellation = match ($cancellationStage) {
            'Menunggu pembayaran' => ['Menunggu pembayaran'],
            'Pesanan dikonfirmasi' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi'],
            'Pesanan diproses' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi', 'Pesanan diproses'],
            'Pesanan dikemas' => ['Menunggu pembayaran', 'Pesanan dikonfirmasi', 'Pesanan diproses', 'Pesanan dikemas'],
            default => ['Menunggu pembayaran'],
        };

        // Add normal flow statuses
        foreach ($statusesToCancellation as $status) {
            $flow[] = [
                'status' => $status,
                'description' => $this->orderStatuses[$status]['description'],
                'created_at' => $currentDate->copy(),
            ];

            // Add time between statuses
            $hoursToAdd = match ($status) {
                'Menunggu pembayaran' => $faker->numberBetween(1, 12),
                'Pesanan dikonfirmasi' => $faker->numberBetween(1, 4),
                'Pesanan diproses' => $faker->numberBetween(4, 24),
                'Pesanan dikemas' => $faker->numberBetween(1, 6),
                default => $faker->numberBetween(1, 6),
            };

            $currentDate->addHours($hoursToAdd);
        }

        // Add delay before cancellation
        $delayHours = $faker->numberBetween($reasonData['hours_delay'][0], $reasonData['hours_delay'][1]);
        $currentDate->addHours($delayHours);

        // Add cancellation status with specific reason
        $flow[] = [
            'status' => 'Pesanan dibatalkan',
            'description' => $reasonData['description'] . " (Alasan: " . ucwords(str_replace('_', ' ', $selectedReasonKey)) . ")",
            'created_at' => $currentDate->copy(),
        ];

        return $flow;
    }

    private function createPaymentWithHistory($order, $faker)
    {
        // Select payment method
        $paymentMethod = $this->weightedRandom($this->paymentMethods, $faker);

        // Select payment status based on order status
        $paymentStatus = $this->selectPaymentStatus($order->status, $faker);

        // Create payment
        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $this->generateTransactionId($paymentMethod),
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'created_at' => $order->created_at,
            'updated_at' => $order->created_at,
        ]);

        // Create payment status history
        $this->createPaymentStatusHistory($payment, $order, $faker);
    }

    private function selectPaymentStatus($orderStatus, $faker): string
    {
        return match ($orderStatus) {
            'Menunggu pembayaran' => 'Menunggu pembayaran',
            'Pesanan dibatalkan' => $this->weightedRandom([
                'Menunggu pembayaran' => 60, // cancelled before payment
                'Pembayaran kedaluwarsa' => 30,    // payment expired
                'Pembayaran dibatalkan' => 10      // payment cancelled
            ], $faker),
            'Pesanan kadaluwarsa' => 'Pembayaran kedaluwarsa',
            default => 'Pesanan terbayar',
        };
    }

    private function generateTransactionId($paymentMethod): string
    {
        $prefix = match ($paymentMethod) {
            'Transfer Bank' => 'TRF',
            'E-Wallet (GoPay)' => 'GP',
            'E-Wallet (OVO)' => 'OVO',
            'E-Wallet (DANA)' => 'DANA',
            'Cash' => 'CASH',
            'Kartu Kredit' => 'CC',
            default => 'PAY',
        };

        return $prefix . '-' . strtoupper(Str::random(10));
    }

    private function createPaymentStatusHistory($payment, $order, $faker)
    {
        $flow = [];
        $currentDate = Carbon::parse($order->created_at);

        if ($payment->payment_status === 'Menunggu pembayaran') {
            $flow[] = [
                'status' => 'Menunggu pembayaran',
                'description' => 'Menunggu pelanggan melakukan pembayaran',
                'created_at' => $currentDate->copy(),
            ];
        } elseif ($payment->payment_status === 'Pembayaran kedaluwarsa') {
            $flow[] = [
                'status' => 'Menunggu pembayaran',
                'description' => 'Menunggu pelanggan melakukan pembayaran',
                'created_at' => $currentDate->copy(),
            ];

            $currentDate->addHours($faker->numberBetween(24, 72));

            $flow[] = [
                'status' => 'Pembayaran kedaluwarsa',
                'description' => 'Pembayaran kedaluwarsa karena melewati batas waktu',
                'created_at' => $currentDate->copy(),
            ];
        } elseif ($payment->payment_status === 'Pembayaran dibatalkan') {
            $flow[] = [
                'status' => 'Menunggu pembayaran',
                'description' => 'Menunggu pelanggan melakukan pembayaran',
                'created_at' => $currentDate->copy(),
            ];

            $currentDate->addHours($faker->numberBetween(1, 12));

            $flow[] = [
                'status' => 'Pembayaran dibatalkan',
                'description' => 'Pembayaran dibatalkan oleh pelanggan atau sistem',
                'created_at' => $currentDate->copy(),
            ];
        } else {
            // Payment went through successfully
            $flow[] = [
                'status' => 'Menunggu pembayaran',
                'description' => 'Menunggu pelanggan melakukan pembayaran',
                'created_at' => $currentDate->copy(),
            ];

            $currentDate->addHours($faker->numberBetween(1, 24));

            $flow[] = [
                'status' => 'Pesanan terbayar',
                'description' => 'Pembayaran telah berhasil dikonfirmasi',
                'created_at' => $currentDate->copy(),
            ];
        }

        foreach ($flow as $statusData) {
            PaymentStatusHistory::create([
                'payment_id' => $payment->id,
                'status' => $statusData['status'],
                'description' => $statusData['description'],
                'created_at' => $statusData['created_at'],
                'updated_at' => $statusData['created_at'],
            ]);
        }
    }
}
