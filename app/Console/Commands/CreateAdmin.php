<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'make:admin {name} {email} {password}';

    protected $description = 'Commande console pour la creation d\'un super administrateur.';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));


        // Créer l'utilisateur
        $user = User::firstOrCreate([
            'name' => $name,
            'email' => $email,
            'password' => $password,

        ]);

        $this->info("Administrateur créé : {$user->name} ({$user->email}) ");
    }
}
