<x-app-layout>
    <x-slot name="title">Harga</x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-card>
        <x-slot name="title">Data Harga Barang</x-slot>
        <x-slot name="option">
            <a href="{{ route('admin.harga.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Harga
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-bordered table-hovered">
                <thead>
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($harga as $i => $h)
                        <tr align="center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $h->barang->nama_barang ?? '-' }}</td>
                            <td>
                                {{ $h->pembelian?->harga_beli ? 'Rp ' . number_format($h->pembelian->harga_beli, 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                {{ $h->harga_jual && $h->harga_jual > 0 
                                    ? 'Rp ' . number_format($h->harga_jual, 0, ',', '.') 
                                    : 'Harga belum di set' }}
                            </td>
                            <td>
                                <span class="badge {{ $h->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($h->status) }}
                                </span>
                            </td>
                            <td>{{ $h->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.harga.edit', $h->id) }}" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-tooltip-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.harga.delete', $h->id) }}"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')"
                                       class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete-forever"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data harga.</td>
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
