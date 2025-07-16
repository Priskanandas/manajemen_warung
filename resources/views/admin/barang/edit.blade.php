<x-app-layout>
    <x-slot name="title">Edit Barang</x-slot>

    <x-alert-error />

    <div class="row mb-3">
        <div class="col">
            <h4 class="card-title">Edit Barang</h4>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="kd_barang">Kode Barang</label>
                    <input type="text" id="kd_barang" name="kd_barang"
                        class="form-control @error('kd_barang') is-invalid @enderror"
                        value="{{ old('kd_barang', $barang->kd_barang) }}" readonly>
                    @error('kd_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang"
                        class="form-control @error('nama_barang') is-invalid @enderror"
                        value="{{ old('nama_barang', $barang->nama_barang) }}" placeholder="Contoh: Teh Botol Sosro">
                    @error('nama_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="satuan">Satuan</label>
                    <select name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror">
                        <option value="" disabled>Pilih Satuan</option>
                        @foreach (['Kg','Pcs','Liter','Dus','Botol','Bungkus','Buah','Batang','Kaleng','Lembar','Pasang'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $barang->satuan) == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_kategori">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('id_kategori', $barang->id_kategori) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opsional: stok bisa dihilangkan jika dihitung otomatis --}}
                {{-- <div class="form-group mb-3">
                    <label>Stok (otomatis)</label>
                    <input type="number" class="form-control" value="{{ $barang->stok }}" readonly>
                </div> --}}

                <div class="form-group mb-3">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" id="harga_beli" name="harga_beli"
                        class="form-control @error('harga_beli') is-invalid @enderror"
                        value="{{ old('harga_beli', $barang->hargaAktif->harga_beli ?? '') }}" placeholder="Masukkan Harga Beli">
                    @error('harga_beli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" id="harga_jual" name="harga_jual"
                        class="form-control @error('harga_jual') is-invalid @enderror"
                        value="{{ old('harga_jual', $barang->hargaAktif->harga_jual ?? '') }}" placeholder="Masukkan Harga Jual">
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>
