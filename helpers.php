<?php
function formatDate($date, $separator)
{
    return date('d' . $separator . 'm' . $separator . 'Y', strtotime($date));
}
