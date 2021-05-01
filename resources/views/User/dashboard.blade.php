<x-app-layout>

    @section('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
        <script>

            $(document).ready(function(){
                $('#ferie').click(function(){
                    $('.input').slideToggle();
                });

                $('#UpFerie').click(function(){
                    $('.input').slideToggle();
                });
            });

            function convert(str) {
                const d = new Date(str);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                let year = '' + d.getFullYear();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                return [year, month, day].join('-') ;
            }

            function validateForm() {
                let temp = document.getElementById('ferie').checked;
                if(temp){
                    document.dayClick.hour.value = 0;
                    document.dayClick.title.value = "FERIE";
                    return true;
                }


                let pro = document.dayClick.selectId.value;
                if(pro.toString() === "notSelect"){
                    alert('you must select project to enter');
                    return false;
                }else {
                    let hor = document.dayClick.hour.value;
                        if(hor.trim() === ''){
                            alert('please enter hour')
                            return false;
                        }else if(document.dayClick.hour.value > 8.0 || document.dayClick.hour.value <= 0.0){
                            alert('Hour must be less than 8.0 and more than 0.0');
                            return false;
                        }else{
                            let tit = document.dayClick.title.value;
                            let t = pro.toString()+"-"+tit.toString();
                            document.dayClick.title.value = t;
                            return true;
                        }

                }
            }

            function validateFormUpdate() {
                let temp = document.getElementById('UpFerie').checked;

                if (temp) {
                    document.UpClick.UpHour.value = 0;
                    document.UpClick.uptitle.value = "FERIE";
                    return true;
                } else if (document.UpClick.UpHour.value > 8.0) {
                    alert('Hour must be less than 8 hours!');
                    return false;
                } else if (document.UpClick.UpHour.value < 0.0) {
                    alert('Hour can not be less than zero!')
                    return false;
                } else {
                    document.getElementById('UpFerie').value = false;
                    return true;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    timeZone: 'local',
                    locale: 'it',
                    firstDay: 1,
                    headerToolbar: {
                        left: 'prev,next today myCustomButton',
                        center: 'title',
                        right: 'dayGridMonth,listWeek',
                    },
                    events: "{{route('users.event.index')}}",
                    eventDisplay: 'block',
                    displayEventTime: true,
                    selectable: true,

                    customButtons: {
                        myCustomButton: {
                            text: 'fill this month',
                            click: function () {
                                $('#monthStart').val(convert(calendar.view.currentStart));
                                $('#monthEnd').val(convert(calendar.view.currentEnd));
                                $('#fill').dialog({
                                    draggable: true,
                                    resizable: false,
                                    position: 'center',
                                    model: true,
                                    show: {effect: 'clip', duration: 350},
                                    hide: {effect: 'clip', duration: 350},
                                })
                            }
                        }
                    },
                    select: function (info) {
                        $('#start').val(convert(info.start));
                        $('#end').val(convert(info.end - 1));

                        $('#dialog').dialog({
                            title: 'Add Hour',
                            draggable: true,
                            resizable: false,
                            position: 'center',
                            model: true,
                            show: {effect: 'clip', duration: 350},
                            hide: {effect: 'clip', duration: 350},
                        })
                    },
                    eventClick: function (info) {
                        $('#eventId').val(info.event.id);
                        $('#uptitle').val(info.event.title);
                        $('#UpStart').val(convert(info.event.start));
                        // $('#UpselectId').val(info.event.extendedProps.);
                        $('#UpHour').val(info.event.extendedProps.hour);
                        $('#update').html('Update');

                        $('#farshad').dialog({
                            title: 'Update Hour',
                            draggable: true,
                            resizable: false,
                            position: 'center',
                            model: true,
                            show: {effect: 'clip', duration: 350},
                            hide: {effect: 'clip', duration: 350},
                        })
                    },
                });
                calendar.render();
            });
        </script>

    @endsection

    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
    {{--            {{ __('Dashboard') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}

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
                            swal("OOPS!", "{!! Session::get('error') !!}", "error",{
                                button:"OK",
                            })
                        </script>
                    @endif

                    <div id="calendar"></div>

                    <div id="fill">
                        <form id="fill-form" name="fill-form" method="POST" action="{{route('users.autofill.update', auth()->user()->id)}}">
                            @csrf
                            @method('PATCH')
                            <div class="input">
                                <label>{{__('You want to fill this month?')}}</label>
                                <input name="monthStart" id="monthStart" hidden>
                            </div>

                            <div class="input">
                                <input name="monthEnd" id="monthEnd" hidden>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </form>
                    </div>

                    <div id="dialog">
                        <div id="dialog-body">
                            <form id="dayClick" name="dayClick" method="POST" action="{{ route('users.event.store') }}"
                                  onsubmit="return validateForm()">
                                @csrf


                                <div class="form-check m-3">
                                    <input class="form-check-input" name="ferie" type="checkbox" value={{true}} id="ferie">
                                    <label class="form-check-label">{{ __('Ferie') }}</label>
                                </div>

                                <div class="form-check m-3" hidden>
                                    <input class="form-check-input" name="allDay" type="checkbox" value="1" id="allDay"  checked>
                                    <label class="form-check-label">{{__('allDay')}}</label>
                                </div>

                                <div class="input">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="start" name="start" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-3">{{__('project')}}</label>
                                        <select class="mb-3" aria-label="Default select example" name="selectId" id="selectId">
                                            <option value="notSelect" selected disabled>{{__('select project')}}</option>
                                            @foreach($project as $p)
                                                <option value="{{$p->order_id}}">{{$p->name}}</option>
                                            @endforeach
                                            <button onclick="addOption()">{{__('Add project')}}</button>
                                            <script type="text/javascript">
                                                function addOption(){
                                                    optionText='New element';
                                                    optionValue='newElement';
                                                    $('#selectId').append('<option value="${optionValue}">${optionText}</option>');
                                                }
                                            </script>
                                        </select>
                                    </div>


                                    <div class="input-group flex-nowrap mb-3">
                                        <span class="input-group-text" id="addon-wrapping">{{ __('Hours') }}</span>
                                        <input type="number" step="0.01" id="hour" name="hour" class="form-control" placeholder="number">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{__('Description')}}</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               aria-describedby="description">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                            </form>
                        </div>
                    </div>

                    <div id="farshad">
                        <form id="UpClick" name="UpClick" method="POST" action="{{ route('users.event.update', 'eventId') }}"
                              onsubmit="return validateFormUpdate()">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" id="eventId" name="eventId">

                            <div class="form-check m-3">
                                <input class="form-check-input" name="UpFerie" type="checkbox" value={{true}} id="UpFerie">
                                <label class="form-check-label">Ferie</label>
                            </div>

                            <div class="input">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="UpStart" name="UpStart" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-3">{{__('project')}}</label>
                                    <select class="mb-3" aria-label="Default select example" name="UpselectId" id="UpselectId">
                                        <option selected disabled>{{__('select project')}}</option>
                                        @foreach($project as $p)
                                            <option value="{{$p->order_id}}">{{$p->name}}</option>
                                        @endforeach
                                        <button onclick="addOption()">{{__('Add project')}}</button>
                                        <script type="text/javascript">
                                            function addOption(){
                                                optionText='New element';
                                                optionValue='newElement';
                                                $('#selectId').append('<option value="${optionValue}">${optionText}</option>');
                                            }
                                        </script>
                                    </select>
                                </div>


                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">Hours</span>
                                    <input type="number" step="0.01" id="UpHour" name="UpHour" class="form-control" placeholder="number">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" id="uptitle" name="uptitle"
                                           aria-describedby="description">
                                </div>
                            </div>



                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
