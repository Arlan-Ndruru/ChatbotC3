<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class LateKRS extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Permasalahan terkait Keterlambatan mengisi Kartu Rencana Studi (KRS) sesuai jadwal?')
		->addButtons([
			Button::create('Lihat')->value('yes'),
			Button::create('Tidak')->value('no'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Apabila sudah terlambat mengisi KRS itu tidak bisa lagi kembali dibuka, karena sudah menjadi jadwal ketetapan dan prosedur dari Universitas dan fakultas masing-masing.',['parse_mode' => 'HTML']);
                $this->say('Apabila ingin mengajukan permohonan terlambat pengisian KRS, silahkan mendatangi langsung Kantor Bagian Akademik Universitas, dengan membawa surat yang di tanda tangani oleh Dekan atau Wakil Dekan fakultas.',['parse_mode' => 'HTML']);
                $this->askReason1();
            }
            else{
                $this->say('Terima kasih, Proses Dibatalkan.  <i>Jika anda berubah pikiran, silahkan ketik untuk melihat permasalahan terkait Keterlambatan Mengisi KRS</i> -> <b>/Telat_KRS </b>', ['parse_mode'=>'HTML']);
            }
        });
    }

    public function askReason1()
    {
        $question = Question::create('Apakah Permasalahan Sudah terjawab?')
        ->addButtons([
            Button::create('Teratasi')->value('yes'),
            Button::create('Belum')->value('no'),
        ]);

        $this->ask($question, function(Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Terima Kasih, Senang bisa membantu. Wassalamualaikum.');
            } else {
                $this->say('Maaf, Untuk saat ini, Mengatasinya dengan mengajukan permohonan terlambat pengisian KRS, lalu silahkan mendatangi langsung Kantor Bagian Akademik Universitas, dengan membawa surat yang di tanda tangani oleh Dekan atau Wakil Dekan fakultas. Terima Kasih',['parse_mode' => 'HTML']);
            }

        });
    }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
