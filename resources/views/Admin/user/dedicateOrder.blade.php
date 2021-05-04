<x-app-layout>

    @section('MyStyles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                @if(!empty($orderWork[0]))
                    <div>
                        <h3>{{$orderWork[0]->user_name}}</h3>
                    </div>

                    <div class="py-12">
                        <h4>{{__('Project work on')}}</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Company Who put order')}}</th>
                            <th scope="col">{{ __('Project Work On') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderWork as $user)
                            <tr>
                                <td>{{$user->aziendaName}}</td>
                                <td>{{ $user->name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <div>
                                            <form action="{{ route('admins.ProfileOrder.destroy', $user->order_id) }}" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <input type="number" name="user_id" id="user_id" value="{{$user->user_id}}" hidden>
                                                <button type="submit" class="btn btn-danger">{{__('Eliminate from this project')}}</button>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
@endif

                    <div class="cal-md-1">
                        <table class="table table-bordered data-table" id="datatable">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Company Who put order')}}</th>
                                <th scope="col">{{ __('Project name') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allOrders as $order)
                                <tr>
                                    <td>{{$order->aziendeName}}</td>
                                    <td>{{$order->order_name}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <div>
                                                <form action="{{ route('admins.ProfileOrder.update', $order->order_id) }}" method="POST">
                                                    @method("PATCH")
                                                    @csrf
                                                    <input type="number" name="user_id" id="user_id" value="{{$user_id}}" hidden>
                                                    <button type="submit" class="btn btn-primary">{{__('add to this project')}}</button>
                                                </form>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endsection
            </div>
        </div>
    </div>


    @section('myScript')
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#datatable').DataTable({
                    responsive: true
                })
            });
        </script>
    @endsection
</x-app-layout>
