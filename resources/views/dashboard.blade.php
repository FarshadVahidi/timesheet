<x-app-layout>

    @section('myScript')
        <script>
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
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
