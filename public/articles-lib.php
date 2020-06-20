<?php
/**
 * Author : Audrey Wech
 * @param int $id id of an article
 * @param array $articles array containing articles
 * @return bool|array the function returns false if the article is not found or the article itself if it is found
 */



function articleExists(int $id, array $articles){
    if (array_key_exists($id, $articles)){
        return $articles[$id];
    }
    
    return false;
}

