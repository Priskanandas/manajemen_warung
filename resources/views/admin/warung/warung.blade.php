<x-app-layout>
    <x-slot name="title">
        Warung
    </x-slot>

    @if(session()->has('success'))
    <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif
    <x-card>
        <x-slot name="title">All Warung</x-slot>
        <x-slot name="option">
            <a href="{{ route('admin.warung.tambah') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
            </a>
        </x-slot>

        <table class="table table-bordered">
            <thead>
                <tr align="center">
                    <th width="5%">No</th>
                    <th>Nama Warung</th>
                    <th>Alamat</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($warung as $wrg)
                    <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $wrg->nama_warung }}</td>
                    <td>{{ $wrg->alamat }}</td>
                    <td class="text-center">

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('admin.warung.edit',[$wrg->id]) }}" class="btn btn-warning btn-sm">Edit
                                <i class="mdi mdi-tooltip-edit"></i>
                            </a>
                            <form action="{{ route('admin.warung.delete', $wrg->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus <i class="mdi mdi-delete-forever"></i></button>
                            </form>

                        </div>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada warung tersedia.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
        <div class="mt-3">
    {{ $warung->links() }}
</div>

    	</x-card>


        <x-slot name="script">
            <script src="{{ asset('dist/js/demo/chart-area-demo.js') }}"></script>
        </x-slot>
</x-app-layout>