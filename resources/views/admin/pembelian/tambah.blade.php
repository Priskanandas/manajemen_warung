<x-app-layout>
    <x-slot name="title">Tambah Pembelian</x-slot>

    <x-alert-error />

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif

    <div class="row mb-3">
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <form action="{{ route('admin.pembelian.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_barang">Nama Barang</label>
            <select name="id_barang" class="form-control" id="id_barang" required>
                <option value="" selected disabled>Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="satuan">Satuan</label>
            <input class="form-control" name="satuan" id="satuan" type="text" readonly />
        </div>

        <div class="form-group">
            <label for="jml_beli">Jumlah Beli</label>
            <input class="form-control" name="jml_beli" id="jml_beli" placeholder="Masukkan jumlah beli" type="number" min="1" required />
        </div>

        <div class="form-group">
            <label for="harga_beli">Harga Satuan</label>
            <input class="form-control" name="harga_beli" id="harga_beli" placeholder="Masukkan harga per item" type="number" min="0" required />
        </div>

        <div class="form-group">
            <label for="subtotal">Subtotal</label>
            <input class="form-control" id="subtotal" name="subtotal" type="number" placeholder="Otomatis atau input jika tahu total" />
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>

    {{-- JQuery untuk AJAX & perhitungan --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // AJAX untuk ambil satuan
        $('#id_barang').on('change', function () {
            const id_barang = $(this).val();
            const url = '{{ route("admin.pembelian.ajax", ":id") }}'.replace(':id', id_barang);

            $.get(url, function (data) {
                $('#satuan').val(data.satuan ?? '');
            });
        });

        // Hitung subtotal saat harga dan jumlah terisi
        $('#harga_beli, #jml_beli').on('input', function () {
            const harga = parseFloat($('#harga_beli').val());
            const jumlah = parseFloat($('#jml_beli').val());
            if (harga > 0 && jumlah > 0) {
                $('#subtotal').val(harga * jumlah);
            } else {
                $('#subtotal').val('');
            }
        });
    </script>
</x-app-layout>
