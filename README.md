# SimettricGaufrette2LiipImagineBundle

With this Bundle you can define resolvers in order to store the liip image cache files in Gaufrette filesystems.


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

### Step 1: Define your gaufrette filesystem in order to store the LiipImagine cache files

You can use one of the gaufrette adapters for doing this, you can store the files in Amazon s3, Azure, Dropbox, Google Storage, even a FTP/sFTP server.

        # app/config/config.yml
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
                    
### Step 2: Define your resolver service using a gaufrette filesystem

        # app/config/services.yml
        
        app.storage.resolver:
           class: Simettric\Gaufrette2LiipImagineBundle\Resolver\LiipGaufretteResolver
            
           #@gaufrette.{filesystem_name}_filesystem
           arguments: ['@gaufrette.media_cache_filesystem', '%google.storage_prefix_url%', '%cache_dir_name%']
           tags:
               - {  name: "liip_imagine.cache.resolver", resolver: "gaufrette_resolver" }
        
### Step 3: Using that resolver to store your thumbnail files

You can configure it in order to store the cache files in that filesystem as default

        # app/config/config.yml
        
        liip_imagine:
           filter_sets:
               cache: gaufrette_resolver
               
Or you can specify in which filter do you want to use that filesystem. 
This is useful in scenarios where do you want to use different filesystems to store your thumbnail images.
        
        # app/config/config.yml
        
        liip_imagine:
           filter_sets:
               cache: ~
               avatar:
                   cache: gaufrette_resolver
                   quality: 75
                   filters:
                       relative_resize: { widen: 400 }
                       
                       

Filtering remote images
====================

You can also apply LiipImagine filters to images stored in remote urls with a simple remote data loader included in this bundle.
To get it working, you need to set it in your liip_imagine configuration

        # app/config/config.yml
        liip_imagine:
            data_loader: sim_gau2liip_remote_loader
            
            
        # in your twig template
        
        {{ "https://domain.com/image.png"|imagine_filter('your_filter') }}
        

