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
            return [year, month, day].join('-');
        }

        function validateForm() {
            let temp = document.getElementById('ferie').checked;
            if (temp) {
                document.dayClick.hour.value = 0;
                document.dayClick.title.value = "FERIE";
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
                handleWindowResize: true,
                headerToolbar: {
                    left: 'prev,next today myCustomButton',
                    center: 'title',
                    right: 'dayGridMonth,listWeek',
                },
                events: "{{route('admins.event.index')}}",
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
                    $('#upid').val(info.event.extendedProps.name);
                    $('#uptitle').val(info.event.title);
                    $('#UpStart').val(convert(info.event.start));
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


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')
                <div id="calendar"></div>

                <div class="cal-md-1" id="fill">
                    <form id="fill-form" name="fill-form" method="POST" action="{{route('admins.autofill.update', auth()->user()->id)}}">
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

                <div class="cal-md-1" id="dialog">
                    <div id="dialog-body">
                        <form id="dayClick" name="dayClick" method="POST" action="{{ route('admins.event.store') }}"
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

                <div class="cal-md-1" id="farshad">
                    <form id="UpClick" name="UpClick" method="POST" action="{{ route('admins.event.update', 'eventId') }}"
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
                                <label class="form-check-label">{{__('user')}}</label>
                                <input type="text" class="form-control" id="upid" name="upid" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-check-label">{{__('date')}}</label>
                                <input type="text" class="form-control" id="UpStart" name="UpStart" readonly>
                            </div>


                            <div class="input-group flex-nowrap mb-3">
                                <span class="input-group-text" id="addon-wrapping">Hours</span>
                                <input type="number" id="UpHour" name="UpHour" class="form-control">
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

