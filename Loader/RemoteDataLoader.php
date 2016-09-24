<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 24/9/16
 * Time: 16:44
 */

namespace Simettric\Gaufrette2LiipImagineBundle\Loader;


use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

class RemoteUrlLoader implements LoaderInterface
{

    /**
     * @param mixed $path
     * @return mixed
     */
    public function find($path)
    {
        return file_get_contents($path);
    }
}