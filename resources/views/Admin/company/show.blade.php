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

                    <form class="row g-3" name="myForm" id="myForm" action="{{ route('admins.Company.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Company Name')}}</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{ old('name')?? $company->name}}">
                        </div>

                        <div class="col-md-6">
                            <label for="p_iva" class="form-label">{{__('Company P.IVA')}}</label>
                            <input type="text" class="form-control" name="p_iva" id="p_iva"  value="{{ old('p_iva') ?? $company->p_iva}}">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group d-flex flex-column py-4">
                                <a href="{{route('admins.Contract.show', $company->id)}}" class="btn btn-info">{{__('Show Contract')}}</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group d-flex flex-column py-2">
                                <label for="file" class="py-2 mx-3">{{__('Upload New Contract File')}}</label>
                                <input type="file" name="file" id="file" class="py-2 mx-3">
                            </div>
                        </div>


                        @csrf

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                        </div>
                    </form>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
