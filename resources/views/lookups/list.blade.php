@extends('appDatatable')

@section('head')

@endsection

@section('content')
    <div class="container">
        {!! Form::open(array('url' => 'showLookup', 'method' => 'POST', 'class' => 'form-horizontal')) !!}

        <div class="panel panel-primary">
            <div class="panel-heading" id="panel-head">
                Available Reports
            </div>
            <div class="panel-body">

                <div class="row">


                    <div class="col-sm-3">
                        @foreach($lookups as $lookup)
                            <div>
                                <input type="radio" name="lookup_id" value="{{ $lookup->id }}"> {{ $lookup->name }}
                            </div>
                        @endforeach
                    </div>



                </div>


                <br>




            </div>
            <div class="panel-body">
                @include('errors.errorMessage')
            </div>


        </div>





        <div class="panel panel-primary">
            <div class="panel-heading">
                Lookup Parameter
            </div>
            <div id="paramDiv">
                <div class="panel-body">

                    <div class="form-group row">
                        <div class="col-xs-6 col-sm-2">

                            {!! Form::label('param', 'Parameter ', ['class' => 'form-control-label']) !!}
                        </div>

                        <div class="col-xs-6 col-sm-2">
                            {!!  Form::text('parameter', '5ADA50051',['class' => 'form-control','multiple' => 'multiple','id' => 'streams']) !!}
                        </div>
                    </div>

                </div>

            </div>
        </div>-






        {!!  Form::submit('Execute', array('class' => 'btn btn-primary pull-right')) !!}
        {!!Form::close()!!}
    </div>


    {{--This needs to be here--}}

@endsection

@section('js')
    <script>







    </script>

@endsection