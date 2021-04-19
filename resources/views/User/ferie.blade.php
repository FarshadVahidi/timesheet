<x-app-layout>
@section('mainContent')

        <div class="card-header">{{__('Ferie')}}</div>

        <div class="card-body">
            <table class="table table-bordered data-table" id="datatable">
                <thead>
                <tr>
                    <th scope="col">{{ __('Data') }}</th>
                </tr>
                </thead>
                @foreach ($allFerie as $ferie)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($ferie->start)->format('Y F d D')}}</td>
                    </tr>
                @endforeach
                <tbody>
                </tbody>
            </table>
            <div class="">
                <a href="{{route('users.PDF.index')}}" class="btn btn-info">print</a>
            </div>
        </div>
@endsection
</x-app-layout>
