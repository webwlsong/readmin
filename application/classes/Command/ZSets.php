<?php
/**
 * Copyright (c) 2011 Max Kamashev <max.kamashev@gmail.com>
 * Distributed under the GNU GPL v3. For full terms see the file COPYING.
 */
class Command_ZSets
{
    public static function zRange( $key, $start = 0, $end = -1 )
    {
        $total = R::factory()->zCard( $key );

        $value = R::factory()->zRange( $key, $start, $end, true );

        $data = array(
                        'key'   => $key,
                        'start' => $start,
                        'end'   => $end,
                        'value' => $value,
                    );

        $data['paginator']  = '';

        if ( $total > Config::get('re_limit') )
        {

            $dataUrl = array(
                            'db'        => Request::factory()->getDb(),
                            'cmd'       => 'ZRANGE ' . $key,
                            );

            $url    = '/?'. http_build_query( $dataUrl ) . '+:start:+:end:+&page=:page:';
            $data['paginator'] = Paginator::parseExtended(
                                    $total, Request::factory()->getPage(), $url, Config::get( 're_limit' )
                                );
        }
        $data['command'] = 'ZRANGE ' . $key . ' ' . $start . ' ' . $end;

        return View::factory('tables/zrange', $data);
    }

    public static function zRem( $key, $member )
    {
        return R::factory()->zRem( $key, $member );
    }

    public static function zRank( $key, $member )
    {
        return R::factory()->zRank( $key, $member );
    }
}
