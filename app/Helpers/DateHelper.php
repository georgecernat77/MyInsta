<?php

namespace App\Helpers;

class DateHelper {
    public static function formatTimeDifference($created_at) {
        $postDays = intval(now()->diffInDays($created_at) * (-1));
        $postHours = intval(now()->diffInHours($created_at) * (-1));
        $postMinutes = intval(now()->diffInMinutes($created_at) * (-1));

        if ($postDays == 0) {
            if ($postHours == 0) {
                if($postMinutes == 0) {
                    return "now";
                }
                else {
                    return "{$postMinutes}m";
                }
            }
            else {
                return "{$postHours}h";
            }
        }
        else {
            return "{$postDays}d";
        }

    }
}
