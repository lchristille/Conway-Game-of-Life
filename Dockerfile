FROM php:8.2-cli
COPY ./src /usr/src/game-of-life
WORKDIR /usr/src/game-of-life
CMD [ "php", "./index.php" ]