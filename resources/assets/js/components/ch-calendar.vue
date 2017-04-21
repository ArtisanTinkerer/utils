<!--https://codepen.io/diemah77/pen/gaRKQq-->

<template>
    <div>
    <div class="col mt-5">
        <div id="calendar"></div>
    </div>


        <div class="modal-mask"  v-show="showModal"  v-on:click="closeModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="white">×</span> <span class="sr-only">close</span></button>
                        <h4 class="modal-title"> {{title}}  </h4>
                    </div>

                    <div class="modal-body">
                        <table style="width:100%">

                            <tr>
                                <th v-for="detailHeader in detailHeaders">
                                    {{detailHeader}}
                                </th>
                            </tr>

                            <tr v-for="detailRow in detailRows">
                                <td v-for="field in detailRow">
                                    {{field}}
                                </td>
                            </tr>
                        </table>
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
                showModal:false,
                title:"",
                detailRows:[],
                detailHeaders:[]

            };
        },
        methods:{
            closeModal: function (event) {

            this.showModal = false;
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

                    axios.get('/eventDetails', {
                        params: {

                            entryPoint: self.entrypoint,
                            customer_no: event.title,
                            booking_time:event.booking_time,
                            delivery_date:event.start.format('YYYY-MM-DD')

                        }
                    })
                    .then(function (response) {

                        self.showModal=true;
                        self.title=event.title;
                        self.detailRows = response.data;
                        //get the columns, replace the _
                        self.detailHeaders = Object.keys(response.data[0]).map(function(x){return capitalizeFirstLetter(x.replace('_', ' '));});


                    })
                    .catch(function (error) {
                        console.log(error);
                    });



                }


            });

        },//mounted

  }

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


</script>