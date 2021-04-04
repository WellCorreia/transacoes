<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Services\NotificationService;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if(is_null($this->id)){
                throw new \Exception("Error Processing Request");
            }
            
            $response = json_decode(Http::get(env('EXTERNAL_NOTIFICATION_SERVICE'))->body(), true);

            if ($response['message'] == 'Enviado') {
                $notification = app(NotificationService::class)->findById($this->id);
            
                $createdNotification = [
                    'type' => $notification['notification']['type'],
                    'reference_id' => $notification['notification']['reference_id'],
                    'data' => $notification['notification']['data'],
                    'status' => 'completed',
                ];
                app(NotificationService::class)->update($createdNotification, $this->id);
                return true;
            }

            NotificationJob::dispatch($this->data);
        } catch (\Exception $th) {
            NotificationJob::dispatch($this->data);
            echo $th->getMessage();
        }
    }
}
