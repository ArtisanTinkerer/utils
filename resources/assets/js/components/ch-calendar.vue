<!--https://codepen.io/diemah77/pen/gaRKQq-->

<template>
    <div class="col mt-5">
        <div id="calendar"></div>
    </div>
</template>

<script>
    require('fullcalendar')

    export default {
        props: ['entrypoint'],
        mounted() {

            $('#calendar').fullCalendar({
            header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			locale: 'en',

			 events: {
                url: '/fetchEvents',
                type: 'GET',
                data: {
                    entryPoint: this.entrypoint,

                },
                error: function() {
                alert('there was an error while fetching events!');
                },
                color: 'yellow',   // a non-ajax option
                textColor: 'black' // a non-ajax option
            },//events

            weekends:true,
			defaultView: 'basicWeek',
                 eventClick: function() {
                    alert('event has been clicked!');
                 }
            });

        }//mounted
  }

</script>