<x-app-layout>
    <x-slot name="title">Tambah Harga</x-slot>

    {{-- show alert if there is errors --}}
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

        <div class="form-group">
            <label for="exampleSelect">Nama Barang</label>
            <select name="id_barang" class="form-control" id="id_barang">
                <option value="" disabled>Pilih Barang</option>
                @foreach($barang as $b)
                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleSelect">Harga Ecer</label>
            <input class="form-control" placeholder="masukkan harga ecer" name="harga_ecer" type="text" />
        </div>


        <div class="form-group">
            <label for="exampleSelect">Harga Grosir</label>
            <input class="form-control" placeholder="masukkan harga grosir" name="harga_grosir" type="text" />
        </div>

        <div class="form-group">
            <label for="exampleSelect">Harga Jual</label>
            <input class="form-control" placeholder="masukkan harga jual" name="harga_jual" type="text" />
        </div>


        <div class="form-group">
            <label class="form-control-label" for="status_member">Kategori</label>
            <select class="form-control" id="status" name="status" required="required">
            <option value="active" <?= $barang->status === 'active' ? 'selected' : '' ?>>active</option>                
            <option value="non-active" <?= $barang->status === 'non-active' ? 'selected' : '' ?>>non-active</option>                

        </select>
            </select>    
        </div>
                      

        <div class="text-right">
            <button type="submit" class="btn btn-success text-right">Simpan</button>
        </div>

    </form>


</x-app-layout>