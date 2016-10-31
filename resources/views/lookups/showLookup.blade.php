<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-type" content="text/html; charset=us-ascii">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>IT Utils</title>

    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">





    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js">
    </script>



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
        <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">Back</a>









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


                //This highlghts a row, if there are no assigned faults
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[data.length-1] != '' ) {
                        $(row).addClass( data[data.length-1] );
                    }
                }




            });

            new $.fn.dataTable.FixedHeader( table );
        });



    </script>


