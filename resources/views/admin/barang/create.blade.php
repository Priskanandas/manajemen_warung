<x-app-layout>
    <x-slot name="title">Barang</x-slot>

    <x-alert-error />

    <div class="row mb-3">
        <div class="col">
            <h4 class="card-title">Tambah Barang</h4>
        </div>
        <div class="col text-right">
            <a href="{{ route('admin.barang') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('admin.barang.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang"
                        class="form-control @error('nama_barang') is-invalid @enderror"
                        value="{{ old('nama_barang') }}" placeholder="Contoh: Teh Botol Sosro">
                    @error('nama_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="satuan">Satuan</label>
                    <select name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Satuan</option>
                        @foreach (['Kg','Pcs','Liter','Dus','Botol','Bungkus','Buah','Batang','Kaleng','Lembar','Pasang'] as $s)
                            <option value="{{ $s }}" {{ old('satuan') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_kategori">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opsional: input stok awal jika diinginkan --}}
                {{-- <div class="form-group mb-3">
                    <label for="stok">Stok Awal</label>
                    <input type="number" id="stok" name="stok" class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok') }}" placeholder="Masukkan jumlah awal stok (opsional)">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="text-right">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>

