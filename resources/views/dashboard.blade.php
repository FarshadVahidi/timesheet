<x-app-layout>

    @section('myScript')
        <script>

            $(document).ready(function(){
                $('#ferie').click(function(){
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
                            click: function (events) {

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
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
