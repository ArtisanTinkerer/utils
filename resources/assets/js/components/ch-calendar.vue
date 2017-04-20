<!--https://codepen.io/diemah77/pen/gaRKQq-->

<template>
    <div>
    <div class="col mt-5">
        <div id="calendar"></div>
    </div>





        <div class="modal-mask"  v-show="showmodal"  v-on:click="closemodal" transition="modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                        <h4 class="modal-title"> {{title}}  </h4>
                    </div>

                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</template>

<script>
    require('fullcalendar')

    export default {
        data: function () {
            return {
                showmodal:false,
                title:""

            };
        },
        methods:{
            closemodal: function (event) {

            this.showmodal = false;
        }

        },

        props: ['entrypoint'],
        mounted() {
           let self = this;

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

                 eventClick:  function(event, jsEvent, view) {
                    //title
                    //allday
                    //start
                    //booking_time



                    axios.get('/eventDetails', {
                        params: {

                            entryPoint: self.entrypoint,
                            customer_no: event.title,
                            booking_time:event.booking_time,
                            delivery_date:event.start.format('YYYY-MM-DD')

                        }
                    })
                    .then(function (response) {

                        self.showmodal=true;
                        self.title=event.title;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });



                }


            });

        },//mounted

  }

</script>