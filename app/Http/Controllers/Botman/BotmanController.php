<?php
//moditifed by : Arlan Joliansa Ndruru 11950111676 2023

namespace App\Http\Controllers\Botman;

use App\Conversations\helpDeskC3;
use App\Conversations\helpDeskPMB;
use App\Conversations\helpDeskUKT;
use App\Conversations\helpDeskIraise;
use App\Conversations\resetEmailMahasiswa;
use App\Conversations\resetEmailDosen;
use App\Conversations\nimUKT;
use App\Conversations\resetElearning;
use App\Conversations\resetPresensia;
use App\Conversations\SalahMatkul;
use App\Conversations\LateKRS;
use App\Conversations\ResetIraise;
use App\Conversations\FormatMessage;
use App\Conversations\MenuNavigasi;
use App\Conversations\FormatMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\Middleware\DialogFlow\V2\DialogFlow;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Drivers\DriverManager;


class BotmanController extends Controller
{

    public function handle()
    {

        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        $config = [
                // Your driver-specific configuration
                "telegram" => [
                   "token" => "6108829370:AAG7ezdH2f2fxpFp2CfQZXXo2uxphkbCOvE"
                ]
            ];

        $botman = app('botman');



        //*latest
            putenv('GOOGLE_CLOUD_PROJECT=chatbot-nlp11950111676');
            putenv('GOOGLE_APPLICATION_CREDENTIALS=chatbot-nlp11950111676-a617ceb0897f.json');



            $dialogflow = DialogFlow::create('en');
            $botman->middleware->received($dialogflow);
            $botman->hears('(.*)', function (BotMan $bot) {
                $extras = $bot->getMessage()->getExtras();
                $apiReply = $extras['apiAction'];
                if($apiReply == 'input_welcome')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                elseif($apiReply == 'intro_message')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->startConversation(new MenuNavigasi());
                }
                elseif($apiReply == 'format_pesan')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new FormatMessages());
                }
                elseif($apiReply == 'reset_email_nav')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new resetEmailMahasiswa());
                }
                elseif($apiReply == 'reset_email')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                elseif($apiReply == 'reset_elearning')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new resetElearning());
                }
                elseif($apiReply == 'reset_email_dosen_nav')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new resetEmailDosen());
                }
                elseif($apiReply == 'reset_email_dosen')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                elseif($apiReply == 'reset_iraise')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new ResetIraise());
                }
                elseif($apiReply == 'telat_krs')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new LateKRS());
                }
                elseif($apiReply == 'salah_matkul')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new SalahMatkul());
                }
                elseif($apiReply == 'reset_presensia')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new resetPresensia());
                }
                elseif($apiReply == 'helpdesk_permasalahan_iraise')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                elseif($apiReply == 'helpdesk_permasalahan_iraise_nav')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new helpDeskIraise());
                }
                elseif($apiReply == 'Helpdesk_c3')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new helpDeskC3());
                }
                elseif($apiReply == 'helpdesk_c3_nav')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new helpDeskC3());
                }
                elseif($apiReply == 'nim_ukt_nav')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new nimUKT());
                }
                elseif($apiReply == 'nim_nf_ukt')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                elseif($apiReply == 'ptipdc3nim_nfound.ptipdc3nim_nfound-next')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new nimUKT());
                }
                elseif($apiReply == 'helpdesk_pmb')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new helpDeskPMB());
                }
                elseif($apiReply == 'Helpdesk_UKT')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new helpDeskUKT());
                }
                elseif($apiReply == 'pengajuan_umum')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                    $bot->startConversation(new FormatMessages());
                }
                elseif($apiReply == 'closed_intent')
                {
                    $apiReply = $extras['apiReply'];
                    $bot->reply($apiReply);
                }
                else
                {
                    if ($apiReply == 'input.unknown') {
                        $apiReply = $extras['apiReply'];
                        $bot->reply($apiReply);
                    } else {
                        $bot->reply('intent tidak ditemukan');
                    }

                }
            })->middleware($dialogflow);

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    public function askName($botman)
    {
        $botman->reply(' ');
    }

}
