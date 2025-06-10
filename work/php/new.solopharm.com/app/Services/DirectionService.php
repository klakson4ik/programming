<?php

namespace App\Services;

use App\Models\Direction;

class DirectionService
{
    public static function getDirectionsWithChildrens($directions)
    {
        foreach($directions as $key => &$direction) {
            $parentId = array_search($direction['parent_id'], array_column($directions->toArray(), 'id'));

            if($parentId !== false) {
                if(!$directions[$parentId]['children']) {
                    $directions[$parentId]['children'] = [];
                }
                $children = $directions[$parentId]['children'];
                $children[] = $key;
                $directions[$parentId]['children'] = $children;
            }
        }
        
        return $directions;
    }
}