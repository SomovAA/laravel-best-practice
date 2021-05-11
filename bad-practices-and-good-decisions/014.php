<?php

/**
 * YAGNI
 */

/**
 * Задача - нужна генерация pdf из doc, docx, и т.д.
 *
 * Вот хорошее решение
 */
interface DocumentGeneratorInterface
{
    public function generatePdfByPathname(string $pathname): StreamInterface;

    public function generatePdfByStream(StreamInterface $stream): StreamInterface;

    public function generatePdfByString(string $string): StreamInterface;
}
/**
 * Некоторые передают путь до файла или директории, название файла, размер, расширение...
 * и метод превращается в боль при использовании клиентом.
 *
 * Тут вы передали путь до файла и получили stream в generatePdfByPathname.
 *
 * Либо вы файл берете к примеру из вне, получая stream,  и передаете его далее в generatePdfByStream,
 * и на выходе получаете stream с pdf.
 *
 * Если вы хотите отправить кому-то фразу 'Пошел ты'), и чтобы это письме не попало в бан из-за ненормативной лексики,
 * пожалуйста, сгенерируйте pdf с этой фразой xD - хотя на самом деле сам считаю это лишним.
 *
 * Т.е. клиенту использование этих методов будет простейшим, все ситуации с неадекватностью переданных аргументов
 * разрешаются в самой реализации. Мы же можем из файла вытащить расширение, из его названия или из его мета-данных?
 * Да! Зачем нам на клиента это перекладывать?
 *
 * Т.е. если вам в будущем понадобится какой-то дополнительный метод, вы его доделаете и это будет легко по той причине,
 * что уже интеграция сделана, посмотреть в реализацию и допилить не так сложно.
 */