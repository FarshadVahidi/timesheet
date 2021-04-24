<x-app-layout>

    @section('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
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
                        <div class="m-2">
                            <a href="{{route('users.PDF.index')}}" class="btn btn-info">{{__('print')}}</a>
                        </div>

                        <div class="m-2">
                            <a href="{{route('users.Google.index')}}" class="btn btn-info">{{__('Save on Google Drive')}}</a>
                        </div>
                    </div>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
