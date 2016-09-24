<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 24/9/16
 * Time: 16:02
 */

namespace Simettric\Gaufrette2LiipImagineBundle\Resolver;


use Gaufrette\Filesystem;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Exception\Imagine\Cache\Resolver\NotResolvableException;
use Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface;

class LiipGaufretteResolver implements ResolverInterface
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    private $filesystem_url;

    private $filesystem_path;

    /**
     * LiipGaufretteResolver constructor.
     * @param Filesystem $filesystem
     * @param $cache_dir
     */
    function __construct(Filesystem $filesystem, $filesystem_url, $filesystem_path)
    {
        $this->filesystem       = $filesystem;
        $this->filesystem_url   = $filesystem_url;
        $this->filesystem_path  = $filesystem_path;
    }

    /**
     * @param string $path
     * @param string $filter
     * @return mixed
     */
    public function isStored($path, $filter)
    {
        $name_to_store =   $this->getLocalNameToStore($path, $filter);

        return $this->filesystem->has($name_to_store);

    }

    /**
     * @param string $path
     * @param string $filter
     * @return mixed
     */
    public function resolve($path, $filter)
    {

        return $this->filesystem_url . "/" . $this->filesystem_path . "/" . $this->getLocalNameToStore($path, $filter);
    }

    /**
     * @param BinaryInterface $binary
     * @param string $path
     * @param string $filter
     * @return mixed
     */
    public function store(BinaryInterface $binary, $path, $filter)
    {

        $this->filesystem->write($this->getLocalNameToStore($path, $filter), $binary->getContent(), true );

    }

    /**
     * @param array|\string[] $paths
     * @param array|\string[] $filters
     * @return mixed
     */
    public function remove(array $paths, array $filters)
    {
        die("not implemented " . __FILE__);
    }


    private function getLocalNameToStore($path, $filter){

        //si coincide con la url en la que estamos almacenando es que estamos utilizando el mismo servicio cloud
        if(0===strpos($this->filesystem_url, $path)){
            $path = str_replace($this->filesystem_url . "/", '', $path);
        }else{
            $path = preg_replace('@.*?:\/\/@', '', $path);
        }


        $path =  $filter . "/" . $path;
        return $path;
    }
}