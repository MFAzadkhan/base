<?php

session_start();

error_reporting (E_PARSE | E_COMPILE_ERROR);

function ResetGame()
{
    unset ( $_SESSION['theMaxNumber'] );
}

function InitGame()
{
    $_SESSION['theNumberToGuess'] = mt_rand (0, $_SESSION['theMaxNumber']);

    $_SESSION['theMaxNumberOfTries'] = floor ( log ($_SESSION['theMaxNumber'], 2) ) + 1;

    $_SESSION['theUserTriesCount'] = 0;

    $_SESSION['thePrevGuessesString'] = '';

    $_SESSION['theUserGuess'] = 0;
}

function ComputeNumberOfTriesLeft()
{
    return $_SESSION['theMaxNumberOfTries'] - $_SESSION['theUserTriesCount'];
}

function IsNoMoreTriesLeft()
{
    return ComputeNumberOfTriesLeft() <= 0;
}

$aCanPlayGame = false;

$aUserSubmittedGuess = false;

$aIsNoMoreTriesLeft = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ( isset ($_REQUEST['playgame']) ) {

        $_SESSION['theMaxNumber'] = intval($_REQUEST['theMaxNumber']);

        // init game ...
        InitGame();

        $aCanPlayGame = true;

    }
    elseif ( isset ($_REQUEST['submituserguess']) ) {

        $aCanPlayGame = true;

        $aUserSubmittedGuess = true;

        $_SESSION['theUserGuess'] = intval($_REQUEST['theUserGuess']);

    }
    elseif ( isset ($_REQUEST['resetgame']) ) {

        ResetGame();

    }
    else {
        ResetGame();
    }

}
else {
    ResetGame();
}

// check a play

$aUserShouldTryLower = false;
$aUserShouldTryHigher = false;

$aUserWins = false;

$aUserLooses = false;

if ($aCanPlayGame) {

    $aIsNoMoreTriesLeft = IsNoMoreTriesLeft();

    if ( ! $aIsNoMoreTriesLeft ) {

        // user have tries left

        if ($aUserSubmittedGuess) {

            // check user guess ...
            $aUserGuess = intval($_SESSION['theUserGuess']);

            if ( $aUserGuess > $_SESSION['theNumberToGuess'] ) {

                $aUserShouldTryLower = true;

            }
            elseif ( $aUserGuess < $_SESSION['theNumberToGuess'] ) {

                $aUserShouldTryHigher = true;

            }
            else {

                $aUserWins = true;

                // also reset game
                ResetGame();

            }

            // add the current guess to the prev guesses string
            $_SESSION['thePrevGuessesString'] .= $_SESSION['theUserGuess'] . ' ';

            // increase the user tries count
            ++ $_SESSION['theUserTriesCount'];

            // check tries count
            if ( ! $aUserWins ) {

                $aIsNoMoreTriesLeft = IsNoMoreTriesLeft();

                if ($aIsNoMoreTriesLeft) {
                    // this was the last try

                    // no more tries left
                    $aUserLooses = true;

                    // also reset game
                    ResetGame();
                }

            }
        }

    }
    else {
        // no more tries left
        $aUserLooses = true;

        // also reset game
        ResetGame();
    }

}

?>

<?php if ($aUserLooses): ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Guess a Number</title>
    </head>
    <body>
    <p>Sorry, you loose the game</p>
    <p>the Number to Guess was <?php echo $_SESSION['theNumberToGuess']; ?></p>
    <form method="post">
        <input type="submit" name="resetgame" value="reset game">
    </form>
    </body>
    </html>

<?php elseif ($aUserWins): ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Guess a Number</title>
    </head>
    <body>
    <p>Congrats, you Win the Game</p>
    <p>the Number to Guess was <?php echo $_SESSION['theNumberToGuess']; ?></p>
    <form method="post">
        <input type="submit" name="resetgame" value="reset game">
    </form>
    </body>
    </html>

<?php elseif ($aCanPlayGame): ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Guess a Number</title>
    </head>
    <body>

    <p>the Max Number is <?php echo $_SESSION['theMaxNumber']; ?></p>
    <p>Guess a Number in the Range [ 0-100 <?php echo ($_SESSION['theMaxNumber']); ?> ]</p>
    <p>you have <?php echo ComputeNumberOfTriesLeft(); ?> tries left</p>
    <form method="post">
        <label for="theUserGuess">Enter your Guess: </label>
        <input type="text" id="theUserGuess" name="theUserGuess">
        <input type="submit" name="submituserguess" value="Guess">
        <input type="submit" name="resetgame" value="reset game">
    </form>
    <p>Prev Guesses: <?php echo $_SESSION['thePrevGuessesString']; ?> </p>
    <p>
        <?php
        if ($aUserShouldTryLower) {
            echo 'you should try a lower < guess';
        }
        elseif ($aUserShouldTryHigher) {
            echo 'you should try a higher > guess';
        }
        else {
            echo 'no guess';
        }
        ?>
    </p>

    </body>
    </html>

<?php else: ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Guess a Number</title>
    </head>
    <body>

    <p>Guess a Number from (0) to 100 </p>
    <form method="post">
        <input id="theMaxNumber" name="theMaxNumber">
        <input type="submit" name="playgame" value="play game">
    </form>

    </body>
    </html>

<?php endif; ?>

