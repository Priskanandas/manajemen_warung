<x-app-layout>
    <x-slot name="title">Edit Pembelian</x-slot>

    <x-alert-error />

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif

    <div class="row mb-3">
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.pembelian.update', $pembelian->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_barang">Nama Barang</label>
                    <select name="id_barang" class="form-control" id="id_barang" required>
                        <option value="" disabled>Pilih Barang</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" {{ $b->id == $pembelian->id_barang ? 'selected' : '' }}>
                                {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_beli">Tanggal Beli</label>
                    <input type="date" class="form-control" name="tanggal_beli"
                        value="{{ $pembelian->tanggal ?? $pembelian->created_at->format('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="jml_beli">Jumlah Beli</label>
                    <input type="number" class="form-control" id="jml_beli" name="jml_beli"
                        value="{{ $pembelian->jml_beli }}" required min="1">
                </div>

                <div class="form-group">
                    <label for="harga_beli">Harga Satuan</label>
                    <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                        value="{{ $pembelian->harga_beli }}" required min="0">
                </div>

                <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input type="number" class="form-control" id="subtotal" name="subtotal"
                        value="{{ $pembelian->subtotal }}" readonly>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Perhitungan Otomatis --}}
    <script>
        const jml = document.getElementById('jml_beli');
        const satuan = document.getElementById('harga_beli');
        const subtotal = document.getElementById('subtotal');

        function updateSubtotal() {
            const harga = parseFloat(satuan.value);
            const jumlah = parseFloat(jml.value);
            if (!isNaN(harga) && !isNaN(jumlah)) {
                subtotal.value = (harga * jumlah).toFixed(0);
            } else {
                subtotal.value = '';
            }
        }

        satuan.addEventListener('input', updateSubtotal);
        jml.addEventListener('input', updateSubtotal);

        // Jalankan saat load jika sudah ada isian
        document.addEventListener('DOMContentLoaded', updateSubtotal);
    </script>
</x-app-layout>
