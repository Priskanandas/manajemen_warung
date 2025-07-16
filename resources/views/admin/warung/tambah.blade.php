<x-app-layout>
    <x-slot name="title">
        Tambah Warung
    </x-slot>

    <div class="row mb-3">
        <div class="col">
            <h4 class="card-title">Tambah Warung</h4>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.warung.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Warung</label>
                    <input type="text" class="form-control" id="nama_warung" name="nama_warung" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
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
