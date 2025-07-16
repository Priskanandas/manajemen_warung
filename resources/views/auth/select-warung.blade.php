<x-app-layout>
    <x-slot name="title">Pilih Warung</x-slot>

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pilih Warung Anda</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($warungs->count() === 0)
                        <div class="alert alert-warning">
                            @if(auth()->user()->hasRole('Admin'))
                                Anda login sebagai Admin dan tidak memiliki warung.
                            @else
                                Anda tidak memiliki warung untuk dipilih.
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('auth.pilih-warung.post') }}">
                            @csrf
                            <select name="warung_id" class="form-control">
                                @foreach($warungs as $warung)
                                    <option value="{{ $warung->id }}">{{ $warung->nama_warung }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Lanjut</button>
                        </form>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
