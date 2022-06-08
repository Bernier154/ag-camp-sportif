<?php 
namespace Agcsi\Helpers;

use Agcsi\CPT\Inscription;


class DaysCounter{
    public static function fromUser($userID){
        $count = 0;
        $inscriptions = Inscription::get_from_parent_ID($userID);
        foreach($inscriptions as $inscription){
            if(\Date('Y',strtotime($inscription->post->post_date)) == \Date('Y')){
                $count += count($inscription->dates);
            }
        }
        return $count;
    }
}