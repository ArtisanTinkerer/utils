<template>

    <div class="container">

        <form action="/showLookup" method="get" class="form-horizontal">


    <div class="panel panel-primary">
        <div class="panel-heading" id="panel-head">
            Available Reports
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">

                    <div v-for="report in reportsList">

                        <input type="radio"name="lookup_id" value={{report.id}}   v-model="picked"  v-on:change="radioClicked" > {{report.name}}

                    </div>


                </div>
            </div>
            <br>
        </div>


    </div>






        <div class="panel panel-primary">
            <div class="panel-heading">
                Lookup Parameter
            </div>
            <div id="paramDiv">
                <div class="panel-body">

                    <div v-for="token in tokens">
                        <div class="form-group row">
                            <div class="col-xs-6 col-sm-2">
                                <label for={{token}}>{{token}}</label>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <input type="text" id={{token}} name="tokens[{{token}}]"  v-on:keydown.enter.prevent=''>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>

            <input type="submit" class = "btn btn-primary pull-right" value="Execute">



        </form>

    </div>

</template>


<script>

export default {
    data: function () {
        return {
            picked:0,
            reportsList: [],
            tokens: [],


        };
    },

    methods: {

        radioClicked: function (event) {
            let self = this;

            //Ok. ok

            //I have the SQL
          //  console.log(self.reportsList.find(x => x.id === parseInt(self.picked)).sql);
            //Look through for the tokens, add them to an array key/value pairs
            let sql = self.reportsList.find(x => x.id === parseInt(self.picked)).sql;

            self.tokens = [];


            sql.replace(/\{(.*?)}/g, function(a, b) {
              //tokens.push(b);
               if($.inArray(b, self.tokens) === -1) self.tokens.push(b);
            });

            //console.log(tokens);
           //self.tokens.forEach(self.createField);
        },



        //Display a label and text box (for each token)
        //createField: function (item,index) {
         //   console.log(item);
        //}



    },

mounted: function () {

    console.log('mounted');



    },


    created: function () {




    console.log('created');
        let area = document.URL.substr(document.URL.lastIndexOf('/') + 1);
        console.log(area);

        let self = this;

        axios.get('/getLookups/' + area)
            .then(function (response) {

                self.reportsList = response.data;


            })
            .catch(function (error) {

                console.log(error);

            });

    },

}

</script>
