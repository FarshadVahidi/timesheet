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

                    <form class="row g-3" name="myForm" id="myForm" method="POST"
                          action="{{route('admins.Order.update', $order[0]->order_id)}}" enctype="multipart/form-data">
                        @method('PATCH')

                        <input type="number" name="customer_id" id="customer_id" value="{{$order[0]->customer_id}}" hidden>

                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Company Name')}}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   value="{{$order[0]->name}}" readonly disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="ordername" class="form-label">{{__('Order Name')}}</label>
                            <input type="text" class="form-control" name="orderName" id="orderName"
                                   value="{{$order[0]->orderName}}" readonly disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="start" class="form-label">{{__('Start')}}</label>
                            <input type="date" class="form-control" name="start" id="start"
                                   value="{{ old('start') ?? $order[0]->start}}">
                        </div>

                        <div class="col-md-6 my-2">
                            <label for="start" class="form-label">{{__('End')}}</label>
                            <input type="date" class="form-control" name="end" id="end"
                                   value="{{ old('end') ?? $order[0]->end}}">
                        </div>

                        <div class="col-md-6 my-2">
                            <label for="days" class="form-label">{{__('Duration')}}</label>
                            <input type="text" class="form-control" name="days" id="days"
                                   value="{{ old('days') ?? $order[0]->days}}">
                        </div>

                        <div class="col-md-6">
                            <label for="cost" class="form-label">{{__('Cost')}}</label>
                            <input type="number" class="form-control" name="cost" id="cost"
                                   value="{{ old('cost') ?? $order[0]->cost}}">
                        </div>

                        <div class="col-md-6 py-2">
                            <div class="form-group d-flex flex-column py-4">
                                <a href="{{route('admins.Order.edit', $order[0]->order_id)}}"
                                   class="btn btn-info">{{__('Show Order File')}}</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group d-flex flex-column">
                                <label for="file" class="mx-3">{{__('Upload New Contract File')}}</label>
                                <input type="file" name="file" id="file" class="py-2 mx-3">
                            </div>
                        </div>

                        @csrf

                        <div class="col-md-2">
                            <div class="form-group d-flex flex-column">
                                <button type="submit" class="btn btn-primary">{{__('Update Order')}}</button>
                            </div>
                        </div>
                    </form>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
