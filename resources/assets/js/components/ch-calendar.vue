<!--https://codepen.io/diemah77/pen/gaRKQq-->

<template>
    <div class="col mt-5">
        <div id="calendar"></div>
    </div>
</template>

<script>
    require('fullcalendar')

    export default {
        mounted() {

            $('#calendar').fullCalendar({
            header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			locale: 'en',

			events: [
				{
					title: 'All Day Event',
					start: '2017-04-09'
				}

				],

            weekends:true,
			defaultView: 'basicWeek',

                 eventClick: function() {
                alert('event has been clicked!');
               }
});


        },


        events: {
             'day::clicked': function(date)
            {
            console.log(date);
            }
  }
    }
</script>