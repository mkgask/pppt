
## paiza php power tool

You will already know, ***It does not guarantee success in paiza***

### PHP 7.0.8 with Alpine in Docker

Install and setup [Docker](https://www.docker.com/).
File Sharing settings to your docker directory for docker.

```
docker-compose up -d
docker exec -ti pppt_php_1 sh
/storage/pppt /storage/paiza/x001
```

And cic is file create tool input-*.txt and check-*.txt each directory

```
/storage/cic /storage/paiza/x001 5
```

This command is create between input-1.txt, input-5.txt, check-1.txt and check-5.txt in paiza/x001 directory.
Writing the contents yourself.
