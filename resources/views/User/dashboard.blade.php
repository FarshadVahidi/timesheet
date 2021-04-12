<x-app-layout>
    @section('myScript')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth'
                });
                calendar.render();
            });
        </script>

    @endsection

    @section('mainContent')
        <div id="calendar"></div>
    @endsection
</x-app-layout>
