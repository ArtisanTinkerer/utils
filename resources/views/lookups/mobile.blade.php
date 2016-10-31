

<!DOCTYPE html>
<html>
<head>



    <meta charset="utf-8">
    <title>IT Utility</title>

    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Include the compiled Ratchet CSS -->
    <link href="/css/ratchet.css" rel="stylesheet">

    <!-- Include the compiled Ratchet JS -->
    <script src="/js/ratchet.js"></script>

    {{--<link rel="stylesheet" type="text/css" href="/css/ratchet-theme-android.css">--}}
</head>
<body>
{!! Form::open(array('url' => 'showLookup', 'method' => 'POST', 'class' => 'form-horizontal','id' => 'formUtils')) !!}

<!-- Make sure all your bars are the first things in your <body> -->
<header class="bar bar-nav">
    <h1 class="title">IT Lookup Utility</h1>
</header>

<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
<div class="content">

    <div class="card">

        <div class="table-view-cell table-view-divider">Parameter</div>
        {!!  Form::text('parameter', null,['class' => 'form-control required','multiple' => 'multiple','id' => 'streams']) !!}

        {{--<button name="execute" class="btn btn-positive btn-block">Run Report</button>--}}
    </div>



    <div class="card">
        @foreach($lookups as $lookup)
            <button onclick="submitReport({{ $lookup->id }})" name="{{ $lookup->id }}" class="btn btn-primary btn-block">{{ $lookup->name }}</button>
        @endforeach
    </div>{{--end of card--}}




    {!!  Form::hidden('lookup_id', null,['class' => 'form-control','id' => 'lookup_id']) !!}




</div>

</body>
</html>


<script
        src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
        crossorigin="anonymous"></script>



<script>


    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });




    function submitReport($reportID){




        $("#lookup_id").val($reportID);

        //now just submit
        document.getElementById("formUtils").submit();


    }


    </script>

























            --}}{{--    @include('errors.errorMessage')--}}{{--











                Lookup Parameter






                            {!!  Form::text('parameter', null,['class' => 'form-control','multiple' => 'multiple','id' => 'streams']) !!}






        {!!  Form::submit('Execute', array('class' => 'btn btn-primary pull-right')) !!}
        {!!Form::close()!!}--}}



