<x-layout>
    <x-slot:title>Discounts</x-slot:title>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex mb-2 justify-content-between">
            <form class="d-flex gap-2" method="get">
                <input type="text" class="form-control w-auto" placeholder="Cari discount" name="search"
                    value="{{ request()->search }}">
                <button type="submit" class="btn btn-dark">Cari</button>
            </form>
            <a href="/discounts/create" class="btn btn-dark">Tambah</a>
        </div>

        <div class="card overflow-hidden">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th scope="col">Nama Discount</th>
                        <th scope="col">Total Discount</th>
                        <th scope="col">Aktif</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($discounts as $discount)
                        <tr>
                            <td>{{ $discount->nama_discount }}</td>
                            <td>{{ $discount->total_discount }}%</td>
                            <td>
                                @if ($discount->active)
                                    <span class="badge text-bg-primary">Aktif</span>
                                @else
                                    <span class="badge text-bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-end gap-2">
                                <a href="{{ route('discounts.edit', ['discount' => $discount->id]) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('discounts.destroy', ['discount' => $discount->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada discount</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
