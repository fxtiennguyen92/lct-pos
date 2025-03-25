@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Schedule') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item active">{{ __('Schedule') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    <link href="dist/fullcalendar/fullcalendar.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="dist/fullcalendar/fullcalendar.js"></script>
    <script src="dist/fullcalendar/locales-all.global.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    center: 'title',
                    left: 'prev,next',
                    right: 'today',
                },
                initialView: 'listWeek',
            locale: @json(str_replace('_', '-', app()->getLocale())),
                initialDate: new Date(),
                navLinks: false,
                editable: false,
                dayMaxEvents: false,
                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                },


                events: [{
                        title: 'Mrs Avant',
                        start: '2025-03-07T10:00:00',
                        end: '2025-03-07T12:00:00',
                        extendedProps: {
                            department: 'BioChemistry'
                        },
                        description: 'Lecture',
                    },
                    {
                        title: 'Repeating Event',
                        start: '2025-03-09T16:00:00'
                    },
                    {
                        title: 'Repeating Event',
                        start: '2025-03-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2025-03-11',
                        end: '2025-03-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2025-03-12T10:30:00',
                        end: '2025-03-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2025-03-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2025-03-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2025-03-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2025-03-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2025-03-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2025-03-28'
                    }
                ],
            });

            calendar.render();
        });
    </script>
@endpush
