<?php

/**
 * Наследование от классов внешних либ
 */

/**
 * Класс внешней либы, либо интерфейс
 */
class NotificationSender
{
    public function sendSms()
    {

    }

    public function sendPush()
    {

    }

    public function sendEmail()
    {

    }

    public function sendMessageTelegram()
    {

    }
}

/**
 * Если мы сделаем через наследование и добавим свой метод, то есть вероятность того, что в самой либе может появиться
 * такой же метод, но с другой сигнатурой, в результате минорное обновление либы приведет к ошибке в проекте
 * Также зачем нам весь функционал, если мы используем только два?
 * По-хорошему же нужно тогда тесты под весь функционал писать
 */
class MyNotification extends NotificationSender
{
    public function sendSmsAndPush()
    {

    }
}

/**
 * Лучше сделать интерфейс того, что нам необходимо и адаптер под него, в который инъектим либу
 */
interface CorrectNotificationInterface
{
    public function sendSmsAndPush(): void;
}

class MyCorrectNotification implements CorrectNotificationInterface
{
    private NotificationSender $notificationSender;

    public function __construct(NotificationSender $notificationSender)
    {
        $this->notificationSender = $notificationSender;
    }

    public function sendSmsAndPush(): void
    {
        $this->notificationSender->sendSms();
        $this->notificationSender->sendPush();
    }
}

/**
 * В результате мы тесты только под это пишем, также мы зависим только от двух методов NotificationSender
 * Если либа сделана по SOLID (в этом случае буква I), тогда скорей всего она предоставляет под каждый метод интерфейс, а не один общий на все методы
 * Тогда ещё лучше, мы зависим от конкретных интерфейсов, не зная ничего более даже в самом адаптере
 * Вот как это может выглядеть
 */
interface SendSmsInterface
{
    public function sendSms();
}

interface SendPushInterface
{
    public function sendPush();
}

class NotificationBySolidSender implements SendSmsInterface, SendPushInterface
{
    public function sendSms()
    {
        // TODO: Implement sendSms() method.
    }

    public function sendPush()
    {
        // TODO: Implement sendPush() method.
    }
}

/**
 * Вот интеграция либы с нашей стороны
 */
interface SmsGatewayInterface
{
    public function send(string $phone, string $message): void;
}

class SmsGateway implements SmsGatewayInterface
{
    private SendSmsInterface $sms;

    public function __construct(SendSmsInterface $sms)
    {
        $this->sms = $sms;
    }

    public function send(string $phone, string $message): void
    {
        $this->sms->sendSms();
    }
}
/**
 * В результате мы ничего не знаем о возможностях либы, кроме как о SendSmsInterface, и зависим только от него
 * Если другие интерфейсы исчезнут/изменятся/сломаются у либы, а этот останется жив, то нас это не затронет
 */