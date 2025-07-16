<x-app-layout>
    <x-slot name="title">Edit Penjualan</x-slot>

    <x-alert-error />
    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="row mb-3">
        <div class="col text-right">
            <a href="{{ route('admin.penjualan') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <form action="{{ route('admin.penjualan.update', [$penjualan->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="id_barang">Nama Barang</label>
            <select name="id_barang" id="id_barang" class="form-control">
                @foreach($barang as $b)
                    <option value="{{ $b->id }}" {{ $penjualan->id_barang == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $penjualan->satuan }}">
        </div>

        <div class="form-group">
            <label for="jml_beli">Jumlah Beli</label>
            <input type="number" name="jml_beli" id="jml_beli" class="form-control" value="{{ $penjualan->jml_beli }}">
        </div>

        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="{{ $penjualan->harga_jual }}">
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="number" name="total_harga" id="total_harga" class="form-control" value="{{ $penjualan->total_harga }}">
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>

    <x-slot name="script">
        <script>
            // Optional auto-calc
            const jmlInput = document.getElementById('jml_beli');
            const hargaInput = document.getElementById('harga_jual');
            const totalInput = document.getElementById('total_harga');

            function updateTotal() {
                const jml = parseInt(jmlInput.value) || 0;
                const harga = parseInt(hargaInput.value) || 0;
                totalInput.value = jml * harga;
            }

            jmlInput.addEventListener('input', updateTotal);
            hargaInput.addEventListener('input', updateTotal);
        </script>
    </x-slot>
</x-app-layout>
