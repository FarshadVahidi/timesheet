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

                    @foreach($data as $d)
                    <form class="row g-3" name="myForm" id="myForm"
                          action="{{ route('admins.Cespiti.update', $d->id) }}" method="POST"
                          enctype="multipart/form-d">
                        @method('PATCH')

                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Category')}}</label>
                            <input readonly type="text" class="form-control" value="{{$d->name}}">
                            <br>
{{--                            <select  name="category" id="category" class="form-select" aria-label="Default select example">--}}
{{--                                <option selected disabled>{{ $d->name }}</option>--}}
{{--                                @foreach($category as $c)--}}
{{--                                    <option value="{{ $c->id }}">{{ $c->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
                        </div>

                        <div class="col-md-6">
                            <label for="p_iva" class="form-label">{{__('Brand')}}</label>
                            <input readonly type="text" class="form-control" name="marco" id="marco"
                                   value="{{ old('marco') ?? $d->marco}}">
                        </div>

                        <div class="col-md-6">
                            <label for="p_iva" class="form-label">{{__('SerialNumber')}}</label>
                            <input readonly type="text" class="form-control" name="serialnumber" id="serialnumber"
                                   value="{{ old('serialnumber') ?? $d->serialnumber}}">
                        </div>

                        <div class="col-md-6">
                            <label for="p_iva" class="form-label">{{__('Model')}}</label>
                            <input readonly type="text" class="form-control" name="modello" id="modello"
                                   value="{{ old('modello') ?? $d->modello}}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="p_iva" class="form-label">{{__('Cost')}}</label>
                            <input readonly type="text" class="form-control" name="costo" id="costo"
                                   value="{{ old('costo') ?? $d->costo}}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="p_iva" class="form-label">{{__('Buy On')}}</label>
                            <input readonly type="date" class="form-control" name="acquisto" id="acquisto"
                                   value="{{ old('acquisto') ?? $d->acquisto}}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="howUseIt" class="form-label">{{__('How Use it Now')}}</label>
                            <br>
                            @if($d->user_id !== null)
                            <select name="user" id="user" class="form-select" aria-label="Default select example">
                                <option selected value="{{ $d->userId }}">{{ $d->userName }}</option>
                                @foreach($user as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                                    <option value="-1">{{ __('Free') }}</option>
                            </select>
                                @else
                                <select name="user" id="user" class="form-select" aria-label="Default select example">
                                    <option selected disabled>{{__('Free')}}</option>
                                    @foreach($user as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <br>
                            <select name="status" id="status" calss="form-select" aria-label="Default select example">
                                <option selected disabled>{{ $d->status }}</option>
                                @foreach($status as $s)
                                    <option value="{{$s->id}}">{{ $s->status }}</option>
                                @endforeach
                            </select>
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group d-flex flex-column py-4">--}}
{{--                                <label for="file" class="py-2 mx-3">{{__('Upload New Contract File')}}</label>--}}
{{--                                <input type="file" name="file" id="file" class="py-2 mx-3">--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        @csrf

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                        </div>
                    </form>
                        @endforeach
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>

