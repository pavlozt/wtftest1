# Тестовое задание nginx

Тестовый стенд имитирует цепочку nginx в интернете, хотя одним лишь docker-compose имитировать несколько серверов сложно.

Будем считать, что IP клиента - это IP шлюза docker. В данном стенде  этот IP фиксированный и задается как свойство явно объявленной сети docker - `172.28.0.1`

## Команды тестирования

Ззапускаем стенд:
```
docker compose up
```

Запускаем команды:
```
$ curl http://localhost:8081
X-Forwarded-For: 172.28.0.1, 172.28.0.11, 172.28.0.12
$ curl  http://localhost:8082
X-Forwarded-For: 172.28.0.1, 172.28.0.12
$ curl  http://localhost:8083
X-Forwarded-For: 172.28.0.1
```

Теперь имитируем злонамеренного клиента, передающего в заголовке `1.1.1.1`:
```
$ curl -H "X-Forwarded-For: 1.1.1.1" http://localhost:8083
X-Forwarded-For: 172.28.0.1
$ curl -H "X-Forwarded-For: 1.1.1.1" http://localhost:8082
X-Forwarded-For: 172.28.0.1, 172.28.0.12
$ curl -H "X-Forwarded-For: 1.1.1.1" http://localhost:8081
X-Forwarded-For: 172.28.0.1, 172.28.0.11, 172.28.0.12
```

Заголовок не передается.