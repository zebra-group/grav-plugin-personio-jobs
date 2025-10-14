<?php
namespace Grav\Plugin\PersonioJobs;

use Grav\Common\Grav;
use Grav\Common\File\CompiledJsonFile;

class Utils
{
    // common get call
    function getJobs( $no_cache = false )
    {
        if ( $no_cache )
        {
            return $this->fetchJobs();
        }
        // if cache index
        $cache = $this->getCache();
        if ( $cache && count( $cache ) == 2 )
        {
            return $cache;
        }
        // else fetch, cache and deliver
        else
        {
            $jobs = $this->fetchJobs();
            $this->setCache( $jobs );
            return $this->getCache();
        }
    }

    // get them fresh from personio
    function fetchJobs()
    {
        $source = Grav::instance()['config']->get( 'plugins.personio-jobs.source' );
        if ( $source )
        {
            $positions = simplexml_load_file( $source . '/xml' );
            $objJsonDocument = json_encode( $positions) ;
            $arrOutput = json_decode( $objJsonDocument, true );
            // var_dump( $arrOutput );
            return $arrOutput['position'];
        }
    }

    function getCache()
    {
        $path = Grav::instance()['locator']->findResource( 'user-data://' ) . '/personio-index.json';

        if ( file_exists( $path ) )
        {
            $indexFile = CompiledJsonFile::instance( $path );
            $index = $indexFile->content();

            return $index;
        }

        return null;
    }

    function setCache( $jobs )
    {
        $path = Grav::instance()['locator']->findResource( 'user-data://' ) . '/personio-index.json';
        if ( !file_exists( $path ) )
        {
            // create index file
            touch( $path );
        }

        $content = [
            'revision' => date( 'c' ),
            'jobs' => $jobs
        ];

        // save as json file
        $jobsFile = CompiledJsonFile::instance( $path );
        $jobsFile->content( $content );
        $jobsFile->save();
    }
}