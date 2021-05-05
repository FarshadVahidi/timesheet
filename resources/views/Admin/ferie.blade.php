<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

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
                            @foreach ($allFerie as $ferie)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($ferie->start)->format('Y F d D')}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="mb-3">
                            <a href="{{route('admins.PDF.show', $ferie->user_id)}}" class="btn btn-info">print</a>
                        </div>

                        <div class="mb-3">
                            <a href="{{route('admins.PDF.edit', $ferie->user_id)}}" class="btn btn-info">print year</a>
                        </div>
                    </div>
                @endsection
            </div>
        </div>
    </div>

</x-app-layout>
