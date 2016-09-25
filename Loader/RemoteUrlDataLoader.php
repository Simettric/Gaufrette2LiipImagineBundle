<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 24/9/16
 * Time: 16:44
 */

namespace Simettric\Gaufrette2LiipImagineBundle\Loader;


use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

class RemoteUrlDataLoader implements LoaderInterface
{

    private $default_image;

    function __construct($default_image=null)
    {
        $this->default_image = $default_image;
    }

    /**
     * @param mixed $path
     * @return mixed
     */
    public function find($path)
    {
        try{
            return file_get_contents($path);
        }catch (\Exception $e){

            if($this->default_image)
            {
                return file_get_contents($this->default_image);
            }
            throw $e;
        }

    }
}