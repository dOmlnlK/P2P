<?php

namespace App\Http\Middleware;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;
use Closure;

class EmailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rs = $next($request);

        $mail = new Message;
        $mail->setFrom('Dick <scc1056@163.com>')
            ->addTo($request->email)
            ->setSubject('hello')
            ->setBody("你好啊，大兄弟");

        $mailer = new SmtpMailer([
            'host' => 'smtp.163.com',
            'username' => 'scc1056',
            'password' => 'qqq111'
//            'secure' => 'ssl',
//            'context' =>  [
//                'ssl' => [
//                    'capath' => '/path/to/my/trusted/ca/folder',
//                ],
//            ],
        ]);
        $mailer->send($mail);

        return $rs;
    }
}
