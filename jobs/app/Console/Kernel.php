<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Jobs\SendPosts;
use App\Models\Page;
use App\Models\Post;
use App\Models\State;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $time = time();
            $minute = $time - ($time % 60);

            //pegar nos posts que estao para ser enviados com 20 min de atraso
            $posts = Post::where('sendStatus', Post::SCHEDULED)
                ->where('send_time', '<=', $minute)
                ->where('send_time', '>=', ($minute - env('PROCESSING_TIME')))
                ->get();

            foreach ($posts as $post) {
                dispatch(new SendPosts([
                    'id' => $post->id,
                    'message' => $post->message,
                    'PageID' => $post->page->FbID,
                    'PageAccessToken' => $post->PageAccessToken,
                ]));
                $post->sendStatus = Post::PROCESSING;
                $post->startProcessing = $minute;

                $post->save();
            }

            $failedPosts = Post::where(function ($query) use ($minute) {
                $query::where('sendStatus', Post::SCHEDULED) //todos os que estao agendados mas com atraso maior que 20 min
                    ->where('send_time', '<', ($minute - env('PROCESSING_TIME')));
            })->orWhere(function ($query) use ($minute) {
                $query::where('sendStatus', Post::PROCESSING) //todos os que estao em processamento a mais de 20 min
                    ->where('startProcessing', '<', ($minute - env('PROCESSING_TIME')));
            })
                ->get();

            foreach ($failedPosts as $failed) {
                $failed->sendStatus = Post::ERROR;
                $failed->save();
            }
        })
            ->description('Enviou o Post ' . date("Y-m-d h:i:sa"))
            ->everyMinute();
    }
}
