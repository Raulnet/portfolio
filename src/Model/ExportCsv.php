<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 10/10/15
 * Time: 14:57
 */

namespace portfolio\Model;


class ExportCsv {

    /**
     * @param array $results
     * @param array $championship
     *
     * @return string
     */
    public function getChampionshipDataCsv(array $results, array $championship){

        $data = array();


        $title = array('championship', $championship['cha_title']);
        $board = array('stage', 'Rank', 'Players', 'Results');
        //find general
        $rank = 1;
        $playersResults = array();
        foreach($results as $key => $stages){
            foreach($stages as $results){
                $playersResults[$key][$results['player_id']] = $results;
            }
        }
        // Map all player on general
        foreach($playersResults['general'] as $key => $result){
            $idStage ='general';
            $data[$key]['stage'.$idStage] = $idStage;
            $data[$key]['rank'.$idStage] = $rank;
            $data[$key]['Players'.$idStage] = $result['nickname'];
            $data[$key]['Results'.$idStage] = $result['value'];
            $rank++;
        }
        // load all result by stage to player, if player not exit set null result
        foreach($playersResults as $key => $stage){

            if($key != 'general'){
                $board[] = 'Stage';
                $board[] = 'Lounge';
                $board[] = 'Results';
                foreach($data as $idPlayer => $result){
                    if(array_key_exists($idPlayer, $stage)){
                        $data[$idPlayer]['stage'.$key] = $stage[$idPlayer]['stage_title'];
                        $data[$idPlayer]['lounge'.$key] = $stage[$idPlayer]['lounge_title'];
                        $data[$idPlayer]['Results'.$key] = $stage[$idPlayer]['value'];
                    } else {
                        $data[$idPlayer]['stage'.$key] = null;
                        $data[$idPlayer]['lounge'.$key] = null;
                        $data[$idPlayer]['Results'.$key] = null;
                    }
                }
            }
        }


        $csv = '';
        $csv .= implode(';',$title)."\n";
        $csv .= implode(';',$board)."\n";
        foreach($data as $value){
            $csv .= implode(';',$value)."\n";
        }

        return $csv;
    }



    /* ****** METHOD ***************************************** */
}