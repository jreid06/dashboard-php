<?php

/**
 *
 */
class get_stat extends Databasecontrols
{
    public function directory_space($disk)
    {
        $disk_total_space = disk_total_space($disk);
        $disk_free_space = diskfreespace($disk);
        $disk_used_space = $disk_total_space - $disk_free_space;

        $response = array();

        $response['disk_total_space'] = convertToReadableSize($disk_total_space);
        $response['disk_free_space'] = convertToReadableSize($disk_free_space);
        $response['disk_used_space'] = convertToReadableSize($disk_used_space);
        $response['raw_data'] = array(
            'raw_total_space'=>$disk_total_space,
            'raw_free_space'=> $disk_free_space,
            'raw_used_space'=> $disk_used_space
        );

        return $response;
    }
}
