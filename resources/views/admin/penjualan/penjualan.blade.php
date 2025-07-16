<x-app-layout>
    <x-slot name="title">
        penjualan
    </x-slot>

    @if(session()->has('success'))
    <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif
    <x-card>
        <x-slot name="title">All Penjualan</x-slot>
<x-slot name="option">
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.pembayaran') }}" class="btn btn-success mr-2">
            <i class="fas fa-plus"></i>
        </a>
        
        <a href="{{ route('admin.penjualan.rekap') }}" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Rekap
        </a>
    </div>
</x-slot>

        <form class="form-barang">
                    @csrf
                    <div class="form-group row">
                        <label for="kd_barang" class="col-lg-2">Kode Barang</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <input type="text" class="form-control" name="kd_barang" id="kd_barang">
                                <span class="input-group-btn">
                                    <button onclick="tampilbarang()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
        <table class="table table-bordered">
            <thead>
                <tr align="center">
                    <th >No</th>
                    <th >Barang</th>
                    <th>Pelayan</th>
                    <th>Satuan</th>
                    <th >Tanggal Jual </th>
                    <th>Harga</th>
                    <th >Jumlah</th>
                    <th>Total Harga</th>
                    <th >Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan as $p)
                <tr  align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $p->pembayaran->pelayan->name ?? '-' }}</td> {{-- jika pelayan adalah user --}}
Z                    <td >{{ $p->satuan }}</td>
                    <td >{{ $p->tanggal }}</td>
                    <td>{{ 'Rp ' . number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td >{{ $p->jml_beli }}</td>
                    <td>{{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}</td>

                    <td >
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('admin.penjualan.edit',[$p->id]) }}" class="btn btn-warning btn-sm">Edit
                                <i class="mdi mdi-tooltip-edit"></i>
                            </a>
                            <a href="{{ route('admin.penjualan.delete',[$p->id]) }}"
                                onclick="return confirm('Yakin Hapus data')" class="btn btn-danger btn-sm">Hapus
                                <i class="mdi mdi-delete-forever"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    	</x-card>


        <x-slot name="script">
            <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
        </x-slot>
</x-app-layout>

