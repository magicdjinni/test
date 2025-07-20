
127.0.0.1 protonix.test - в hosts или в конфиге nginx поправить мапинг. мне удобно когда на 80й дома смотрит

docker-compose up -d --build
docker-compose run --rm protonix-services php bin/console doctrine:migrations:migrate
docker-compose run --rm protonix-services install

в папке protonixdata коллекция для postman и дампы таблиц(если вруг лень вбивать ручками)

sql-ки - в src/src/Statistic/Infrastructure/Repository если хотите посмотреть.

в воскресенье под чаек допилил что не успел в пятницу. так что теперь выглядит куда более пригодным.
вдохновившись интервью - старался делать по ddd подходу - модульный монолит с разбивкой логики, cqrs и т.д.

не сделал только behat сценарий. уж больно давно я с ним работал. надо будет покурить его если что.

Спасибо за ваше время и внимание.
