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
                <tbody>
                    <tr>
                        <td>{{__('There is no ferie for this user')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endsection
</x-app-layout>
