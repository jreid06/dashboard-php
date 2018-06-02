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

    public function activeAdminUsers()
    {
        $active_users = parent::selectData('users', ['id', 'email', 'last_login_date', 'createdAt'], ['login_status'=>'true']);

        // $response = array();
        if ($active_users['data']) {
            return [true, $active_users['data']];
        } else {
            return [false, 'currently there are no active users'];
        }
    }

    public function allAdminUsers()
    {
        $cache = new Cache();

        // get cache results
        if (!$cache->get("all_admin_users", $result)) {

            // get all users
            $all_users = parent::selectData('users', ['id', 'email', 'last_login_date', 'createdAt', 'permissions', 'login_status'], false);

            if ($all_users['data']) {
                $result = $all_users['data'];

                // store in as cache
                $cache->set("all_admin_users", $result, 1000); // cache result for 5 minutes (300 seconds)

                return [true, $all_users['data'], 'not cache data'];
            } else {
                return [false, 'error getting all admin users information'];
            }
        } else {
            return [true, $result, 'cache data'];
        }
    }
}
