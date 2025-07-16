<x-app-layout>
    <x-slot name="title">
        Edit Warung
    </x-slot>

    {{-- Tampilkan pesan error umum --}}
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
            <form action="{{ route('admin.warung.update', [$warung->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_warung">Nama Warung</label>
                    <input type="text" 
                           class="form-control @error('nama_warung') is-invalid @enderror" 
                           name="nama_warung" 
                           id="nama_warung"
                           value="{{ old('nama_warung', $warung->nama_warung) }}">
                    @error('nama_warung')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" 
                           class="form-control @error('alamat') is-invalid @enderror" 
                           name="alamat" 
                           id="alamat"
                           value="{{ old('alamat', $warung->alamat) }}">
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success text-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>
