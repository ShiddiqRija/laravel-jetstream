<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Models\User;
use App\Services\ReactPHPFolder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use React\EventLoop\Factory;
use React\Socket\Server;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Message;

class IMAPIdleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:imap-idle-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {

            $users = User::all();

            foreach ($users as $user) {
                $cm = new ClientManager($options = []);

                $client = $cm->make([
                    'host'          => $user->imap_host,
                    'port'          => 993,
                    'encryption'    => 'tls',
                    'validate_cert' => true,
                    'username'      => $user->email,
                    'password'      => $user->imap_password,
                    'protocol'      => 'imap'
                ]);

                $client->connect();

                $folder = $client->getFolderByName('Inbox');

                $messages = $folder->query()->all()->get()->reverse()->paginate(2);
                $msgId = 0;

                foreach ($messages as $message) {
                    $msgId = ($msgId < $message->uid) ? $message->uid : $msgId;

                    $message = $folder->query()->getMessage($msgId);

                    if ($this->checkData($message->uid, $user->id)) {
                        $this->store($message, $user);
                    }
                }
            }
        }


        // $cm = new ClientManager($options = []);

        // $client = $cm->make([
        //     'host'          => 'outlook.office365.com',
        //     'port'          => 993,
        //     'encryption'    => 'tls',
        //     'validate_cert' => true,
        //     'username'      => 'shiddiq.rija@outlook.com',
        //     'password'      => '@Shiddiq1',
        //     'protocol'      => 'imap'
        // 'host'          => Auth()->user()->imap_host,
        // 'port'          => 993,
        // 'encryption'    => 'tls',
        // 'validate_cert' => true,
        // 'username'      => Auth()->user()->email,
        // 'password'      => Auth()->user()->imap_password,
        // 'protocol'      => 'imap'
        // ]);
        // try {
        //     $client->connect();
        // } catch (ConnectionFailedException $e) {
        //     Log::error($e->getMessage());
        //     return 1;
        // }

        // /** @var Folder $folder */
        // try {
        //     $folder = $client->getFolder('Inbox');
        // } catch (ConnectionFailedException $e) {
        //     Log::error($e->getMessage());
        //     return 1;
        // } catch (FolderFetchingException $e) {
        //     Log::error($e->getMessage());
        //     return 1;
        // }

        // try {
        //     $folder->idle(function($message){
        //         $this->onNewMessage($message);
        //     });
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        //     return 1;
        // }

        // $client->connection->idle();

        // return 0;
    }

    /**
     * Callback used for the idle command and triggered for every new received message
     * @param Message $message
     */
    public function onNewMessage(Message $message)
    {
        $this->info("New message received: " . $message->subject);
    }

    public function checkData($id, $userId)
    {
        $checking = Email::where('id', $id)->where('user_id', $userId)->first();

        if ($checking) {
            $this->info('Email exists in user id : ' . $userId);
            return false;
        }

        return true;
    }

    public function store(Message $message, $user)
    {
        try {
            Email::create([
                'id'            => $message->uid,
                'from_name'     => $message->getFrom()[0]->personal,
                'from_email'    => $message->getFrom()[0]->mail,
                'subject'       => $message->getSubject(),
                'body'          => $message->getHTMLBody(true),
                'type'          => 'inbox',
                'user_id'       => $user->id,
            ]);
            $this->info('Email Added');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
