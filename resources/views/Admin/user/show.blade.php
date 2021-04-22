<x-app-layout>

    @section('MyStyles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')


                    <table class="table table-bordered data-table" id="datatable">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('start') }}</th>
                            <th scopt="col">{{__('title')}}</th>
                            <th scope="col">{{ __('hour') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allHour as $hour)
                            <tr>
                                <td>{{ $hour->start }}</td>
                                <td>{{ $hour->title }}</td>
                                <td id="hour">{{ $hour->hour}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @endsection


    @section('myScript')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#datatable').DataTable({})
            });

        </script>
    @endsection
            </div>
        </div>
    </div>
</x-app-layout>
