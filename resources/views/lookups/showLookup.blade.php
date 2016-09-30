@extends('appDatatable')

@section('content')

    <div class="panel-body">

        <div>
            <h1 >{{ $title }}</h1>




        </div>

    </div>


    <div class="panel-body">

        <table class="table table-responsive" id="lookupTable">
        {{--<table style="width:100%" class="table-bordered table-responsive table-striped" id="lookupTable">--}}

            <thead class="thead-inverse">
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

    </div>







@endsection

@section('js')
    <script>

        $(document).ready(function () {
            var table = $('#lookupTable').DataTable({


                "columnDefs": [
                    {
                        "targets": [ -1 ],
                        "visible": false,
                        "searchable": false
                    }

                ],

                dom: 'Bfrtip',


                buttons: [
                {
                        extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    },
                        title: '{{ $title }}',

                        orientation: 'landscape',

                        }



                ],


                //This highlghts a row, if there are no assigned faults
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[data.length-1] != '' ) {
                        $(row).addClass( data[data.length-1] );
                    }
                }




            });
        });


    </script>

@endsection
