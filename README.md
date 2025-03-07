# Setup
- Build docker image: `docker build -t yii_app .`
- Start docker containers: `docker-compose up -d`
- Check if containers have started properly: `docker ps`
- Connect to app docker container: `docker exec -it yii_app /bin/bash`
- Install vendors `php ./composer.phar install`
- Run migrations: `php yii migrate`