@extends('layouts.app')

@section('title', 'Karta')

@section('meta')

@endsection

@section('head-stylesheet')
    <link rel="stylesheet" href="{{url('/')}}/css/style-map.css">
@endsection

@section('head-script')

@endsection



@section('body')
    <div class="container-fluid">
        <div class="row justify-content-md-end">
            <div class="col-md-8 order-2 order-md-1">
                <h1 class="text-center header-margin">Välj en del av Skåne</h1>
            </div>
            <div class="col col-md-2 order-1 order-md-2">
                <div class="text-right">
                    <a href="#" data-toggle="popover" data-trigger="focus" title="Välj en del av Skåne!" data-content="Här väljer du en del av Skåne där du vill vandra i och trycker sedan på knappen Fortsätt för att gå vidare." style="white-space:nowrap;"><img src="{{url('/')}}/images/icon-question.png" width="70px" id="question-mark"></a>                    <!--<i class="fa fa-question-circle fa_custom fa-3x" aria-hidden="true"></i>-->
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-1 justify-content-center" style="min-width: 481px; padding: 0;">

                {{-- <img src="{{url('/')}}/images/map/NW-1.png" alt="Kartdel NV" class="" />
                <img src="{{url('/')}}/images/map/NE-1.png" alt="Kartdel NÖ" class="" />
                <img src="{{url('/')}}/images/map/CENTER-1.png" alt="Kartdel center" class="" />
                <img src="{{url('/')}}/images/map/SW-1.png" alt="Kartdel SV" class="" />
                <img src="{{url('/')}}/images/map/SE-1.png" alt="Kartdel SÖ" class="" />
                <img src="{{url('/')}}/images/map/WTW-mockup5.png" alt="TEST" usemap="#Map" id="maptest"/>
                <a href="#">
                <map name="Map" id="Map">
                <area alt="" title="" href="#" shape="poly" coords="230,419,194,409,170,420,161,392,156,372,151,347,146,319,122,320,104,314,91,294,80,284,73,260,68,243,50,224,33,215,27,214,17,191,13,165,14,143,26,126,32,107,40,91,60,77,89,65,112,53,144,52,161,45,184,40,202,32,210,15,227,21,243,26,267,27,283,35,312,45,320,54,294,62,291,87,293,114,293,137,302,167,313,182,324,176,341,182,346,205,344,229,329,246,317,255,297,281,282,300,262,312,254,339,241,356,228,385,226,407" />
            </map>
        </a> --}}
        <img src="{{url('/')}}/images/map/map-white-stroke.png" class="map" alt="Karta kommer snart!" usemap="#Map" />


        <map name="Map" id="Map">


            <area alt="" title="" shape="poly" class="1" coords="169,356,159,368,135,368,134,360,127,346,120,345,110,348,103,334,101,316,89,300,88,277,73,264,70,243,55,220,38,196,33,175,29,165,26,142,18,125,7,111,21,111,33,121,47,126,55,134,62,138,69,152,93,157,107,149,116,131,116,125,94,105,96,97,91,88,89,74,81,71,75,65,58,55,59,43,81,21,96,24,106,34,120,43,129,42,139,35,152,40,152,55,151,68,157,83,177,87,192,90,211,90,223,103,242,95,254,79,270,66,285,59,297,59,304,52,314,61,334,63,333,73,312,84,308,104,307,123,293,124,282,136,287,161,293,172,287,183,292,193,291,214,284,219,295,237,300,238,292,251,290,260,266,264,254,282,242,308,240,329,227,329,215,335,200,337,187,350,190,364" />

            <area alt="" title="" shape="poly" class="2" coords="516,395,512,414,482,407,479,406,463,417,450,407,454,392,451,379,432,364,442,350,440,328,430,313,423,311,405,327,399,317,391,302,382,294,368,290,357,289,369,274,364,262,363,250,357,246,340,237,337,223,329,218,316,220,312,231,295,222,303,195,296,183,305,173,292,139,302,130,313,127,318,108,318,91,339,79,343,64,367,61,382,55,395,47,408,49,420,54,433,52,454,37,467,37,479,36,484,20,491,6,501,7,504,16,529,23,539,25,549,20,573,32,613,42,613,50,607,57,606,64,592,67,585,80,586,100,580,119,582,134,589,149,590,164,598,170,604,165,616,173,631,172,633,211,631,235,613,268,600,267,595,283,583,288,570,306,560,309,556,320,541,343,528,359" />

            <area alt="" title="" shape="poly" class="3" coords="312,442,279,420,261,413,246,413,243,401,220,390,222,369,215,361,200,358,209,346,227,341,240,338,250,330,248,311,263,285,271,272,295,266,301,256,308,242,318,238,322,228,330,229,332,240,340,251,356,255,351,264,358,275,345,283,348,300,367,297,383,304,387,318,394,324,395,332,403,336,425,321,431,328,427,335,432,341,435,350,423,361,426,369,434,375,435,381,445,384,446,396,439,405,427,418,411,410,387,404,377,413,374,422,362,419,354,427,333,419" />

            <area alt="" title="" shape="poly" class="4" coords="334,595,323,604,297,606,285,612,258,630,235,630,187,607,172,612,153,602,139,593,112,597,95,596,102,580,109,591,131,588,135,572,143,570,140,556,132,544,122,525,121,500,151,479,157,470,169,471,175,459,169,434,155,418,145,418,146,406,128,410,132,398,141,391,138,376,154,373,161,376,172,364,189,370,199,370,211,369,211,391,225,406,235,408,237,421,268,422,303,446,316,450,326,464,317,475,304,486,300,503,301,514,311,528,337,539,340,553,331,575" />

            <area alt="" title="" shape="poly" class="5" coords="514,421,516,443,522,453,533,460,535,487,547,501,556,513,555,521,562,531,552,554,526,586,519,597,505,619,472,613,441,588,421,584,414,584,400,594,376,587,355,587,343,592,338,578,348,560,346,540,346,535,317,523,308,508,315,484,333,471,335,459,322,446,334,431,353,434,362,428,377,430,388,413,413,419,427,427,442,411,450,424,478,417,492,422" />


        </map>

    </div>
    </div>

    <div class="row justify-content-end">
    <div class="col col-md-4">
        <button type="button" class="btn-trust btn-big text-right" id="map_continue_button">Fortsätt</button>
    </div>
    </div>

    </div>
    <input id="gameId" type="hidden" name="gameId" value="{{$gameId}}">
    <input id="areaId" type="hidden" name="areaId" value="">
@endsection



@section('body-script')
    <!-- Add maphilight plugin -->
    <script type="text/javascript" src="{{url('/')}}/js/jquery.maphilight.js"></script>
    <script src="{{url('/')}}/js/jquery.rwdImageMaps.min.js"></script>

    <script type="text/javascript">
        $.fn.maphilight.defaults = {
            fill: true,
            fillColor: '000000',
            fillOpacity: 0.1,
            stroke: true,
            strokeColor: 'f1c40f',
            strokeOpacity: 1,
            strokeWidth: 10,
            fade: true,
            alwaysOn: false,
            neverOn: false,
            groupBy: 'rel',
            wrapClass: true,
            shadow: true,
            shadowX: 0,
            shadowY: 0,
            shadowRadius: 5,
            shadowColor: 'ffffff',
            shadowOpacity: 1,
            shadowPosition: 'outside',
            shadowFrom: false
        }
        $(document).ready(function(e) {
            // $('#map_continue_button').hide();
            $(function() {
                $('.map').maphilight();
            });
            $('img[usemap]').rwdImageMaps();
            $('area').click(function(){
                $('#map_continue_button').show();
                var areaId = $(this).attr("class");
                $('#areaId').val(areaId);
                console.log(areaId);

                // Kartan highlightar städer beroende på area
                $("area").data('maphilight', { alwaysOn: false }).trigger('alwaysOn.maphilight');
                $("." + areaId).data('maphilight', {alwaysOn: true}).trigger('alwaysOn.maphilight');

            });

            $('#map_continue_button').click(function(){
                var areaId = $('#areaId').val();
                console.log(areaId);
                var gameId = $('#gameId').val();
                console.log(gameId);
                startLoader();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('/')}}/map/store",
                    data: {areaId: areaId, gameId: gameId},
                    dataType: 'json',
                    success: function(data) { // Om det LYCKADES att spara data
                        console.log(data);
                        window.location.href = "{{url('/')}}/theme";

                    }, // SLUT - Om det LYCKADES att spara data
                    error: function(xhr, textStatus, errorThrown,) { // Om det MISSLYCKADES att spara data
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);
                        stopLoader();
                    }
                }); // SLUT - Om det MISSLYCKADES att spara data
            });

        });
    </script>
@endsection
