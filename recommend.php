<?php

/**
 * content based filtering+
 *
 * @package   PHP item based filtering
 */

class Recommend {       

    
    public function similarityDistance($prefs, $person1, $person2){     //Get Euclidean Distance
        $similar = array();
        $sum = 0;
        foreach($prefs[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $prefs[$person2]))
                $similar[$key] = 1;
        }
        
        /*if(count($similar) == 0)        //no information data for both people 
            print_r("1111");
            return 0;
        */

        foreach($prefs[$person1] as $key=>$value)
        {
            if($key != "location_postal"){
                $normalized_dev = ( (double)$value - (double)$prefs[$person2][$key] ) / 5;
                $sum = $sum + pow( $normalized_dev , 2);
            }
            else{
                $normalized_dev_postal = ( (double)$value - (double)$prefs[$person2][$key] ) / 40000;
                $sum = $sum + pow( $normalized_dev_postal , 2);
            }
        }
        
        return  1/(1 + sqrt($sum));     
    }


    public function matchItems($prefs, $person){
        $score = array();
        
            foreach($prefs as $otherPerson=>$values)
            {
                if($otherPerson !== $person)
                {
                    $sim = $this->similarityDistance($prefs, $person, $otherPerson);
                    
                    if($sim > 0)
                        $score[$otherPerson] = $sim;
                }
            }
        
        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    
    public function transformPreferences($prefs){
        $result = array();
        
        foreach($prefs as $otherPerson => $values)
        {
            foreach($values as $key => $value)
            {
                $result[$key][$otherPerson] = $value;
            }
        }
        
        return $result;
    }
    
    
    public function getRecommendations($prefs, $person){
        $total = array();
        $simSums = array();
        $ranks = array();
        $sim = 0;
        
        foreach($prefs as $otherPerson=>$values)
        {
            if($otherPerson != $person)
            {
                $sim = $this->similarityDistance($prefs, $person, $otherPerson);
                $store_rank[$otherPerson] = $sim;
            }

            /*
            if($sim > 0)
            {
                
                foreach($prefs[$otherPerson] as $key=>$value)
                {
                    
                    if(!array_key_exists($key, $total)) {
                        $total[$key] = 0;
                    }
                    $total[$key] += $prefs[$otherPerson][$key] * $sim;
                    
                    if(!array_key_exists($key, $simSums)) {
                        $simSums[$key] = 0;
                    }
                    $simSums[$key] += $sim;
                    
                }
            }
            */
        }
        array_multisort($store_rank, SORT_DESC);    
        return $store_rank;

        /*
        foreach($total as $key=>$value)
        {
            print($key);
            print('  ');
            print($value);
            print('  ');
            print($simSums[$key]);
            print('     ');
            
            $ranks[$key] = $value / $simSums[$key];
             
        }
        

        
    array_multisort($ranks, SORT_DESC);    
    return $ranks;
    */
        
    }
   
}

?>