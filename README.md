# Oogle, клон поисковика по типу гугла

Топорная реализация, никакого mvc здесь нет и в помине.

Поиск производится по sql запросу LIKE %слово_запроса%, большой вариативности выборки
ждать не стоит.

Файл crawler.php предназначен для парсинга картинок и сайтов,
для последующего добавления в бд. В данном примере вставлен сайт BBC

Есть поиск по сайтам, есть поиск по картинкам.

Внимание, без инета страница может не открыться, JS библиотеки подключаются
через CDN.

Верстка выполнена на флексах. 

Пойдет для какой-нибудь курсовой.
