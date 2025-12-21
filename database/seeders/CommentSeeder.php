<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a demo user first if not exists
        $user = User::firstOrCreate(
            ['email' => 'demo@atomfood.com'],
            [
                'name' => 'Demo Kullanıcı',
                'password' => bcrypt('password'),
                'phone' => '5551234567',
            ]
        );

        $comments = [
            [
                'user_id' => $user->id,
                'product_id' => 1,
                'comment_text' => 'Çok lezzetli bir çorba, kesinlikle tavsiye ederim!',
                'rating' => 5,
                'helpful' => 10,
            ],
            [
                'user_id' => $user->id,
                'product_id' => 3,
                'comment_text' => 'Anneannemin yaptığı gibi, harika!',
                'rating' => 5,
                'helpful' => 8,
            ],
            [
                'user_id' => $user->id,
                'product_id' => 5,
                'comment_text' => 'Pide çok lezzetli, hamuru harika!',
                'rating' => 5,
                'helpful' => 12,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
