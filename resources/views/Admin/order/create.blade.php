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

                    <form class="row g-3" name="myForm" id="myForm" action="{{ route('admins.Order.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

                        <div class="col-md-6">
                            <lable for="customer" class="form-label">{{__('Select Customer')}}</lable>
                            <select
                                class="form-text block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                name="customer_id" id="customer_id">
                                <option class="disabled">{{__('Select Customer')}}</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('customer') }}
                        </div>

                        <div class="col-md-6">
                            <label for="start" class="form-label">{{__('Start')}}</label>
                            <input type="date" class="form-control" name="start" id="start"  value="{{ old('start')}}">
                        </div>

                        <div class="col-md-6">
                            <label for="end" class="form-label">{{__('End')}}</label>
                            <input type="date" class="form-control" name="end" id="end"  value="{{ old('end')}}">
                        </div>

                        <div class="col-md-6">
                            <label for="days" class="form-label">{{__('Duration')}}</label>
                            <input type="number" class="form-control" name="days" id="days"  value="{{ old('days')}}">
                        </div>

                        <div class="col-md-6">
                            <label for="cost" class="form-label">{{__('Cost')}}</label>
                            <input type="number" class="form-control" name="cost" id="cost" placeholder="$ .00" value="{{ old('cost')}}">
                        </div>

                        <div class="form-group d-flex flex-column py-4">
                            <label for="file" class="py-2 mx-3">{{__('Contract file')}}</label>
                            <input type="file" name="file" id="file" class="py-2 mx-3">
                        </div>

                        @csrf

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                        </div>
                    </form>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
