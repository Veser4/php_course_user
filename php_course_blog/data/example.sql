
INSERT INTO post (title, subtitle, content)
VALUES ('Первая статья', 'С подзаголовком', 'И даже содержание есть'),
       ('Вторая статья', '', 'Тоже с содержанием')
;

SELECT *
FROM post;

SELECT
  id,
  title,
  subtitle,
  content,
  posted_at
FROM post;


SELECT
  id,
  title,
  subtitle,
  content,
  posted_at
FROM post WHERE title = 'Первая статья';

