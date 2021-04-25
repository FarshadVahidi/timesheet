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

                    <form class="row g-3" name="myforlm" action="{{ route('admins.Company.store') }}" method="POST" onsubmit="return validateForm()">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Company Name')}}</label>
                            <input type="text" class="form-control" name="name" id="name" required="required" value="{{ old('name')}}">
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Company P.IVA')}}</label>
                            <input type="text" class="form-control" name="piva" id="piva" required="required" value="{{ old('piva')}}">
                        </div>

                        <div class="form-group d-flex flex-column">
                            <label for="file" class="py-2">{{__('Contract file')}}</label>
                            <input type="file" name="contract" id="contract" class="py-2">
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

    @section('myScript')
        <script>
            function validateForm() {
                let name = document.myform.name.value;
                let piva = document.myform.piva.value;
                if (name.length > 50) {
                    alert('name can not be too long!');
                    return false;
                }
                if (name === "") {
                    alert('name required!');
                    return false;
                }
                if (piva === "") {
                    alert('P.Iva required!');
                    return false;
                }
                if(!piva.length === 10)
                {
                    alert('Chack P.Iva')
                    return false;
                }
                return true;

            }
        </script>
    @endsection

</x-app-layout>
