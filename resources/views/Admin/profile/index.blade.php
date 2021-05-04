<x-app-layout>

    @section('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                    @if(Session::has('error'))
                        <script>
                            swal("OOPS!", "{!! Session::get('error') !!}", "error", {
                                button: "OK",
                            })
                        </script>
                    @endif

                    <form method="POST" name="profileaz" id="profileaz" action="{{route('admins.ProfileOrder.store')}}">

                        <div class="mb-3">
                            <label class="">{{__('Select azienda')}}</label>
                            <select
                                class="form-text block mt-1 w-full baz-gray-300 focus:baz-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                aria-label="Default select example" name="azienda" id="azienda">
                                <option disabled selected>{{__('Aziende')}}</option>
                                @foreach($aziende as $az)
                                    <option value="{{$az->id}}">{{$az->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        @csrf

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                @endsection
            </div>
        </div>
    </div>

</x-app-layout>
