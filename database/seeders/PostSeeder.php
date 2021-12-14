<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carPosts = [
            [
                'title' => 'New Genesis G90 interior is bold, colorful and packed with decadence',
                'content' => "The all-new Genesis G90 flagship sedan was revealed a couple weeks ago, but all that was shown was the outside. Now the company has revealed not only the interior, but a bunch of the car's features.
                Among those details is what will power the G90. It will use a twin-turbocharged 3.5-liter V6 coupled to an eight-speed automatic transmission. The company didn't provide any additional details, but it will likely make 375 horsepower, as the engine does in the G80 sedan. Rear-wheel and all-wheel drive will probably be available, too."
            ],
            [
                'title' => '2022 Hyundai Ioniq 5 price starts at $40,925 before incentives',
                'content' => "We recently drove the 2022 Hyundai Ioniq 5, and our full first drive review is coming later this week. One piece of information we didn’t have at the time was its price. Now, Hyundai has announced Ioniq 5 pricing for all three trims in both rear- and all-wheel drive, along with pricing for the standard-range version that will arrive later. Pricing starts at $40,925, which includes $1,225 in destination fees, but doesn’t account for the available $7,500 federal tax credit or other local incentives."
            ],
            [
                'title' => 'Ram partners with Lucchese on a range of luxury boots',
                'content' => "A few months ago, Ram announced a partnership with Michigan-based Wolverine boots on a range of work boots based on the Ram 1500 Tradesman, Rebel, and Limited trims. The number two full-size truckmaker so far this year in sales isn't finished with footwear, Ram announcing a range of dress boots in collaboration with Texas-based boot company Lucchese. There are five styles in total, three for men, two for women. Since these Western-themed cowboy specials are based on the $58,565 10th Anniversary Limited Longhorn Edition, which lives at the opposite end of the trim range to Tradesman, the Lucchese models can cost more than 10 times the Wolverines. Whereas the entry-level Wolverine Tradesman cost $229, the top-dog Lucchese men's Tooled Western Boot runs $2,495."
            ]
        ];

        $airPosts = [
            [
                'title' => 'Field Equipment for Glow Engine Powered Model Airplanes',
                'content' => "The field equipment needed varies depending on how your aircraft is powered. The list below shows what's typically needed to fly a glow engine powered model. For convenience, most modelers store this gear in a 'flight box' caddy for easy carrying. Except for fuel, most of the items are one-time purchases. You can use them for a lifetime, with as many different models as you fly."
            ],
            [
                'title' => 'Best Beginner RC Planes for 2020!',
                'content' => "Looking for the Best Beginner RC Plane? In this edition of Horizon Insider, we revisit our lineup and select the two best planes to begin your flying adventure with! Updated for 2020, this video features the updated E-flite Apprentice STS 1.5m and the new HobbyZone AeroScout S 1.1m."
            ],
            [
                'title' => 'E-flite® Twin Otter 1.2m PNP & BNF Basic Airplane (includes floats)',
                'content' => "E-flite® Twin Otter 1.2m PNP & BNF Basic Buying Guides"
            ]
        ];

        foreach ($carPosts as $key => $data) {
            $post = Post::firstOrCreate([
                'title' => $data['title'],
                'content' => $data['content']
            ]);

            $post->categories()->attach(Category::firstOrCreate(['name' => 'Cars'])->id);
        }

        foreach ($airPosts as $key => $data){
            $post = Post::firstOrCreate([
                'title' => $data['title'],
                'content' => $data['content']
            ]);

            $post->categories()->attach(Category::firstOrCreate(['name' => 'Airplanes'])->id);
        }
    }
}
