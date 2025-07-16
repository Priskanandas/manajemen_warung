<x-app-layout>
    <x-slot name="title">Barang</x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-card>
        <x-slot name="title">Data Barang</x-slot>

        <x-slot name="option">
            <a href="{{ route('admin.barang.tambah') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </x-slot>

        <div class="row mb-3">
            <div class="col">
                <form class="form-inline" method="GET" action="{{ route('admin.barang.cari') }}">
                    <div class="input-group">
                        <select name="cari" class="form-control">
                            <option value="" selected disabled>== Pilih Kategori ==</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Cari</button>
                            <a class="btn btn-outline-primary" href="{{ route('admin.barang') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hovered">
                <thead class="thead-light">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $i => $b)
                        <tr align="center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $b->kd_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->satuan }}</td>
                            <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                            <td>
                                @if ($b->stok <= 0)
                                    <span class="badge badge-danger">Stok Habis</span>
                                @else
                                    {{ $b->stok }}
                                @endif
                            </td>


                            <td>
                                {{ $b->hargaBeliTerakhir ? 'Rp ' . number_format($b->hargaBeliTerakhir, 0, ',', '.') : 'Belum ada harga' }}

                            </td>
                            <td>
                                {{ $b->hargaAktif?->harga_jual ? 'Rp ' . number_format($b->hargaAktif->harga_jual, 0, ',', '.') : 'Belum ada harga' }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.barang.edit', $b->id) }}" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-tooltip-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.barang.delete', $b->id) }}"
                                       onclick="return confirm('Yakin ingin menghapus?')" 
                                       class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete-forever"></i> Hapus
                                    </a>
                                    <a href="{{ route('admin.harga', $b->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-dollar-sign"></i> Atur Harga
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data barang.</td>
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
