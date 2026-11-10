<?php

function isKepala()
{
    return session('user_level') === 'kepala';
}

function currentSppg()
{
    return session('id_sppg');
}
