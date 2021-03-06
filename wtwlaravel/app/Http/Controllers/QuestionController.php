<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Character;
use App\Game;
use App\Place;
use App\Place_in_game;
use App\Area;
use App\Theme;
use App\Question;
use App\Question_in_game;
use App\Map;
use App\Bonus_game;
use App\Bonus_game_in_game;
use App\Http\Controllers\Cookie;
use Carbon\Carbon;
use App\Http\Controllers\DateTime;

class QuestionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $stationId = "2";
        $patientId = $request->cookie('patientId');
        $patient = Patient::find($patientId);
        // Patient::where('patientId' => $patientId)->update('distanceInMeter'=> 14);

        //$patient->Game()->areaId;
        return view('question', compact(['patient', 'stationId']));
        // return view('question');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        try {
            $distanceInMeterAmount = $request->metersWalked;
            $gameId = $request->gameId;
            $questionId = $request->questionId;
            Question_in_game::where(['questionId' => $questionId, 'gameId' => $gameId])->update(['isAnswered' => 1]);

            $placeId = $request->placeId;

            $numberOfStars = $request->starsAmount;

            $placeInGame = Place_in_game::where('placeId', $placeId)->where('gameId', $gameId)->first();
            $oldStars = $placeInGame->numberOfStars;

            $question = Question::find($questionId);
            $correctAnswerId = $question->correctAnswer;

            $placeName = Place::find($placeId)->name;

            $isNewHighscore = false;
            if (intval($oldStars) < intval($numberOfStars)) {
                $isNewHighscore = true;
                // Uppdatera antal stjärnor om resutatet är bättre än föregående
                Place_in_game::where(['gameId' => $gameId, 'placeId' => $placeId])->update(['numberOfStars' => $numberOfStars]);
            }

            // Hämtar distance för användaren(cookien)
            $patientId = $request->cookie('patientId');
            $patient = Patient::find($patientId);
            // $distanceAmountInMeter = $patient->distanceInMeter;
            $distanceAmount = round($distanceInMeterAmount * 1.3);

            // Hämtar area
            $game = Game::find($gameId);
            $areaId = $game->areaId;
            $area = Area::find($areaId);
            $areaName = $area->name;

            // Hämtar map
            $mapId = $area->mapId;
            $map = Map::find($mapId);
            $mapName = $map->name;

            // Hämtar placeInGame activeRound
            $placeActiveRound =  $placeInGame->activeRound;

            // Uppdaterar activeRound till 1
            Place_in_game::where(['gameId' => $gameId, 'placeId' => $placeId])->update(['activeRound' => 1]);

            // Hämtar en lista med alla places för specifik area
            $placeIdArray = Place::where('areaId', $areaId)->pluck('id')->toArray();
            $placeActiveRoundArray = "";
            $placeTempObject = collect();
            foreach ($placeIdArray as $placeIdInList) {
                // Hämtar en lista av gameId och areaId alla activeRound
                $placeTempObject->push(Place_in_game::where(['placeId' => $placeIdInList, 'gameId' => $gameId])->get());
            }
            $placeActiveRoundArraytest = $placeTempObject->flatten();

            // Räknar antal städer i area med activeRound == 1
            $countActiveRound = 0;
            foreach ($placeActiveRoundArraytest as $activeRound) {
                if ($activeRound['activeRound'] == 1) {
                    $countActiveRound++;
                }
            }

            // Gör om int till string
            $counts = "$countActiveRound";

            // Kontrollera om användaren besökt en stad
            if ($countActiveRound == 1) {
                $placeActiveRound = $counts . " stad";
            }
            // Kontrollerar om användaren besökt flera städer
            if ($countActiveRound > 1) {
                $placeActiveRound = $counts . " städer";
            }

            // Räknar antal id för att se hur många stationer där finns totalt
            $placeIdAmount = count($placeIdArray);
            // Skapar en bool för att senare användas för att kontrollera om användaren är klar med alla stationer för area
            $placeInGameBool = false;
            if ($countActiveRound == $placeIdAmount) {
                $placeActiveRound = $counts . " antal städer! Du är klar med hela " . $areaName . " " . $mapName;

                // Nollställer alla activeRound för arean
                foreach ($placeIdArray as $placeIdInList) {
                    Place_in_game::where(['placeId' => $placeIdInList, 'gameId' => $gameId])->update(['activeRound' => 0]);
                }

                // Skapar variabel om användaren svarat på alla stationer
                $placeInGameBool = true;
            }

            // Kollar om bonusfråga finns
            if (Bonus_game::where('placeId', $placeId)->first()){
                $bonusGameExist = Bonus_game::where('placeId', $placeId)->first();
                $bonusGameId = $bonusGameExist->id;
                // Kollar om bonus_game_in_game finns
                try{
                    $bonusGameInGame = Bonus_game_in_game::where('bonusGameId', $bonusGameId)->where('gameId', $gameId)->first();
                    $bonusGameInGameIsCompleted = $bonusGameInGame->isCompleted;

                    // Kollar om bonusfrågan är besvarad
                    if ($bonusGameInGameIsCompleted == 1){
                        $bonusGame = $placeName;
                        // Kollar om användaren svarat på alla 8 städer
                        if ($placeInGameBool == true) {
                            // Skickar användaren hem
                            $bonusUrl = "/gameHome";
                        }
                        if ($placeInGameBool == false) {
                            // Skickar användaren till skanningen
                            $bonusUrl = "/scan";
                        }
                    }
                    else{
                        // Gör _ för varje bokstav i namnet och mellanslag mellan varje bokstav
                        // $bonusGame = implode(' ',str_split(str_repeat("_", strlen($placeName)))) . " Gissa!";
                        // skiter i ovan, och skapar bara "???" istället för stadens namn
                        $bonusGame = "???";

                        $bonusUrl = "/bonus/$bonusGameId";
                    }
                }

                // Skapar bonus_game_in_game
                catch (\Exception $e) {
                    $bonusGameInGame = new Bonus_game_in_game;
                    $bonusGameInGame->bonusGameId = $bonusGameId;
                    $bonusGameInGame->gameId = $gameId;
                    $bonusGameInGame->isCompleted = 1;
                    $bonusGameInGame->save();
                    $bonusGame = "???";
                    $bonusUrl = "/bonus/$bonusGameId";
                }
            }
            else{
                if ($placeInGameBool == true) {
                    $bonusGame = $placeName;
                    $bonusUrl = "/gameHome";
                }
                if ($placeInGameBool == false) {
                    $bonusGame = $placeName;
                    $bonusUrl = "/scan";
                }

            }

            $correctAnswer = "";
            if ($correctAnswerId == 1) {
                $correctAnswer = $question->answer1;
            }
            elseif ($correctAnswerId == 2) {
                $correctAnswer = $question->answer2;
            }
            elseif ($correctAnswerId == 3) {
                $correctAnswer = $question->answer3;
            }
            elseif ($correctAnswerId == 4) {
                $correctAnswer = $question->answer4;
            }
            else {
                $correctAnswer == null;
            }
        }

        catch (\Exception $e) {
            $error = $e->getMessage();
            $response = array(
                'status' => 'error',
                'msg' => $error
            );
            return response()->json($response);
        }

        $response = array(
            'status' => 'success',
            'numberOfStars' => $numberOfStars,
            'correctAnswer' => $correctAnswer,
            'placeName' => $placeName,
            'isNewHighscore' => $isNewHighscore,
            'distanceAmount' => $distanceAmount,
            'placeName' => $placeName,
            'areaName' => $areaName,
            'mapName' => $mapName,
            'bonusGame' => $bonusGame,
            'bonusUrl' => $bonusUrl,
            'placeActiveRound' => $placeActiveRound
        );

        return response()->json($response);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request, $id)
    {
        $message = "";

        // StationId från URL question/{stationId}
        $stationId = $id;

        // Hämta PatientId från cookie
        $patientId = $request->cookie('patientId');

        // Hämta CurrentAreaId
        $patient = Patient::find($patientId);
        $areaId = $patient->game->area->id;

        // Hämtar Game
        $game = $patient->game;
        $gameId = $game->id;

        $patient = Patient::find($patientId);
        $distanceInMeter = $patient->distanceInMeter;

        // Skapar 2D arrayen
        $arrayToCompare = array(                                             // STATION
            array(0,    5,      10,     15,     20,     25,     30,     35), // 1
            array(5,    0,      15,     20,     25,     30,     35,     40), // 2
            array(10,   15,     0,      25,     30,     35,     40,     45), // 3
            array(15,   20,     25,     0,      30,     35,     40,     45), // 4
            array(20,   25,     30,     35,     0,      40,     45,     50), // 5
            array(25,   30,     35,     40,     45,     0,      55,     60), // 6
            array(30,   35,     40,     45,     50,     55,     0,      60), // 7
            array(35,   40,     45,     50,     55,     60,     65,     0)   // 8
        // STATION 1     2       3       4       5       6       7       8
        );

        $latestUpdatedPlace = Place_in_game::where('gameId', $gameId)->latest("updated_at")->first();
        if ($latestUpdatedPlace === null) {
            $metersWalked = 0;
        }
        else {
            // Hämtar senast besökt place för användaren
            $latestUpdatedPlace = Place_in_game::where('gameId', $gameId)->latest("updated_at")->first();
            // Hämtar placeId från senaste besökta platsen
            $latestUpdatedPlaceId = $latestUpdatedPlace->placeId;
            // Tar modulus med antal platser med 8, för att få fram vilken stationer de varit på
            $idOfLatestUpdatedStation = $latestUpdatedPlaceId % 8;

            // Kollar om datumet är äldre än 1h
            $date = $latestUpdatedPlace->updated_at;
            if (strtotime("$date +1 hour") <= time()) {
                $metersWalked = 0;
            }
            else {
                // Avgör hur många steg användaren får beroende på vilken station man senast besökte och vilken man besöker
                $metersWalked = $arrayToCompare[$stationId-1][$idOfLatestUpdatedStation-1];
            }
        }

        $distanceInMeterAmount = $distanceInMeter + $metersWalked;
        // Ger distancen
        Patient::where(['id' => $patientId])->update(['distanceInMeter' => $distanceInMeterAmount]);

        // Hämta PlaceId
        $place = Place::where('stationId', $stationId)->where('areaId', $areaId)->first();
        $placeId = $place->id;

        // Hämta GameId
        $gameId = $patient->game->id;

        // Skapa placeInGame om det inte redan finns
        if (Place_in_game::where('placeId', $placeId)->where('gameId', $gameId)->first() == null) {
            $newPlaceInGame = new place_in_game;
            $newPlaceInGame->gameId = $gameId;
            $newPlaceInGame->placeId = $placeId;
            $newPlaceInGame->numberOfStars = 0;
            $newPlaceInGame->activeRound = 0;
            $newPlaceInGame->save();
        }

        // Hämta Place_in_Game (antal stjärnor)
        $place_in_game = Place_in_game::where('placeId', $placeId)->where('gameId', $gameId)->first();

        if ($place_in_game->numberOfStars != null) {
            $message = "Number of stars is not null";
        }

        // Hämta currentThemeId
        $currentThemeId = $patient->game->themeId;

        // Hämta currentTheme
        $currentTheme = Theme::Find($currentThemeId);

        // $question_in_game = Question_in_game::where('gameId', $gameId)->first();
        // $question = $question_in_game->question;
        // $theme = $question->theme;
        // $themeId = $question->theme->id;



        $themeQuestions = $currentTheme->questions;
        $themequestionIds = Question::where('themeId', $currentThemeId)->pluck('id')->toArray();
        $qinGArray = array();
        foreach ($themeQuestions as $q) {
            if (Question_in_game::where('gameId', $gameId)->where('questionId', $q->id)->where('isAnswered', 1)->first()) {
                array_push($qinGArray, $q->id);
            }
        }
        $availableQuestion =  array_diff($themequestionIds, $qinGArray);

        if (count($availableQuestion) == 0) {
            foreach ($themeQuestions as $q) {
                Question_in_game::where(['questionId' => $q->id, 'gameId' => $gameId])->update(['isAnswered' => 0]);
            }
            $availableQuestion = $themequestionIds;
        }

        $randomQuestionId = array_random($availableQuestion);

        $question = Question::find($randomQuestionId);

        if (Question_in_game::where('gameId', $gameId)->where('questionId', $randomQuestionId)->first() == null) {
            $newQuestionInGame = new question_in_game;
            $newQuestionInGame->gameId = $gameId;
            $newQuestionInGame->questionId = $randomQuestionId;
            $newQuestionInGame->isAnswered = 0;
            $newQuestionInGame->save();
        }

        return view('question', compact(['currentTheme', 'question', 'gameId', 'placeId', 'metersWalked']));
        // return view('backend', compact(['testing', 'showQuestion']));
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
