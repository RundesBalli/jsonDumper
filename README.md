# jsonDumper
Simple JSON dumper with token and file listing.  
Because the use of the dumper is intended only for oneself, and is not intended to use it publicly, any stylization was abandoned.

## Dependencies
Install the dependencies via:  
`sudo apt install php-json -y`

## Install
Clone the repository, rename `config.template.php` to `config.php`, edit the config file and make the `dumps` directory writeable.
```shell
git clone https://github.com/RundesBalli/jsonDumper.git
cd jsonDumper
mv includes/config.template.php includes/config.php
nano includes/config.php
chmod 0777 public/dumps
```
Configure your webserver, that the public directory is open to the web, but not the includes directory.

## Use
The dumper accepts any raw json input and dumps it to the `public/dumps` directory.

You can use the dumper with your configured token:  
`https://example.com/dumper.php?token=$token`

To see all dumps you can go to:  
`https://example.com/showDumps.php?token=$token`
