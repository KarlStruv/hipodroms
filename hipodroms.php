<?php
function addHorse(string $name, string $icon ,float $coef) : stdClass{

    $horses = new stdClass();
    $horses->name = $name;
    $horses->icon = $icon;
    $horses->coef = $coef;



    return $horses;
}

$horses = [
    addHorse("Mustang", "*",1.3),
    addHorse("Roach","#", 1.2),
    addHorse("Reksis","x", 1.6),
    addHorse("VW Golf","o",1.1),
    addHorse("T34","p",2),

];

$player = new stdClass();
$player -> name = "John";
$player -> money = 200;

$track = [];

foreach ($horses as $key => $horse){
    echo "$key. $horse->name - $horse->coef" . PHP_EOL;
}
$myHorseKey = (int)readline("Choose your horse: ");

if(!is_numeric($myHorseKey)) {
    echo "Please enter a valid number..." . PHP_EOL;
    exit;
}
foreach ($horses as $key => $horse){
    if ($myHorseKey === $key){
        $myHorse = $horse;
        echo "You chose horse: $horse->name" . PHP_EOL;
    }
}
sleep(1);
echo "You have {$player->money}$." . PHP_EOL;
$bet = (int)readline("Enter your bet($): ");

$horseCount = count($horses);
///track display static
for ($rows = 0; $rows < $horseCount; $rows++){
    for ($meters = 0; $meters < 100; $meters++){
        array_push($track, "_");
    }
}



$stepArray = [];
$winners = [];
$turn = 1;
while($turn > 0){
    ///track display dynamic

    for ($i = 0; $i < count($track) - 1; $i++) {

        if ($i % 100 === 0) {
            echo PHP_EOL;
        }
        echo $track[$i];
    }

    time_nanosleep(0, 150000000);
    foreach ($horses as $key => $horse) {

        $horseCoef = $horse->coef * 10;
        $chanceToWin = rand(1, $horseCoef);
        if ($chanceToWin <= 10){
            $bonusStep = 1;
        }else{
            $bonusStep = 0;
        }


        $stepArray[$key] += rand(1,2) + $bonusStep;
        $startPosition = $key * 100;
        $currentPosition = $startPosition + $stepArray[$key];
        $previousPosition = $key * 100 + $stepArray[$key];
        /////// Nevermind the -1/-2/-3, it clears the track well... :D
        $track[$previousPosition - 1] = "_";
        $track[$previousPosition - 2] = "_";
        $track[$previousPosition - 3] = "_";
        $track[$currentPosition] = $horse->icon;



        echo " " . PHP_EOL;
        echo " " . PHP_EOL;
        $turn++;



        if ($currentPosition >= $startPosition + 99 ){
            (array_push($winners, $horse->name));
            $track[$currentPosition] = "_";
            $winners = array_unique($winners);



            foreach ($winners as $winnerKey => $winner){

                echo $winnerKey+1 . ". $winner" . PHP_EOL;
            }

            if(count($winners) >= $horseCount){
                $turn = 0;
            }
        }

    }

    echo " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL;
    echo " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL;
    echo " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL;
    echo " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL . " " . PHP_EOL;
}
echo "$winners[0] won the race! " . PHP_EOL;
foreach ($horses as $key => $horse){
    $amountWon = ($bet * $horse->coef) - $bet;
    if ($myHorseKey === $key){
        $myHorseName = $horse->name;


        if ($myHorseName === $winners[0]){
            echo "Congratulation! You won" . PHP_EOL;
            echo "You win $amountWon$" . PHP_EOL;

        }else{
            echo "Better Luck Next Time!" . PHP_EOL;
        }


    }


}

