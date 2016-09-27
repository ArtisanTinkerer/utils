@extends('appDatatable')

@section('content')

    <div class="panel-body">

        <div>
            <h1 >{{ $title }}</h1>




        </div>

    </div>


    <div class="panel-body">

        <table style="width:100%" class="table-bordered table-responsive table-striped" id="lookupTable">

            <thead class="thead-inverse">
            <tr>

                @foreach($neatHeaders as $neatHeader )
                    <th>
                        {{ $neatHeader }}

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

                dom: 'Bfrtip',


                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',

                    }, {
                        extend: 'print',
                        title: '{{ $title }}',

                        orientation: 'landscape',
                        

                        },



                    'excelHtml5'

                ]

            });
        });


    </script>

@endsection
