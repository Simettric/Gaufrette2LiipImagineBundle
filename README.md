# GaufretteLiipImageResolverBundle
With this Bundle you can define resolvers in order to store the liip image cache files in Gaufrette filesystems

Installation
============

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require simettric/gaufrette-to-liip-imagine-bundle "dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Configuration
==============
An example of a resolver configuration:

        # app/config/services.yml
        
        app.storage.resolver:
           class: Simettric\Gaufrette2LiipImagineBundle\Resolver\LiipGaufretteResolver
            
           #@gaufrette.{filesystem_name}_filesystem
           arguments: ['@gaufrette.media_cache_filesystem', '%google.storage_prefix_url%', '%cache_dir_name%']
           tags:
               - {  name: "liip_imagine.cache.resolver", resolver: "gaufrette_resolver" }
        
        
        
        # app/config/config.yml
        
        liip_imagine:
           filter_sets:
               cache: ~
               avatar:
                   cache: gaufrette_resolver
                   quality: 75
                   filters:
                       relative_resize: { widen: 400 }
                       
                       
        knp_gaufrette:
            stream_wrapper: ~
            adapters:
                cache_google:
                    google_cloud_storage:
                        service_id:  'app.google_cloud_storage.service'
                        bucket_name: '%google.storage_bucket_name%'
                        options:
                            directory: %cache_dir_name%
            filesystems:
                media_cache:
                    adapter:  cache_google
