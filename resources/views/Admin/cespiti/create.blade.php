<x-app-layout>
    @section('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
                integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
                crossorigin="anonymous"></script>
    @endsection


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                    @if(Session::has('message'))
                        <script>
                            swal("OK!", "{!! Session::get('message') !!}", "success", {
                                button: "OK",
                            })
                        </script>
                    @endif

                    @if(Session::has('error'))
                        <script>
                            swal("OOPS!", "{!! Session::get('error') !!}", "error", {
                                button: "OK",
                            })
                        </script>
                    @endif

                        <form class="row g-3" name="myForm" id="myForm"
                              action="{{ route('admins.Cespiti.store') }}" method="POST">

                            <div class="col-md-6">
                                <label for="name" class="form-label">{{__('Category')}}</label>
                                <br>
                                <select name="category" id="category" class="form-select"
                                        aria-label="Default select example">
                                    <option selected disabled>{{ __('Category') }}</option>
                                    @foreach($categori as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">{{__('Status')}}</label>
                                <br>
                                <select name="status" id="status" class="form-select"
                                        aria-label="Default select example">
                                    <option selected disabled>{{ __('Status') }}</option>
                                    @foreach($status as $c)
                                        <option value="{{ $c->id }}">{{ $c->status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="p_iva" class="form-label">{{__('Brand')}}</label>
                                <input type="text" class="form-control" name="marco" id="marco">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="p_iva" class="form-label">{{__('SerialNumber')}}</label>
                                <input type="text" class="form-control" name="serialnumber" id="serialnumber">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="p_iva" class="form-label">{{__('Model')}}</label>
                                <input  type="text" class="form-control" name="modello" id="modello">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="p_iva" class="form-label">{{__('Cost')}}</label>
                                <input type="text" class="form-control" name="costo" id="costo">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="p_iva" class="form-label">{{__('Buy On')}}</label>
                                <input type="date" class="form-control" name="acquisto" id="acquisto">
                            </div>

                            @csrf

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                            </div>
                        </form>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>


