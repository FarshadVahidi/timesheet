<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')
                    <div class="row">

                        <div class="col-md-6">
                            <label for="name" class="form-label">{{__('Company Name')}}</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{$order[0]->name}}">
                        </div>

                        <div class="col-md-6">
                            <label for="start" class="form-label">{{__('Start')}}</label>
                            <input type="text" class="form-control" name="start" id="start" value="{{$order[0]->start}}">
                        </div>

                        <div class="col-md-6">
                            <label for="start" class="form-label">{{__('End')}}</label>
                            <input type="text" class="form-control" value="{{$order[0]->end}}">
                        </div>

                        <div class="col-md-6">
                            <label for="days" class="form-label">{{__('Duration')}}</label>
                            <input type="text" class="form-control" value="{{$order[0]->days}}">
                        </div>

                        <div class="col-md-6">
                            <label for="days" class="form-label">{{__('Cost')}}</label>
                            <input type="text" class="form-control" value="{{$order[0]->cost}}">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group d-flex flex-column py-4">
                                <a href="{{route('admins.Order.edit', $order[0]->order_id)}}" class="btn btn-info">{{__('Show Order File')}}</a>
                            </div>
                        </div>
                    </div>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
