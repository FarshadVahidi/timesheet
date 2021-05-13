<x-app-layout>
    @section('MyStyles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    @endsection
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                    @if(Session::has('message'))
                        <script>
                            swal("OK!", "{!! Session::get('message') !!}", "success",{
                                button:"OK",
                            })
                        </script>
                    @endif

                    @if(Session::has('error'))
                        <script>
                            swal("OOPS!", "{!! Session::get('message') !!}", "error",{
                                button:"OK",
                            })
                        </script>
                    @endif

                    <div class="cal-md-1">
                        <table class="table table-bordered data-table" id="datatable">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('category') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Brand') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->modello }}</td>
                                    <td>{{ $d->marco }}</td>
                                    <td>{{ $d->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endsection
            </div>
        </div>
    </div>


    @section('myScript')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#datatable').DataTable({
                    responsive: true
                })
            });
        </script>
    @endsection
</x-app-layout>


