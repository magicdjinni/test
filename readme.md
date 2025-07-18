Предистория заключается в том что после интервью я захотел произвести нормальное впечатление 
и сделать "красиво". в итоге не успел доделать задачу полностью. Как вы можете увидеть 
что бы произвести положительное впечатление я выполнил основной функционал в стиле модульного
монолита. разнес контексты, использовал symfony messenger для плавности. реализовал cqrs 1 типа.
value object, dto-шки и прочее. Вообщем хотел показать красиво и по уму. В итоге в конце уже просто
засунул тикеты к клиентам. сущности есть - круды все рабочие. коллекция для постмена на всякий случай есть.
не успел подкрутить redis потому что пока писал не придумал а потом уже спешил. тестов тоже нет.
опять же спешил. статистику на ui тоже не успел вывести. 
но если предполагалось проверить как я пишу sql то вот:

statistics total by day, week: tickets, resume session sum :

    SELECT
    COUNT(t.ulid) AS tickets_sold,
    SUM(ms.price) AS total_revenue
    FROM ticket t
    JOIN moviesession ms ON t.movie_session_ulid = ms.ulid
    WHERE t.status = 'purchased'
    AND t.sold_date >= NOW() - INTERVAL (1 - 7) DAY;

statistics total by visitor: tickets (buy/cancel), sums :

    SELECT
    v.ulid AS visitor_ulid,
    v.email,
    
    COUNT(CASE WHEN t.status = 'purchased' THEN 1 END) AS purchased_count,
    SUM(CASE WHEN t.status = 'purchased' THEN ms.price ELSE 0 END) AS purchased_sum,
    
    COUNT(CASE WHEN t.status = 'cancelled' THEN 1 END) AS cancelled_count,
    SUM(CASE WHEN t.status = 'cancelled' THEN ms.price ELSE 0 END) AS cancelled_sum
    
    FROM visitor v
    LEFT JOIN ticket t ON t.visitor_ulid = v.ulid
    LEFT JOIN moviesession ms ON t.movie_session_ulid = ms.ulid
    
    GROUP BY v.ulid, v.email
    ORDER BY purchased_sum DESC;

бек ковырял сам. ui с чатиком.
в остальном можно смотреть - получилось не совсем уж плохо)
127.0.0.1 protonix.test - в хостах прописать
docker-compose up
migrations

дальше на ui в movies заводим фильмы -> создаем сеансы в sessions 
-> создаем пользователей -> в ticket логинимся и букаем билеты. там же отменяем.

Спасибо за ваше время и внимание.
