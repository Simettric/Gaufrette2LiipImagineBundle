# GaufretteLiipImageResolverBundle
With this Bundle you can define resolvers in order to store the liip image cache files in Gaufrette filesystems


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