<x-app-layout>
    <x-slot name="title">
        Pembelian
    </x-slot>

    @if(session()->has('success'))
    <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif
    <x-card>
        <x-slot name="title">All Pembelian</x-slot>
        <x-slot name="option">
            <a href="{{ route('admin.pembelian.tambah') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
            </a>
        </x-slot>

        <table class="table table-bordered">
            <thead>
                <tr align="center">
                    <th width="5%">ID</th>
                    <th >Nama Barang</th>
                    <th >Tanggal Beli</th>
                    <th >Jumlah Beli</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian as $p)
                <tr  align="center">
                    <td>{{ $p->id }}</td>
                    <td >{{ $p->nama_barang }}</td>
                    <td >{{ $p->tanggal_beli }}</td>
                    <td >{{ $p->jml_beli }}</td>
                    <td >
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('admin.pembelian.edit',[$p->id]) }}" class="btn btn-warning btn-sm">Edit
                                <i class="mdi mdi-tooltip-edit"></i>
                            </a>
                            <a href="{{ route('admin.pembelian.delete',[$p->id]) }}"
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

