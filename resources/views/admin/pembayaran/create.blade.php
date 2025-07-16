<x-app-layout>
    <x-slot name="title">
        Pembayaran
    </x-slot>

    <div class="row mb-3">
        <div class="col">
            <h4 class="card-title">Tambah Pembayaran</h4>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <script>
    function sum() {
        var totalbayar = document.getElementById('total_bayar').value;
        var totaluang = document.getElementById('total_uang').value;
        var result = parseInt(totaluang) - parseInt(totalbayar);
        if (!isNaN(result)) {
            document.getElementById('uang_kembali').value = result;
        }
    }
    </script>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                @csrf
                <div class="container wrap mb-5">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input id="tanggal" type="text" name="tanggal" class="form-control" value="{{$data['now']}}"
                                width="276" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="h4"><u>BARANG</u></label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="h4"><u>PRICE</u></label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="h4"><u>QTY</u></label>
                            </div>
                        </div>
                        <div class="clone">
                            <div class="row input_fields_wrap">
                                <div class="col-md-8 mb-3">
                                    <select class="form-control" name="id_barang[]" required>

                                        <option value="">-- Pilih --</option>
                                        @foreach ($data['barang'] as $opt)
                                        <option value="{{$opt->id_barang}}">{{$opt->barang->code}} |
                                            {{$opt->barang->name}} | STOK :{{$opt->total_stock()}} | Rp
                                            {{number_format($opt->barang->price,2)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="number" name="price[]" value="0" class="form-control" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="text" name="qty[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-12">
                                <a href="#" class="btn btn-danger remove_field">Hapus</a>
                                <button class="btn btn-primary add_field_button">Tambah Barang</button>
                                <button type="submit" class="btn btn-success">Proses</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>