<?php

namespace App\Notifications;

use App\Models\MsgUser as ModelsMsgUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class MsgUser extends Notification //implements ShouldQueue
{
    use Queueable;

    private $mensagem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ModelsMsgUser $mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user = User::where('id', $this->mensagem->remetente)->first();
        if(!empty($user->avatar) && Storage::exists($user->avatar)){
            $user->avatar = Storage::url($user->avatar);
        } else {
            if($user->genero == 'masculino'){
                $user->avatar = url(asset('backend/assets/images/avatar5.png'));
            }elseif($user->genero == 'feminino'){
                $user->avatar = url(asset('backend/assets/images/avatar3.png'));
            }else{
                $user->avatar = url(asset('backend/assets/images/image.jpg'));
            }
        }
        return [
            'assunto' => $this->mensagem,
            'link' => route('mensagens.index'),
            'user' => $user
        ];
    }
}
