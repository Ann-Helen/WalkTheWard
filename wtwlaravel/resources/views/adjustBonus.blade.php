@extends('layouts.app')

@section('title', 'Hantera bonus')

@section('meta')

@endsection

@section('head-stylesheet')
    <link rel="stylesheet" href="{{url('/')}}/css/style-admin.css">
@endsection

@section('head-script')

@endsection



@section('body')
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-md-8 order-2 order-md-1">
                <h1 class="text-center">Justera teman</h1>
                <form action="{{{ url("admin/adjustBonus") }}}" id="newBonusForm" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <span>
                            Vill du skapa ny bonusfråga?
                        </span>
                        <input type="radio" class="ifNewBonus" id="ifNewBonusYes" name="ifNewBonus" value="yes">Ja
                        <input type="radio" class="ifNewBonus" name="ifNewBonus" value="no">Nej
                    </div>
                    <div class="form-group newBonusDisplay">
                        <span>
                            Välj stad för bonusfrågan
                        </span>
                        <select name='choosePlace' required>
                            @foreach ($place as $p)
                                <option id='choosePlace{{$p->id}}' value='{{$p->id}}'>{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group newBonusDisplay">
                        <p>Välj val av media (bild eller video) tilhörande bonusfrågan</p>
                        {{-- <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"> --}}
                        {{-- <input type="submit" value="Upload Image" name="submit"> --}}
                        <div class="text-center">

                            <img id="image-preview" src="#" alt="Bild kunde inte förhandsgranskas!" style="display: none;"/>
                            <video id="video-preview" controls poster="" alt="Video kunde inte förhandsgranskas!" style="display: none;">
                                <source src="" id="video-preview-src" />
                                Your browser does not support HTML5 video.
                            </video>

                        </div>
                        <label class="custom-file">
                            <input type="file" name="fileToUpload" id="fileToUpload" class="custom-file-input" accept=".gif, .jpg, .jpeg, .png, .mp4">
                            <span class="custom-file-control"></span>
                        </label>
                        <span class="allowed-types">Tillåtna filformat: <strong>.png .gif .jpg .jpeg .mp4</strong></span>

                    </div>
                    <div class="form-group">
                        <p>Aktivera (<input type='checkbox' class='instruction-checkbox' checked disabled>) / Inaktivera (<input type='checkbox' class='instruction-checkbox' disabled>) valda tema</p>
                        @foreach ($bonus as $b)
                            <input type='checkbox' id='activateBonus{{$b->id}}' name='{{$b->id}}'>
                            <label for='activateBonus{{$b->id}}' class='col-form-label'>
                                {{$b->lettersToDiscard}}
                            </label>
                            <br />
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-6 text-left">
                            <a href="{{url('/')}}/gameHome" class="btn-fear btn-medium return_button start-loader">Tillbaka</a>
                        </div>
                        <div class="col-6 text-right">
                            <input type="submit" id="submit_button" class="btn-trust btn-medium" value="Skicka">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-2 order-1 order-md-2">
                <div class="text-right">
                    <a href="#" data-toggle="popover" data-trigger="focus" title="Skapa och justera teman" data-content="På den här sidan kan administratörer skapa och justera teman." style="white-space:nowrap;"><img src="{{url('/')}}/images/icon-question.png" width="70px" id="question-mark"></a>
                </div>
            </div>
        </div>

    </div>
@endsection



@section('body-script')
    <script type="text/javascript">
    $('.newBonusDisplay').hide();
    $(document).ready(function(){
        $('.ifNewBonus').change(function() {
            if ($('#ifNewBonusYes').prop('checked')) {
                $('.newBonusDisplay').show();
            } else {
                $('.newBonusDisplay').hide();
            }
        });
        $("form").submit(function() {
            startLoader();
        });
    });
    </script>

@endsection
