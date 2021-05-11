<?php

/**
 * YAGNI
 *
 * Была задача - для хранения документов, фоток и других файлов необходимо интегрироваться с S3
 *
 * Эти проблемы не были оговорены:
 * Проблема первая: не учли, забыли, или сам бизнес не поставил стоп правило заранее - документы никогда не удаляем.
 * Проблема вторая: гибкость, какая она должна быть? Мы должны иметь возможность в разных хранилищах хранить документы.
 * Проблема третья: если нам понадобится из одного хранилища в другое перекинуть, мы не должны столкнуться с проблемами.
 *
 * Т.к. эти проблемы не были обсуждены, то решение получилось таким
 */
interface FilesStorageServiceInterface
{
    public function upload(StorageType $storage, string $dir, string $filename, string $sourceFilepath): File;

    public function uploadStream(StorageType $storage, string $dir, string $originalFilename, StreamInterface $inputStream): File;

    public function download(string $fileId, string $destinationFilepath): string;

    public function openStream(string $fileId): StreamInterface;

    public function remove(string $fileId): void;

    public function setTTL(string $fileId, int $seconds): void;

    public function getInfo(string $fileId): File;
}

/**
 * Сама реализация под капотом работала со всеми хранилищами...S3Client, localClient, fakeClient
 * В результате поддерживать это очень сложно, объект раздувается, чем больше хранилищ, тем больше раздутия, и все они
 * инициализировались сразу же...был написан весь функционал и тесты
 * Также за этим кроется множество свойств у объектов, чтобы была возможность осуществить этот функционал,
 * множество классов, и это работа не только с хранилищем, а ещё же записи в БД хранятся и а репозитории там тоже лишние операции...
 * Представьте себе делать code-review для этого
 *
 * После выявления проблем и обсуждений, было понятно, что решение имеет проблемы в архитектуре, также имеет лишний функционал
 * Далее появились вот такие интерфейсы и реализация для них
 */
interface TwoVariantFilesStorageServiceInterface
{
    public function storage(): FileStorageFactoryInterface;

    public function info(string $fileId): File;
}

interface FileStorageFactoryInterface
{
    public function fake(): FileStorageClientInterface;

    public function local(): FileStorageClientInterface;

    public function s3(): FileStorageClientInterface;
}

interface FileStorageClientInterface
{
    public function put(StreamInterface $stream, string $filepath): File;

    public function get(string $fileId): StreamInterface;
}

/**
 * Чувствуете как стало мало методов и параметров в них?
 * Многие параметры ушли, т.к. мы данные можем достать из самого файла или stream-а.
 * В чистом коде про это говорится, чем меньше параметров в методах, тем лучше...
 *
 * Получилось хорошо, но всё ещё не то
 * При добавлении или удалении хранилища нам придется изменять интерфейс FileStorageFactoryInterface
 * что является плохой практикой, т.е. у нас должна быть возможность самим выбирать то хранилище, которое мы хотим,
 * при этом не меняя интерфейс, также нам бы хотелось, чтобы мы инициализировали объект хранилища только тогда, когда
 * нам нужно его использовать
 *
 * Вот, что получилось в итоге
 */
interface ThreeVariantFilesStorageServiceInterface
{
    public function storage(string $storage): FileStorageClientInterface;

    public function info(string $fileId): File;
}

interface ThreeVariantFileStorageClientInterface
{
    public function put(StreamInterface $stream, string $filepath): File;

    public function get(string $fileId): StreamInterface;
}

interface ThreeVariantFileStorageFactoryInterface
{
    public function create(string $storage): FileStorageClientInterface;
}
/**
 * $storage = local, s3, fake
 * FileStorageFactoryInterface инъектится в FilesStorageServiceInterface,
 * чтобы через фабрику в зависимости от БД инициализировать нужное хранилище на лету, т.к. мы заранее не знаем с каким
 * хранилищем будем работать, мы достаем из БД запись, в которой хранится тип хранилища, и создаем на лету
 */