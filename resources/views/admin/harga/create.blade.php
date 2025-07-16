<x-app-layout>
    <x-slot name="title">Tambah Harga</x-slot>

    <x-alert-error />

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif

    <div class="row mb-3">
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <form action="{{ route('admin.harga.store') }}" method="POST">
        @csrf

        {{-- Pilih Barang --}}
        <div class="form-group">
            <label for="id_barang">Nama Barang</label>
            <select name="id_barang" class="form-control" id="id_barang" required>
                <option value="" disabled selected>Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}" {{ old('id_barang') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Harga Beli dari Pembelian (readonly tampilan) --}}
        <div class="form-group">
            <label for="harga_beli">Harga Beli (Rp)</label>
            <input class="form-control" id="harga_beli" type="number" readonly placeholder="Otomatis dari pembelian" />
        </div>

        {{-- Hidden ID Pembelian --}}
        <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ old('id_pembelian') }}">

        {{-- Harga Jual --}}
        <div class="form-group">
            <label for="harga_jual">Harga Jual (Rp)</label>
            <input class="form-control" id="harga_jual" name="harga_jual" type="number" min="0" required
                   value="{{ old('harga_jual') }}" placeholder="Masukkan harga jual tanpa titik/koma" />
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" id="status" required>
                <option value="" disabled selected>Pilih Status</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="non-active" {{ old('status') == 'non-active' ? 'selected' : '' }}>Non-Active</option>
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- AJAX ambil harga beli dan id_pembelian --}}
    <script>
        $('#id_barang').on('change', function() {
            const id_barang = $(this).val();
            const url = '{{ route("admin.harga.ajax", ":id") }}'.replace(':id', id_barang);

            $.get(url, function(data) {
                // data sudah dalam bentuk JSON
                $('#harga_beli').val(data.harga_beli ?? '');
                $('#id_pembelian').val(data.id_pembelian ?? '');
            }).fail(function() {
                alert('Gagal mengambil data pembelian.');
            });
        });
    </script>
</x-app-layout>
