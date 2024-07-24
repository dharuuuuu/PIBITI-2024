<x-layout>
    <x-slot:title>Tambah Discounts</x-slot:title>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('discounts.store') }}" method="post">
                            @csrf

                            <x-text-input label="Nama Discount" name="nama_discount" placeholder="Masukkan nama discount"
                                value="{{ old('nama_discount') }}"></x-text-input>
                            <x-text-input type='number' label="Total Discount" name="total_discount" placeholder="Masukkan total discount"
                                value="{{ old('total_discount') }}"></x-text-input>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="active"
                                    name="active" @checked(!old() || old('active') == 'on')>
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('discounts.index') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
