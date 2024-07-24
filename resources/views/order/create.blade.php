<x-layout title="Orders">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-grid gap-4">
                    <form class="hstack gap-2" method="get">
                        <select name="category_id" id="category_id" class="form-control w-auto"
                            onchange="this.form.submit()">
                            <option value="">Semua kategori</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-group">
                            <input type="text" placeholder="Cari product" class="form-control" name="search"
                                value="{{ request()->search }}" autofocus>
                        </div>

                        <button type="submit" class="btn btn-dark">Cari</button>
                    </form>

                    <div class="row g-4">
                        @forelse ($products as $product)
                            <div class="col-3">
                                <a href="{{ route('orders.create.detail', ['product' => $product->id]) }}"
                                    class="text-decoration-none">
                                    <div class="card product-card">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                            class="card-img-top border-bottom">
                                        <div class="card-body">
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <div class="hstack">
                                                <small>{{ $product->category->name }}</small>
                                                <small class="ms-auto">
                                                    Rp{{ number_format($product->price) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col text-center">Belum ada products</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <form class="card" method="post" action="{{ route('orders.checkout') }}">
                    @csrf

                    <div class="card-body border-bottom fw-bold">Summary</div>

                    <div class="card-body">
                        <x-text-input name="customer" label="Customer"
                            value="{{ session('order')->customer }}"></x-text-input>
                        
                        <label for="discount" class="form-label">Discount</label>
                        <select name="discount" id="discount" class="form-control" onchange="calculateTotal()">
                            <option disabled selected value="0">-</option>
                            @forelse ($discounts as $discount)
                                <option value="{{ $discount->total_discount }}" data-percentage="{{ $discount->total_discount }}">{{ $discount->nama_discount }} - {{ $discount->total_discount }}%</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="card-body bg-body-tertiary border-bottom">
                        <div class="vstack gap-2">
                            @php
                                $total = 0;
                            @endphp

                            @forelse (session('order')->details as $detail)
                                @php
                                    $total += $detail->qty * $detail->price;
                                @endphp

                                <a href="{{ route('orders.create.detail', ['product' => $detail->product_id]) }}"
                                    class="text-decoration-none">
                                    <div class="card product-card">
                                        <div class="card-body">
                                            <div>{{ $detail->product->name }}</div>
                                            <div class="d-flex justify-content-between">
                                                <div class="form-text">{{ $detail->qty }} x
                                                    {{ number_format($detail->price) }}</div>
                                                <div class="ms-auto form-text">
                                                    Rp{{ number_format($detail->qty * $detail->price) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center">Belum ada product</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card-body border-bottom d-grid gap-2">
                        <div class="d-flex justify-content-between">
                            <div>Discount</div>
                            <h4 class="ms-auto mb-0 fw-bold" id="discount-amount">Rp0</h4>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Total</div>
                            <h4 class="ms-auto mb-0 fw-bold" id="total-amount">Rp{{ number_format($total) }}</h4>
                        </div>
                        <div>
                            <x-text-input name="payment" label="Payment" type="number"></x-text-input>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-row-reverse justify-content-between">
                        <button class="ms-auto btn btn-dark">Checkout</button>
                        <button name="cancel" class="btn btn-light">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calculateTotal() {
            // Get the total amount from the PHP variable
            let total = {{ $total }};
            
            // Get the selected discount percentage
            const discountSelect = document.getElementById('discount');
            const selectedDiscount = discountSelect.options[discountSelect.selectedIndex];
            const discountPercentage = selectedDiscount.getAttribute('data-percentage') || 0;
            
            // Calculate discount amount
            const discountAmount = total * (discountPercentage / 100);
            
            // Calculate new total after discount
            const newTotal = total - discountAmount;
            
            // Update the discount and total amounts in the DOM
            document.getElementById('discount-amount').innerText = 'Rp' + discountAmount.toLocaleString('id-ID');
            document.getElementById('total-amount').innerText = 'Rp' + newTotal.toLocaleString('id-ID');
        }

        // Initial calculation when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>
</x-layout>
