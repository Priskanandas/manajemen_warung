<x-app-layout>
    <x-slot name="title">
        Edit Harga
    </x-slot>

    <x-alert-error />

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="row mb-3">
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.harga.update', $harga->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="id_barang" class="form-control" id="id_barang">
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" {{ $harga->id_barang == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- input hidden untuk id_pembelian --}}
                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $harga->id_pembelian }}">

                <div class="form-group">
                    <label>Harga Jual</label>
                    <input class="form-control" value="{{ $harga->harga_jual }}" name="harga_jual" type="number" min="0" />
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="active" {{ $harga->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="non-active" {{ $harga->status === 'non-active' ? 'selected' : '' }}>Non-Active</option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- AJAX untuk ambil harga beli dan id_pembelian --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#id_barang').on('change', function () {
            var id_barang = $(this).val();
            var url = '{{ route("admin.harga.ajax", ":id") }}'.replace(':id', id_barang);

            $.get(url, function (data) {
                $('#id_pembelian').val(data.id_pembelian);
                // jika kamu ingin tambahkan harga beli, bisa disimpan di readonly input jika perlu
                // $('#harga_beli').val(data.harga_beli);
            });
        });
    </script>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>
