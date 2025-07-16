<x-app-layout>
    <x-slot name="title">
        Pembelian
    </x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-card>
        <x-slot name="title">Data Pembelian</x-slot>
        <x-slot name="option">
            <a href="{{ route('admin.pembelian.tambah') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Beli</th>
                        <th>Satuan</th>
                        <th>Jumlah Beli</th>
                        <th>Harga Beli</th>
                        <th>Subtotal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelian as $p)
                        <tr align="center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $p->barang->satuan ?? '-' }}</td>
                            <td>{{ $p->jml_beli }}</td>
                            <td>
                                {{ 'Rp ' . number_format($p->harga_beli, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ 'Rp ' . number_format($p->subtotal ?? 0, 0, ',', '.') }}
                            </td>


                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.pembelian.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-tooltip-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.pembelian.delete', $p->id) }}"
                                       onclick="return confirm('Yakin Hapus data?')" class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete-forever"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pembelian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <x-slot name="script">
        <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
    </x-slot>
</x-app-layout>
