<x-app-layout>
    @section('mainContent')
        <div class="card-header">{{__('Report')}}</div>

        <div class="card-body">
            <table class="table table-bordered data-table" id="datatable">
                <thead>
                <tr>
                    <th scope="col">{{ __('Month') }}</th>
                    <th scopt="col">{{__('hour')}}</th>
                    <th scope="col">{{ __('day') }}</th>
                </tr>
                </thead>
                @foreach ($alldata as $data )
                    <tr>
                        <td>{{\Carbon\Carbon::parse($data->month)->format('F Y')}}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->amount / 8}}</td>
                    </tr>
                @endforeach
                <tbody>
                </tbody>
            </table>
        </div>

    @endsection
</x-app-layout>
