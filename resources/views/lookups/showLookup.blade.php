<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-type" content="text/html; charset=us-ascii">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>IT Utils</title>

    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">

</head>

<body>

                <table id="lookupTable" class="display responsive nowrap" cellspacing="0" width="100%">

        {{--<table style="width:100%" class="table-bordered table-responsive table-striped" id="lookupTable">--}}

            <thead>
            <tr>
                {{--This is the column headers--}}
                @foreach($neatHeaders as $neatHeader )
                    <th>
                        @if($neatHeader != 'Row Highlight') {{--Skip this one, it's just used to add--}}
                        {{ $neatHeader }}
                        @endif

                    </th>
                @endforeach

            </tr>
            </thead>




            @foreach($results as $result )

                @if( $result->$headers[0] == "{TOTAL_TOKEN}" )
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong> -- </strong></td>

                        @for ($column = 2; $column < count($headers); $column++)
                            <td>

                                @if($columnFormatting[$column]=='int')

                                    <strong>{{ number_format(intval($result->$headers[$column]))   }}</strong>

                                @elseif($columnFormatting[$column]=='real')

                                    <strong>{{ number_format(floatval($result->$headers[$column]),2)   }}</strong>
                                @endif

                            </td>
                        @endfor

                    </tr>

                    <tr class="blank_row">
                        @for ($column = 0; $column < count($headers); $column++)
                            <td>  </td>
                        @endfor
                    </tr>

                @else



                    {{--Not a total--}}

                <tr>
                    @for ($column = 0; $column < count($headers); $column++)

                        <td>
                            {{ $result->$headers[$column] }}
                        </td>

                    @endfor
                </tr>

                @endif
            @endforeach

        </table>


        <br>
        {{--<a href="/lookups" class="btn btn-primary pull-right">Back</a>--}}


                <button onclick="window.location='{{ url("lookups/back") }}'" class="pull-right btn-primary">Back</button>


                <script src="{{ elixir('js/all.js') }}"></script>
                {{--<script src="{{ elixir('js/app.js') }}"></script>--}}

</body>

</html>

    <script>

        $(document).ready(function () {
            var table = $('#lookupTable').DataTable({

                responsive: true,
                "paging":   false,
                "bFilter":   false,

                "columnDefs": [
                    {
                        "targets": [ -1 ],
                        "visible": false,
                        "searchable": false
                    }

                ],


                //This adds the Bootstrap alert class, if there is one in the last column
                "createdRow": function( row, data, dataIndex ) {
                    console.log(data);
                    if ( data[data.length-1] != '' ) {
                        $(row).addClass( data[data.length-1] );
                    }
                }




            });

            new $.fn.dataTable.FixedHeader( table );
        });



    </script>


