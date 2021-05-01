<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                    <form method="POST" name="profileaz" id="profileaz" action="{{route('admins.ProfileOrder.store')}}">

                        <div class="mb-3">
                            <select
                                class="form-text block mt-1 w-full baz-gray-300 focus:baz-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                aria-label="Default select example" name="azienda" id="azienda">
                                <option selected>{{__('Select Aziende')}}</option>
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
