<style>
    .lds-facebook,
    .lds-facebook div {
        box-sizing: border-box;
    }

    .lds-facebook {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-facebook div {
        display: inline-block;
        position: absolute;
        left: 8px;
        width: 16px;
        background-color:cornflowerblue;
        animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }

    .lds-facebook div:nth-child(1) {
        left: 8px;
        animation-delay: -0.24s;
    }

    .lds-facebook div:nth-child(2) {
        left: 32px;
        animation-delay: -0.12s;
    }

    .lds-facebook div:nth-child(3) {
        left: 56px;
        animation-delay: 0s;
    }

    @keyframes lds-facebook {
        0% {
            top: 8px;
            height: 64px;
        }

        50%,
        100% {
            top: 24px;
            height: 32px;
        }
    }
</style>

<div style="display: flex;align-items: center; justify-content: center; height:100vh">
    <div class="lds-facebook" >
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<?php

pr($_POST);

function sconv($seconds)
{
$timeFormat = gmdate("H:i:s", $seconds);
return $timeFormat;
}

$debut = sconv($_POST['debut']);
$fin = sconv($_POST['fin']);
$dest = dirname($_POST['file']).'/photos/';
$source = $_POST['file'];

echo $dest;

//$output = shell_exec('/var/www/html/scripts/captures.sh '.$source.' '.$debut.' '.$fin.' '.$dest.' 2>&1'); //Arguments passés sont  $1; $2; $3 dans le script Shell
var_dump($output);
