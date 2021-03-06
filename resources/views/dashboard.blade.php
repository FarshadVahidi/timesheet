<x-app-layout>

    @section('myScript')
        <script>
            var global;
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
                let hour = '' + d.getHours();
                let minutes = '' + d.getMinutes();
                if (hour.length < 2) hour = '0' + hour;
                if (minutes.length < 2) minutes = '0' + minutes;
                let seconds = '' + d.getSeconds();
                if (seconds.length < 2) seconds = '0' + seconds;
                return [year, month, day].join('-') + ' ' + [hour, minutes, seconds].join(':');
            }

            function validateForm() {
                let temp = document.getElementById('ferie').checked;
                if (temp) {
                    document.dayClick.hour.value = 0;
                    return true;
                } else if (document.dayClick.hour.value > 8.0) {
                    alert('Hour must be less than 8 hours!');
                    return false;
                } else if (document.dayClick.hour.value < 0.0) {
                    alert('Hour can not be less than zero!')
                    return false;
                } else {
                    document.getElementById('ferie').value = 0;
                    var x = document.getElementById('hour').value;
                    if(!Number.isInteger(x))
                    {
                        var int_part = Math.floor(x);
                        var fractional = Math.round(x*100) - ( int_part * 100);
                        var min = int_part * 60;
                        var hour = min + fractional;
                        document.getElementById('hour').value = hour;
                    }
                    return true;
                }
            }

            function validateFormUpdate() {
                let temp = document.getElementById('UpFerie').checked;

                if (temp) {
                    document.UpClick.UpHour.value = 0;
                    return true;
                } else if (document.UpClick.UpHour.value > 8.0) {
                    alert('Hour must be less than 8 hours!');
                    return false;
                } else if (document.UpClick.UpHour.value < 0.0) {
                    alert('Hour can not be less than zero!')
                    return false;
                } else {
                    document.getElementById('UpFerie').value = 0;
                    var x = document.getElementById('UpHour').value;
                    if(!Number.isInteger(x))
                    {
                        var int_part = Math.floor(x);
                        var fractional = Math.round(x*100) - ( int_part * 100);
                        var min = int_part * 60;
                        var hour = min + fractional;
                        document.getElementById('UpHour').value = hour;
                    }
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
                        console.log(info);
                        $('#eventId').val(info.event.id);
                        $('#title').val(info.event.extendedProps.title);
                        $('#UpStart').val(convert(info.event.start));
                        let total = info.event.extendedProps.hour;
                        let hour = total / 60;
                        hour = Math.floor(hour);
                        let min = total % 60;
                        let str = hour.toString() + '.' + min.toString();
                        $('#UpHour').val(str);
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
                    <div id="calendar"></div>

                    <div id="dialog">
                        <div id="dialog-body">
                            <form id="dayClick" name="dayClick" method="POST" action="{{ route('users.event.store') }}"
                                  onsubmit="return validateForm()">
                                @csrf


                                <div class="form-check m-3">
                                    <input class="form-check-input" name="ferie" type="checkbox" value="1" id="ferie">
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
                                        <input type="text" class="form-control" id="end" name="end" readonly>
                                    </div>


                                    <div class="input-group flex-nowrap mb-3">
                                        <span class="input-group-text" id="addon-wrapping">{{ __('Hours') }}</span>
                                        <input type="number" step="0.01" id="hour" name="hour" class="form-control" placeholder="number">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">{{__('Description')}}</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           aria-describedby="description">
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
                                <input class="form-check-input" name="UpFerie" type="checkbox" value="1" id="UpFerie">
                                <label class="form-check-label">Ferie</label>
                            </div>

                            <div class="input">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="UpStart" name="UpStart" readonly>
                                </div>


                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">Hours</span>
                                    <input type="number" step="0.01" id="UpHour" name="UpHour" class="form-control" placeholder="number">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       aria-describedby="description">
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
